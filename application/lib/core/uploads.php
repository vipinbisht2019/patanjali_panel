<?php

class uplode {
	
public function uplodeSingleImages($files, $sizes, $uploaddir){
    
	$array = array();
	$error = 0;
	
	$valid_formats = array('jpg','jpeg','gif','png');
	
	$file_name = $files['name'];
	if(! in_array( $this->getExtension($file_name) , $valid_formats ) ) {
		$error  = 1;
		$error_msg[] = $this->getExtension($file_name).' file extension  not allowed!';
	}
	
	
	if($error==0){
		
			$file_name = $files['name'];
			$file_size = $files['size'];
			$file_type = $files['type'];
			$file_tmp_name = $files['tmp_name'];

			$uploaded_name = $this->createImageCopy($file_name, $file_tmp_name, $sizes, $uploaddir);
			
			$array = array(
					 'success'=> 1,
					 'name'=> $file_name,
					 'uploaded_name'=> $uploaded_name,
					 'type'=> $this->getExtension($file_name),
					 'size'=> $file_size
				);	
		
		return $array;
		
	} else {
		return array('success'=> 0, 'msg'=>$error_msg ); 
	}
} // END





public function uplodeExcel($files, $uploaddir){
    
	$array = array();
	$error = 0;
	
  $file_name = $files['name'];
	$valid_formats = array('xls','xlxs','xlsx','jpg','jpeg');
	
	if(! in_array( $this->getExtension($file_name) , $valid_formats ) ) {
		$error  = 1;
		$error_msg[] = $this->getExtension($file_name).' file extension  not allowed!';
	}

	if($error==0){
		
		  $file_name = $files['name'];
		  $file_size = $files['size'];
		  $file_type = $files['type'];
		  $file_tmp_name = $files['tmp_name'];
		  
		  $uploaded_name = $this->getFileName($file_name)."_".time() .".". $this->getExtension($file_name);
		  $is_move = move_uploaded_file($file_tmp_name, $uploaddir.$uploaded_name);
		  
		  if($is_move){
				$array = array(
						 'success'=> 1,
						 'name'=> $file_name,
						 'uploaded_name'=> $uploaded_name,
						 'type'=> $this->getExtension($file_name),
						 'size'=> $file_size
					);	
				   return $array;
				   
		 } else {
			  return array('success'=> 0, 'msg'=>'Error in uploading file.');   
		 }
		 
	} else {
		   return array('success'=> 0, 'msg'=>$error_msg ); 
	}
} // END

public function uplodeFile($files, $uploaddir){
    
	$array = array();
	$error = 0;
	
    $file_name = $files['name'];
	$valid_formats = array('jpg','jpeg','gif','png','pdf','doc','docx','xlx','xlxs','zip');
	
	if(! in_array( $this->getExtension($file_name) , $valid_formats ) ) {
		$error  = 1;
		$error_msg[] = $this->getExtension($file_name).' file extension  not allowed!';
	}

	if($error==0){
		
		  $file_name = $files['name'];
		  $file_size = $files['size'];
		  $file_type = $files['type'];
		  $file_tmp_name = $files['tmp_name'];
		  
		  $uploaded_name = $this->getFileName($file_name)."_".time() .".". $this->getExtension($file_name);
		  $is_move = move_uploaded_file($file_tmp_name, $uploaddir.$uploaded_name);
		  
		  if($is_move){
				$array = array(
						 'success'=> 1,
						 'name'=> $file_name,
						 'uploaded_name'=> $uploaded_name,
						 'type'=> $this->getExtension($file_name),
						 'size'=> $file_size
					);	
				   return $array;
				   
		 } else {
			  return array('success'=> 0, 'msg'=>'Error in uploading file.');   
		 }
		 
	} else {
		   return array('success'=> 0, 'msg'=>$error_msg ); 
	}
} // END



private function getFileName($file){
	list($txt,$ext)=explode(".",$file);
	$file=str_replace(' ', '_', $txt);
	$file = trim($file, '_');
	//$file = iconv('utf-8', 'us-ascii//TRANSLIT', $file);
	$file = stripslashes($file);
	$file = strtolower($file);
	return $file;
}

private function getExtension($str){
	$i = strrpos($str,".");
	if (!$i) { return ""; }
	$l = strlen($str) - $i;
	$ext = substr($str,$i+1,$l);
	$ext = strtolower($ext);
	return $ext;
}

private function createImageCopy($image, $temp_image, $sizes, $dir){
	
	  $extension = $this->getExtension($image);
	
	  $uploadedfile = $temp_image;
	  
	  if($extension=="jpg" || $extension=="jpeg" ) {
		$src = imagecreatefromjpeg($uploadedfile);
		
	  } else if($extension=="png") {
		$src = imagecreatefrompng($uploadedfile);
		imagealphablending($src, true);
		
	  } else  {
		$src = imagecreatefromgif($uploadedfile);
	  }
	  
	  list($width, $height) = getimagesize($uploadedfile);
	  
	  $new_image_name = md5(microtime()).'.'.$extension;
	  
	  $image_sizes = explode('|', $sizes);
	  foreach($image_sizes as $size){
		  
		    /*if($width > $height || $width==$height){
			  $newwidth1=$size;
			  $newheight1=($height/$width)*$newwidth1;
			} else {
		      $newheight1=$size;
			  $newwidth1=($height/$width)*$newheight1;
			}*/
			
			if($size=='org'){
				$newheight1 = $height;
				$newwidth1 = $width;
			} else {
			
				if($size < 480){
				  $newwidth1=$size;
				  $newheight1=($height/$width)*$newwidth1;
				} else {
					
					if($height > $width){
						$newheight1 = 600;
						$newwidth1 = ($width/$height)*$newheight1;
					} else {
						$newwidth1=$size;
						$newheight1=($height/$width)*$newwidth1;
					}
					
				}
			}
			
			$tmp=imagecreatetruecolor($newwidth1, $newheight1);
			
			if($extension=="png"){
			  imagealphablending($tmp, false);
			  imagesavealpha($tmp, true);
			}
			
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);

		
			$filename1 = $dir."/".$size."/$new_image_name";
			if($size=='org'){
				$filename1 = $dir."/$new_image_name";
			}

			
			if($extension=="png"){
			  imagepng($tmp, $filename1);
			} else {
			  imagejpeg($tmp, $filename1, 95);
			}
			
			imagedestroy($tmp);
      }
	  return $new_image_name;
}




	
} // END CLASS