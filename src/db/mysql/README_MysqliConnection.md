public function query02(){
	// 查询结果集中的行数,来自select返回的$result对象
	$num_rows=$result->num_rows;
	$this->setNumRows($num_rows);
	
	dump($list);
	//重置指针到起始
	$result->data_seek(0);
	$list=$result->fetch_all(MYSQLI_BOTH);
	dump($list);
	exit();
	
	return $list;
	$list=array();
	// 如果有数据则返回 fetch_assoc|以关联数组返回
	if($num_rows>0){
		for($i=0;$i<$num_rows;$i++){
			 //以关联数组返回|字段和字段值关联|associative
			$list[$i]=$result->fetch_assoc();
			//以索引数组返回|数字索引和字段值关联
			$list[$i]=$result->fetch_row();
			//索引数组，关联数组两种数据类型
			$list[$i]=$result->fetch_array();
			//把数据映射的相应的对象|默认为stdClass
			$list[$i]=$result->fetch_object();
			$list[$i]=$result->fetch_assoc();
		}
	}
	return $list;
}
