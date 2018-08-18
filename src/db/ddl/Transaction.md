
隔离级别						|脏读(Dirty Read) 	|不可重复读(NonRepeatable Read)	|幻读(Phantom Read)
--------------------------------|-------------------|-------|-----
未提交读(Read uncommitted)		|可能				|可能	|可能
已提交读(Read committed)		|不可能				|可能	|可能
可重复读(Repeatable read)		|不可能				|不可能	|可能
可串行化(Serializable)			|不可能				|不可能	|不可能
