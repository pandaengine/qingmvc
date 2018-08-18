

/**
	 * 路径格式
	 * - %ctrl%/%user%
	 * - %user%
	 * 
	 * - views\ctrl\action
	 * - views\ctrl
	 * - views\ctrl\自定义
	 * - views\自定义
	 *
	 * @var string
	 */
	public $format='%ctrl%/%format%';
	/**
	 * 视图为空时默认的路径格式
	 * - %ctrl%/%action%
	 * - %ctrl%
	 * 
	 * @var string
	 */
	public $formatDef='%ctrl%/%action%';
	
	//只处理当前语法拥有的占位符
		$sql=preg_replace_callback('/\%([0-9a-z-_]+)\%/i',function($matches){
			$field=$matches[1];
			//#根据语法顺序排序绑定的参数
			$this->sortBindings($field);
			$getter='get'.ucfirst($field);
			return $this->$getter();
		},$sqlGrammar);
		
		/**
	 * @return string
	 */
	protected function f_views(){
		return '';
	}
	/**
	 * @return string
	 */
	protected function f_ctrl(){
		return '';
	}
	/**
	 * @return string
	 */
	protected function f_action(){
		return '';
	}