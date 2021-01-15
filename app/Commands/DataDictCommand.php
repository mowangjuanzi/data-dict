<?php
namespace App\Commands;

use Medoo\Medoo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

class DataDictCommand extends Command
{
    protected static $defaultName = "data-dict";

    protected function configure()
    {
        $this->addOption("host", null, InputOption::VALUE_REQUIRED, "Database Host", "")
            ->addOption("user", null, InputOption::VALUE_REQUIRED, "Database User", "root")
            ->addOption("password", null, InputOption::VALUE_REQUIRED, "Database Password", "")
            ->addOption("database", null, InputOption::VALUE_REQUIRED, "Database Name", "")
            ->addOption("port", null, InputOption::VALUE_REQUIRED, "Database Port", 3306);
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper("question");

        // 获取 host
        $host = $input->getOption("host");
        if (empty($host)) {
            $question = new Question("what is your database host?(default: localhost)\n> ", "localhost");
            $host = $helper->ask($input, $output, $question);
        }

        // 获取端口
        $port = $input->getOption("port");
        if (empty($port)) {
            $question = new Question("what is your database port?(default: 3306)\n> ", 3306);
            $port = $helper->ask($input, $output, $question);
        }

        // 获取数据库名称
        $database = $input->getOption("database");
        if (empty($database)) {
            $question = new Question("what is your database name?(default: '')\n> ", "");
            $database = $helper->ask($input, $output, $question);
        }

        // 获取用户名
        $user = $input->getOption("user");
        if (empty($user)) {
            $question = new Question("what is your database user?(default: root)\n> ", "root");
            $user = $helper->ask($input, $output, $question);
        }

        // 获取密码
        $password = $input->getOption("password");
        if (empty($password)) {
            $question = new Question("what is your database password?(default: '')\n> ", "");
            $password = $helper->ask($input, $output, $question);
        }

        // 获取POD实例
        $instance = new Medoo([
            "database_type" => "mysql",
            "database_name" => "information_schema",
            "server" => $host,
            "username" => $user,
            "password" => $password,

            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
            'port' => $port,
        ]);

        $tables = $instance->select("TABLES", ["TABLE_NAME", "TABLE_COMMENT", "ENGINE", "TABLE_COLLATION"], ["TABLE_SCHEMA" => $database]);

        foreach ($tables as $key => $table) {
            // 表描述
            echo "## ". ($key + 1) .". {$table['TABLE_NAME']} {$table['TABLE_COMMENT']} \n基本信息 {$table['ENGINE']} {$table['TABLE_COLLATION']}\n\n";

            // 字段 table
            $columns = $instance->select("COLUMNS", [
                "COLUMN_NAME", "EXTRA", "COLUMN_TYPE", "IS_NULLABLE", "COLUMN_DEFAULT", "COLUMN_COMMENT"
            ], ["TABLE_SCHEMA" => $database, "TABLE_NAME" => $table['TABLE_NAME']]);

            echo "|序列|列名|类型|可空|默认值|注释|\n|:------:|:------:|:------:|:------:|:------:|:------:|\n";
            foreach ($columns as $column_key => $column) {
                echo "|". ($column_key + 1) ."| {$column['COLUMN_NAME']} {$column['EXTRA']}|{$column['COLUMN_TYPE']}|{$column['IS_NULLABLE']}|{$column['COLUMN_DEFAULT']}|{$column['COLUMN_COMMENT']}|\n";
            }

            echo "\n";

            $table['TABLE_NAME'] = "chef_pag_more";

            // 索引 index
            $indexes = $instance->select("STATISTICS", [
                "INDEX_NAME", "NON_UNIQUE", "INDEX_TYPE", "COLUMN_NAME", "INDEX_COMMENT"
            ], ["TABLE_SCHEMA" => $database, "TABLE_NAME" => $table['TABLE_NAME']]);

            echo "|序列|索引名称|索引方法|包含字段|注释|\n|:------:|:------:|:------:|:------:|:------:|\n";
            foreach ($indexes as $index_key => $index) {
                echo "|" . ($index_key + 1) . "|{$index['INDEX_NAME']}| ". ($index['NON_UNIQUE'] == "0" ? 'UNIQUE' : $index['INDEX_TYPE']) ." |{$index['COLUMN_NAME']}|{$index['INDEX_COMMENT']}|\n";
            }

            echo "\n";
        }

        return Command::SUCCESS;
    }
}
