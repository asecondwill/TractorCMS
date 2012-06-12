<?php

class DirectoryHelper extends Helper {
var $helpers = array('Html');

	
	function recursive($path, $sort = true, $exceptions = array()){
		$s ='';
		App::import('Utility', 'Folder');
		$folder = new Folder(ROOT . $path);
		
		$fs = $folder->read($sort, $exceptions);
		$s ="<ul class='directory'>";
		foreach ($fs[0] as $dir){
			$s .= "<li>$dir";
			$s .= $this->recursive($path . DS . $dir,$sort, $exceptions);
			$s .="</li>";
		}
		foreach ($fs[1] as $file){
		//	$target = urlencode("$path/$file");
			$target= str_replace("/", "|slash|", "$path/$file");
			$target= str_replace("|slash||slash|", "|slash|", $target);
//			debug($target);
			$s .="<li>";
			$s .= $this->Html->link($file, array('controller'=>'template', 'action'=>'admin_index', $target));
			$s .= "</li>";
		}
		$s.="</ul>";
		
		return $s;
	}
	
	function recursiveArray($path, $sort = true, $exceptions = array()){
		$s =array();
		$kids = null;
		App::import('Utility', 'Folder');
		$folder = new Folder(ROOT . $path);
		
		$fs = $folder->read($sort, $exceptions);
		//$s ="<ul class='directory'>";
		foreach ($fs[0] as $dir){
			$s[] = $dir;
			$kids = $this->recursive($path . DS . $dir,$sort, $exceptions);
			if(!emppty($kids)) $s[$dir] = $kids; 
			$kids = null;
		}
	
		foreach ($fs[1] as $file){
			$s[$file] = "$file";
		}

		
		
		return $s;
	}	

}