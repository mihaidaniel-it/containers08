<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../site/modules/database.php';

// Unit-тесты класса Database (работа с базой данных SQLite)
class DatabaseTest extends TestCase
{
    private Database $db;

    // Выполняется перед каждым тестом: создаем новую базу в памяти
    // и заполняем ее из sql/schema.sql (таблица page с тремя страницами)
    protected function setUp(): void
    {
        $this->db = new Database(':memory:');
        $this->db->Execute(file_get_contents(__DIR__ . '/../sql/schema.sql'));
    }

    // Count: после создания базы в таблице page 3 записи
    public function testCount(): void
    {
        $this->assertEquals(3, $this->db->Count('page'));
    }

    // Fetch: SELECT возвращает все строки таблицы
    public function testFetch(): void
    {
        $rows = $this->db->Fetch('SELECT * FROM page');

        $this->assertCount(3, $rows);
    }

    // Create: новая запись добавляется в таблицу и получает следующий id
    public function testCreate(): void
    {
        $id = $this->db->Create('page', ['title' => 'Test', 'content' => 'Test content']);

        $this->assertEquals(4, $id);
        $this->assertEquals(4, $this->db->Count('page'));
    }

    // Read: возвращает запись по id
    public function testRead(): void
    {
        $page = $this->db->Read('page', 1);

        $this->assertEquals('Page 1', $page['title']);
        $this->assertEquals('Content 1', $page['content']);
    }

    // Update: изменяет поля записи
    public function testUpdate(): void
    {
        $this->db->Update('page', 1, ['title' => 'New title']);

        $this->assertEquals('New title', $this->db->Read('page', 1)['title']);
    }

    // Delete: удаляет запись, после этого Read возвращает null
    public function testDelete(): void
    {
        $this->db->Delete('page', 1);

        $this->assertNull($this->db->Read('page', 1));
        $this->assertEquals(2, $this->db->Count('page'));
    }
}
