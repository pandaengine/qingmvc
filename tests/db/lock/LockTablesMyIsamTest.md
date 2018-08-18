
# lock tables write

- 其他线程不可访问，更不可写
- 当前线程可以访问，可以写
- 提供当前线程写

# LOCK TABLES table READ

- 其他线程可以读取，不可更新
- 当前线程可以读取，不可更新
- 都不可更新，只提供读取

```
SHOW FULL PROCESSLIST;
+----+------+-----------------+--------+---------+------+------------------------------+--------------------------------------------------------+----------+
| Id | User | Host            | db     | Command | Time | State                        | Info                                                   | Progress |
+----+------+-----------------+--------+---------+------+------------------------------+--------------------------------------------------------+----------+
| 15 | root | localhost:11505 | NULL   | Sleep   | 4621 |                              | NULL                                                   |        0 |
| 16 | root | localhost:11510 | qtests | Sleep   | 3448 |                              | NULL                                                   |        0 |
| 18 | root | localhost:11534 | qtests | Sleep   | 2742 |                              | NULL                                                   |        0 |
| 30 | root | localhost:11676 | qtests | Query   |    0 | init                         | SHOW FULL PROCESSLIST                                  |        0 |
| 31 | root | localhost:11679 | qtests | Sleep   |  722 |                              | NULL                                                   |        0 |
| 32 | root | localhost:11708 | qtests | Sleep   |   21 |                              | NULL                                                   |        0 |
| 33 | root | localhost:11709 | qtests | Sleep   |   21 |                              | NULL                                                   |        0 |
| 34 | root | localhost:11710 | qtests | Query   |   21 | Waiting for table level lock | UPDATE `pre_tests_myisam` SET `title`='222' WHERE id=1 |        0 |
+----+------+-----------------+--------+---------+------+------------------------------+--------------------------------------------------------+----------+
8 rows in set

mysql> SHOW FULL PROCESSLIST;
+-----+------+-----------------+--------+---------+-------+---------------------------------+---------------------------------------------+----------+
| Id  | User | Host            | db     | Command | Time  | State                           | Info                                        | Progress |
+-----+------+-----------------+--------+---------+-------+---------------------------------+---------------------------------------------+----------+
| 175 | root | localhost:12152 | qtests | Query   |    28 | Waiting for table metadata lock | SELECT * FROM `pre_tests_myisam` WHERE id=1 |        0 |
+-----+------+-----------------+--------+---------+-------+---------------------------------+---------------------------------------------+----------+

```

# 锁定表会有好处

但是，在几种情况下，锁定表会有好处：

- 如果您正在对一组MyISAM表运行许多操作，锁定您正在使用的表，可以快很多。
	锁定MyISAM表可以加快插入、更新或删除的速度。
	- 不利方面是，没有线程可以更新一个用READ锁定的表（包括保持锁定的表），
	- 也没有线程可以访问用WRITE锁定的表（除了保持锁定的表以外）。
---

- 如果您正在使用MySQL中的一个不支持事务的存储引擎，
	则如果您想要确定在SELECT和UPDATE之间没有其它线程，您必须使用LOCK TABLES。
	本处所示的例子要求LOCK TABLES，以便安全地执行：

`
mysql> LOCK TABLES trans READ, customer WRITE;
mysql> SELECT SUM(value) FROM trans WHERE customer_id=some_id;
mysql> UPDATE customer
 ->     SET total_value=sum_from_previous_statement
 ->     WHERE customer_id=some_id;
mysql> UNLOCK TABLES;
`

- 如果没有LOCK TABLES，有可能另一个线程会在执行SELECT和UPDATE语句之间**在trans表中插入一个新行**。
