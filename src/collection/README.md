
集合
数据结构|structure

set/map 键值对
list列表


堆栈|stack：先进后出
队列|queue：先进先出


# IteratorAggregate：创建外部迭代器的接口。|可以使用foreach遍历属性

`
IteratorAggregate extends Traversable {
	abstract public Traversable getIterator ( void )
}
`

# ArrayAccess：提供像访问数组一样访问对象的能力的接口。

`
ArrayAccess {
	abstract public boolean offsetExists ( mixed $offset )
	abstract public mixed offsetGet ( mixed $offset )
	abstract public void offsetSet ( mixed $offset , mixed $value )
	abstract public void offsetUnset ( mixed $offset )
}
` 
 
# Countable： 统计一个对象的元素个数

当使用 count()函数作用于一个实现了 Countable的对象时这个方法会被执行.

 