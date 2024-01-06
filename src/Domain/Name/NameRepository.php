<?php

declare (strict_types = 1);

namespace App\Domain\Name;

use PDO;

class NameRepository
{
    /**
     * @var Name[]
     */
    private array $names;

    /**
     * @var PDO The database connection
     */
    private $connection;

    /**
     * @param Name[]|null $names
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;

        $sth = $this->connection->prepare("
            SELECT
                id,
                name,
                category,
                liturgy,
                deleted,
                created_at,
                updated_at
            FROM names
            where liturgy >= NOW()
        ");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_CLASS);

        $this->names = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return array_values($this->names);
    }

    /**
     * {@inheritdoc}
     */
    public function findNameOfId(int $id): Name
    {
        $sth = $this->connection->prepare("SELECT * FROM names where id=$id");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_CLASS, Name::class);

        if (!isset($data[0])) {
            throw new NameNotFoundException();
        }

        return $data[0];
    }

    /**
     * {@inheritdoc}
     */
    public function createName(Name $name): string
    {
        $sth = $this->connection->prepare("
            Insert into names(
                name,
                category,
                liturgy
            ) values(
                :name,
                :category,
                :liturgy
            )
        ");

        $sth->execute([
            'name' => $name->name,
            'category' => $name->category,
            'liturgy' => $name->liturgy,
        ]);

        return $this->connection->lastInsertId();
    }

    public function updateName(Name $name): int
    {
        $sth = $this->connection->prepare("
            update names
                set
                name=:name,
                category=:category,
                liturgy=:liturgy
            where id=:id
        ");

        $sth->execute([
            'name' => $name->name,
            'category' => $name->category,
            'liturgy' => $name->liturgy,
            'id' => $name->id,
        ]);

        return $sth->rowCount();
    }

    public function deleteName(Name $name): int
    {
        $sth = $this->connection->prepare("update names set deleted=1 where id=:id");

        $sth->execute([":id" => $name->id]);

        return $sth->rowCount();
    }
}
