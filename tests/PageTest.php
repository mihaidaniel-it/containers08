<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../site/modules/page.php';

// Unit-тесты класса Page (вывод страницы по шаблону)
class PageTest extends TestCase
{
    // Render: вместо {{title}} и {{content}} в шаблон подставляются данные страницы
    public function testRender(): void
    {
        $page = new Page(__DIR__ . '/../site/templates/index.tpl');

        $html = $page->Render(['title' => 'Test title', 'content' => 'Test content']);

        $this->assertStringContainsString('<title>Test title</title>', $html);
        $this->assertStringContainsString('<h1>Test title</h1>', $html);
        $this->assertStringContainsString('<p>Test content</p>', $html);
    }
}
