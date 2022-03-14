# markdown版数据字典

#### 介绍

PHP生成Markdown版本的数据字典

#### 软件架构

通过读取 `information_schema` 表获取相关信息

#### 使用说明

获取帮助：

```bash
% php data-dict.phar --help
Usage:
  data-dict [options]

Options:
      --host=HOST          Database Host [default: ""]
      --user=USER          Database User [default: "root"]
      --password=PASSWORD  Database Password [default: ""]
      --database=DATABASE  Database Name [default: ""]
      --port=PORT          Database Port [default: 3306]
  -h, --help               Display help for the given command. When no command is given display help for the data-dict command
  -q, --quiet              Do not output any message
  -V, --version            Display this application version
      --ansi|--no-ansi     Force (or disable --no-ansi) ANSI output
  -n, --no-interaction     Do not ask any interactive question
  -v|vv|vvv, --verbose     Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
```

使用以下命令下载最新包

```bash
wget https://github.com/mowangjuanzi/data-dict/releases/download/v0.1/data-dict.phar 
```

执行以下命令即可：

```bash
php data-dict.phar
```

这里需要注意的是需要填写数据库参数。也可以使用以下命令：

```bash
php data-dict.phar --host=host --database=database --user=user --password=password
```
