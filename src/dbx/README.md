
# dbx

db ext 扩展功能

`
'interceptors'=>
[
	'qing\dbx\DbBackupInterceptor'
],
'interceptors'=>
[
	'db.backup'=>
	[
		'class'=>'qing\dbx\DbBackupInterceptor',
		'dataOn'=>true,
		'databaseAll'=>true,
		'limitRows'=>20
	]
],
`