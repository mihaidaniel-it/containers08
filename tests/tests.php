<?php

require_once __DIR__ . '/testframework.php';

require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../modules/database.php';
require_once __DIR__ . '/../modules/page.php';

$tests = new TestFramework();

function testDbConnection()
{
    global $config;
    $db = new Database($config["db"]["path"]);
    return assertExpression($db != null);
}

function testDbCount()
{
    global $config;
    $db = new Database($config["db"]["path"]);
    return assertExpression($db->Count("page") >= 3);
}

function testDbCreate()
{
    global $config;
    $db = new Database($config["db"]["path"]);
    $id = $db->Create("page", ["title" => "Test", "content" => "Test"]);
    return assertExpression($id > 0);
}

$tests->add('Connection', 'testDbConnection');
$tests->add('Count', 'testDbCount');
$tests->add('Create', 'testDbCreate');

$tests->run();
echo $tests->getResult();