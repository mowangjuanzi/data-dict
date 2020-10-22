<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__ . "/vendor/autoload.php";

$database = "";

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => '',
    'database'  => 'information_schema',
    'username'  => '',
    'password'  => '',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();

// 查看都是有那些表

$tables = Capsule::table("TABLES")->where("TABLE_SCHEMA", $database)->get();

echo "[TOC]\n\n";

foreach ($tables as $key => $table) {
    echo "## ". ($key + 1) .". {$table->TABLE_NAME} {$table->TABLE_COMMENT} \n基本信息 {$table->ENGINE} {$table->TABLE_COLLATION}\n\n";

    // 查询表字段
    $columns = Capsule::table("COLUMNS")->where("TABLE_SCHEMA", $database)->where("TABLE_NAME", $table->TABLE_NAME)->get();

    echo "|序列|列名|类型|可空|默认值|注释|\n|:------:|:------:|:------:|:------:|:------:|:------:|\n";
    foreach ($columns as $column_key => $column) {
        echo "|". ($column_key + 1) ."| {$column->COLUMN_NAME} {$column->EXTRA}|{$column->COLUMN_TYPE}|{$column->IS_NULLABLE}|{$column->COLUMN_DEFAULT}|{$column->COLUMN_COMMENT}|\n";
    }
echo "\n";
    // 查询索引
    $indexs = Capsule::table("STATISTICS")->where("TABLE_SCHEMA", $database)->where("TABLE_NAME", $table->TABLE_NAME)->get();

    echo "|序列|索引名|类型|包含字段|\n|:------:|:------:|:------:|:------:|\n";
    foreach ($indexs as $index_key => $index) {
        echo "|" . ($index_key + 1) . "|{$index->INDEX_NAME}|{$index->INDEX_TYPE}|{$index->COLUMN_NAME}|\n";
    }
echo "\n";
}
