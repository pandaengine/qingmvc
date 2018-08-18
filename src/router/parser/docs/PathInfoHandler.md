PathInfo解析器|和RParser类似

---
# 有模块

index.php/:u/index/index
index.php/:u/index
index.php/:u

# 无模块

index.php/index/index
index.php/index

---
index.php?r=/u:login/index
index.php?r=/u:/login/index
index.php?r=/u:	|只有模块
index.php?r=/login/index|没有模块
---
index.php?r=/:u/index/index
index.php?r=:u
---
index.php?r=login/index&m=u |无意义|和get雷同