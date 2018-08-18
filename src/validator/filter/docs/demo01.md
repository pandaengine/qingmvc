$txt='<b>“支付宝”将提现收费 每人2万基础免费额度</b> 《》 111 是的是的 || >> \ _ % "" \'\' ';

dump($txt);

// 		$txt=f_safetext($txt,['like'=>false]);
// 		dump($txt);

$txt=f_sql($txt,['like'=>true]);

dump($txt);