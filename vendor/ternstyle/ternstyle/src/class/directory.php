<?php
////////////////////////////////////////////////////////////////////////////////////////////////////
//
//		File:
//			directory.php
//		Description:
//			Dealing with directories
//		Version:
//			1.0
//		Copyright:
//			Copyright (c) 2019 Ternstyle LLC.
//		License:
//			The license for this software is called ternstyle-license.rtf and  is included within this plugin.
//
////////////////////////////////////////////////////////////////////////////////////////////////////

namespace ternstyle;

/****************************************Commence Script*******************************************/

/*------------------------------------------------------------------------------------------------
	For good measure
------------------------------------------------------------------------------------------------*/

class tern_dir {

	function __construct() {
		return $this;
	}
	function list($b) {

		$b = array_merge(array(
			'dir'	=>	'/',
			'rec'	=>	false,
			'flat'	=>	true,
			'depth'	=>	'*',
			'ext'	=>	false
		),$b);
		$b['dir'] = substr($b['dir'],-1) != '/' ? $b['dir'].'/' : $b['dir'];

		if(@is_dir($b['dir'])) {
			$a = array();
			if($p = @opendir($b['dir'])) {
				while(($f = @readdir($p)) !== false) {
					$n = $b['dir'].$f;
					$slug = preg_replace("/\.".implode('|',$b['ext'])."/",'',$f);
					if(is_file($n) && !$this->is_hidden_file($f) && (!$b['ext'] || $this->is_ext($n,$b['ext']))) {
						$a[$slug] = $n;
					}
					elseif(is_dir($n) and $f != '.' and $f != '..' and $b['rec'] and ($b['depth'] == '*' or $b['depth'] != 1)) {
						$x = array_merge($b,array('dir'=>$n.'/','depth'=>$b['depth'] !== '*' ? ($b['depth']-1) : $b['depth']));
						if($b['flat']) {
							$a = array_merge($a,$this->list($x));
						}
						else {
							$a[$slug] = $this->list($x);
						}
					}
				}
				closedir($p);
				return $a;
			}
		}
		return [];
	}
	public function include($dir='') {
		if(empty($dir)) {
			return false;
		}

		$l = (new tern_dir())->list([
			'dir'	=>	$dir,
			'rec'	=>	false,
			'flat'	=>	true,
			'depth'	=>	1,
			'ext'	=>	['php']
		]);

		foreach((array)$l as $k => $v) {
			require_once($v);
		}
	}
	function is_ext($n,$e) {
		$s = substr($n,strrpos($n,'.')+1);
		if(in_array($s,$e)) {
			return true;
		}
		return false;
	}
	function is_hidden_file($f) {
		if(substr($f,0,1) == '.') {
			return true;
		}
		return false;
	}

}

/****************************************Terminate Script******************************************/
?>
