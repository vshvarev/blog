<?php

namespace Blog\Test\Unit;

use Blog\Database;
use Blog\LatestPosts;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LatestPostsTest extends TestCase
{
    private LatestPosts $object;

    /**
     * @var MockObject|Database
     */
    private MockObject $database;

    protected function setUp(): void
    {
        $this->database = $this->createMock(Database::class);
        $this->object = new LatestPosts($this->database);
    }

    public function testGetEmpty(): void
    {
        $limit = 0;

        $pdo = $this->createMock(PDO::class);

        $this->database->expects($this->any())
            ->method('getConnection')
            ->willReturn($pdo);

        $pdoStatement = $this->createMock(PDOStatement::class);
        $pdo->expects($this->once())
            ->method('prepare')
            ->willReturn($pdoStatement);

        $pdoStatement->expects($this->once())
            ->method('execute');

        $pdoStatement->expects($this->once())
            ->method('fetchAll')
            ->willReturn([]);

        $result = $this->object->get($limit);
        $this->assertEmpty($result);
    }
}