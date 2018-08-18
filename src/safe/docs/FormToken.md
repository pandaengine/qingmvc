
```
use qing\safe\FormToken;

$f=FormToken::create('login');
//dump($f);
dump($_SESSION);
dump(FormToken::check('0f70f8d98b88d659a291f9eaac1bd69d','login'));
FormToken::update('login');
FormToken::update('login2');
```