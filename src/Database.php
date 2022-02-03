<?php

namespace Blog;

use http\Exception\InvalidArgumentException;
use PDO;
use PDOException;

class Database
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
            $this->connection = $connection;
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}