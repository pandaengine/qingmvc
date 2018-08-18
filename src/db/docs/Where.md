SELECT * FROM `varchar_maxlen01` where name like '%av/%%' escape '/';
SELECT * FROM `varchar_maxlen01` where name like '%av\%%' escape '\\';


/**
 * 搜索/模糊查找条件
 * 
 * - '_' 单个字符通配符
 * - '%' 多个字符通配符
 * - addcslashes($value,'_%');
 * 
 * @param string $field     搜索的字段
 * @param string $value   	搜索关键字/要包含%_|'%'.$keyword.'%';
 * @param string $connector 连接符/and/or
 * @param string $operator  操作符/like/not like
 * @param string $escape   是否转义like相关字符/_:一个字符 %:多个字符
 * @return $this
 */
public function like($field,$value,$connector='and',$operator='like',$escape=false){
	return $this->set($field,$value,'like',$connector);
	/*
	$field=$this->getField($field);
	if($escape){
		//只填写搜索值，转义安全
		$keyword=addcslashes($keyword,'_%\'');
	}
	$keyword='%'.$keyword.'%';
	$keyword=$this->getValue($keyword,$field);
	$where="{$field} {$operator} {$keyword}";
	$this->push($where,$connector);
	return $this;
	*/
}