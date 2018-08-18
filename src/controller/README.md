
# 严重bug

- 怎么避免url访问非页面控制器的方法，如：success/redirect/getModelAndView等等/特别是接口约束必须公开的方法
- 包括_\_construct/_\_destruct/_\_call等等魔术方法

- yii:actionLogin/action开头的才能作为页面控制器
- spring:@Controller注解
- thinkphp:控制操作的访问权限为非public

- 子类重写禁止为public|beforeAction/afterAction/actionName
- 系统公共方法禁止调用|Controller/Component/MagicMethod

