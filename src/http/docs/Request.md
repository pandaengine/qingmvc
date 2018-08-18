
从用户请求中获取数据 input
$_REQUEST 默认情况下包含了 $_GET，$_POST 和 $_COOKIE 的数组。
此方法旨在过滤 通过 get post cookie提交的数据 ，提高系统安全性
--------------------------------------------------
获取安全的$_SERVER['PHP_SELF']
---------------------------
1.QUERY_STRING、REQUEST_URI自动编码了，安全|TODO 2015.07.05 解码后同样不安全，需要过滤
2.PATH_INFO、PHP_SELF自动解码url，不安全

$_SERVER['PHP_SELF']虽然是服务器提供的环境变量，但和 $_POST 与 $_GET 一样，
是可以被用户篡改的，均需要进行安全过滤,不能直接输出

防止XSS攻击
---------------------------
decodeURI('/index.php/Post/index/id/1/name/%3Cb%3EHOHO%3C/b%3E?id=320&b=%3Cb%3EHOHO%3C/b%3E');
/index.php/Post/index/id/1/name/<b>HOHO</b>?id=320&b=<b>HOHO</b>"

--------------

uri/url各段信息

parse_url('http://www.qingcms.com:80/index.php/login?name=xiaowang#not')
----------------------------------------
scheme:http|https
host  :www.qingcms.com
port  :80
path  :/index.php/login
query :?|name=xiaowang
fragment:#|not

