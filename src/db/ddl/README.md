
# 表结构 库 设计

# DDL(Data Definition Language)

数据库模式定义语言


```
SHOW DATABASES                                //列出 MySQL Server 数据库。
SHOW TABLES [FROM db_name]                    //列出数据库数据表。
SHOW CREATE TABLES tbl_name                    //导出数据表结构。
SHOW TABLE STATUS [FROM db_name]              //列出数据表及表状态信息。
SHOW COLUMNS FROM tbl_name [FROM db_name]     //列出资料表字段
SHOW FIELDS FROM tbl_name [FROM db_name]，DESCRIBE tbl_name [col_name]。
SHOW FULL COLUMNS FROM tbl_name [FROM db_name]//列出字段及详情
SHOW FULL FIELDS FROM tbl_name [FROM db_name] //列出字段完整属性
SHOW INDEX FROM tbl_name [FROM db_name]       //列出表索引。
SHOW STATUS                                  //列出 DB Server 状态。
SHOW VARIABLES                               //列出 MySQL 系统环境变量。
SHOW PROCESSLIST                             //列出执行命令。
SHOW GRANTS FOR user                         //列出某用户权限


SHOW DATABASES
# 列出数据库数据表。
SHOW TABLES [FROM db_name]
# 当前数据库名称
select database();
```
