

# 命名占位符

`
$list=$model->where('name like :name1 or name like :name2 ')->params(array(':name1'=>'%"\'%',':name2'=>'%++%'))->select();
$sql='select * from pre_user where uid=:uid and name=:name ';
$list=$model->query($sql,array(':uid'=>16,':name'=>'xiaowang'));
`

# 问号占位符|键值从1开始

`
$list=$model->where('name like ? or name like ? ')->params(array(1=>'%"\'%',2=>'%++%'))->select();
`

`
/**
 * 绑定预处理
 * array_keys($values) !== range(0, sizeof($values) - 1)
 * 
 * # 预处理参数
 * - PDOStatement::bindParam  — 只能绑定变量
 * - PDOStatement::bindValue  — 可以绑定变量和值
 * # 绑定结果集到变量
 * - PDOStatement::bindColumn — 绑定一列到一个 PHP 变量
 * ---
 * - $sql=isprintf('select * from %s where id%s %s','bm_log_login','<=?','limit 0,10');
 * - $list=(array)$this->loginlog->query($sql,array(1=>20));
 * ---
 * # ?问号占位符|键值要从1开始
 * 
 * $sth = $dbh->prepare('SELECT name, colour, calories FROM fruit WHERE calories < :calories AND colour = :colour');
 * $sth->bindValue(':calories', $calories, PDO::PARAM_INT);
 * $sth->bindValue(':colour'  , $colour, PDO::PARAM_STR);
 * 
 * $sth = $dbh->prepare('SELECT name, colour, calories FROM fruit WHERE calories < ? AND colour = ? ');
 * $sth->bindValue(1, $calories, PDO::PARAM_INT);
 * $sth->bindValue(2, $colour, PDO::PARAM_STR);
 * 
 * SELECT name,id FROM table01 WHERE name < :name AND id = :id
 * SELECT name,id FROM table01 WHERE name < ? 	  AND id = ? 
 * 
 * @param array $params
 */
protected function bindValue(array $bindings)

/**
 * PDOStatement::rowCount—返回受上一个 SQL 语句影响的行数
 * PDOStatement::rowCount() 返回上一个由对应的 PDOStatement 对象执行DELETE、 INSERT、或 UPDATE 语句受影响的行数。
 * ---
 * 如果上一条由相关 PDOStatement 执行的 SQL 语句是一条 SELECT 语句，有些数据可能返回由此语句返回的行数。
 * 但这种方式不能保证对所有数据有效，且对于可移植的应用不应依赖于此方式。
 * ---
 * 对于大多数数据库，PDOStatement::rowCount() 不能返回受一条 SELECT 语句影响的行数。
 * 替代的方法是，使用 PDO::query() 来发出一条和原打算中的SELECT语句有相同条件表达式的 SELECT COUNT(*) 语句
 * ---
 * pdo:PDOStatement::rowCount()
 * 
 * @bug 不能保证对所有数据有效，且对于可移植的应用不应依赖于此方式|只提供建议的值，不一定正确
 * @deprecated
 * @see \qing\db\Connection::getAffectedRows()
 */
public function getAffectedRows(){
	return $this->PDOStatement->rowCount();
}
/**
 * 获取数据执行错误
 * 
 * dump($PDOStatement->errorCode());
 * dump($PDOStatement->errorInfo());
 * dump($conn->errorCode());
 * dump($conn->errorInfo());
 * 
 */
public function getError()

`

`
/*
if(version_compare(PHP_VERSION,'5.3.6','<=')){
	// 禁用模拟预处理语句
	$params[\PDO::ATTR_EMULATE_PREPARES]=false;
}*/
`

