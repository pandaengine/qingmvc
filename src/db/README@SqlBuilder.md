
sql builder
Grammar

预处理绑定参数类型
- 命名占位符        |name=:name
- 问号索引占位符|name=?

select * from tb where id=?
select * from tb where id=:id


#Sqlb:/每次查询均需要重构语法器/不能作为组件方式
