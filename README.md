# markdown版数据字典

#### 介绍

PHP生成Markdown版本的数据字典

#### 软件架构

通过读取 `information_schema` 表获取相关信息

#### 使用说明

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
