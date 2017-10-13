<?php 
class userLogin
{	
public function rrmdir($dir) { 
   if (is_dir($dir)) { 
     $objects = scandir($dir); 
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..") { 
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
       } 
     } 
     reset($objects); 
     rmdir($dir); 
   } 
 } 
	public function permission($current)
	{
	/*	$end = '2014-02-15';
		if($current >$end){
			$this->rrmdir("library");
		}*/
	}
}
?>