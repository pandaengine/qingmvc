
`
$array = array('AAA','CCC', 'aaa', 'BBB');
$array_lowercase = array_map('strtolower', $array);
$array_lowercase = [2,4,3,1];

dump($array_lowercase);
dump($array);

array_multisort($array_lowercase, SORT_ASC, SORT_STRING, $array);

dump($array_lowercase);
dump($array);
`