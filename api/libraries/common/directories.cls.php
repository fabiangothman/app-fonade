<?php
	class directories
	{
		public function __construct()
		{
			
  	}
		public function find_files($search_str)
		{
			return glob($search_str);
		}
		
		public function verifyPath($basePath="", $fullPath="", $createDirs=false)
		{
			if(empty($fullPath)) return false;
			$resp = (!file_exists($fullPath) && !is_dir($fullPath))?false:true;
			
			if(!$resp && $createDirs) return mkdir($fullPath,777,true);
			else return $resp;
		}
		
		public function userHasFoto($basePath="", $id_user, $extension = "png")
		{			
			return file_exists($basePath.$id_user.".".$extension);
		}
	}
?>