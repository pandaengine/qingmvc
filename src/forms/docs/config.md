
`
'interceptors'=>
[
	'qing\tips\ModelsBuilderInterceptor',
	'qing\tips\TablesBuilderInterceptor',
	//
	'qing\forms\FilterBuilderInterceptor',
	'qing\forms\ValidatorBuilderInterceptor',
	//
	'forms.vlds'=>
	[
		'class'=>'\qing\forms\ValidatorBuilderInterceptor',
		//'tables'=>['note','notebook','style','cat','zones','recyclebin','attach','text','tag'],
		'tables'=>[]
	],
	'forms.filters'=>
	[
		'class'=>'\qing\forms\FilterBuilderInterceptor',
		'tables'=>[]
	],
],
	
`