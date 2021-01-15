# markdown版数据字典

#### 介绍
PHP生成Markdown版本的数据字典

#### 软件架构

通过读取 `information_schema` 表获取相关信息

#### 安装教程

1. 拉取代码
2. 执行 `composer install`

#### 使用说明

执行以下命令即可：

```bash
php artisan
```

这里需要注意的是需要填写数据库参数。也可以使用以下命令：

```bash
php artisan --host=host --database=database --user=user --password=password
```
