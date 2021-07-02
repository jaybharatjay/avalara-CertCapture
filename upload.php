<?php
$username = 'jay.bharat';
$password = 'MY PASSWORD YOU HAVE to replace';
$cid = 'Basic '.base64_encode($username.':'.$password);
echo "<br>";

$base64 = '';
if(isset($_POST['doit'])=='saveFile'){
	
	
	


		$target_dir = "uploads/";
		$target_file = $target_dir . basename($_FILES["myUploadedFile"]["name"]);
		$uploadOk = 1;
		

		// Check if pdf file is a actual pdf or fake pdf
		

			$finfo = finfo_open(FILEINFO_MIME_TYPE);
			//echo "<br>MIME=".
			$mime = finfo_file($finfo, $_FILES['myUploadedFile']['tmp_name']);

		  
		 
		  if($mime == 'application/pdf') {
			
			$uploadOk = 1;
		  } else {
			echo "File is not an pdf.";
			$uploadOk = 0;
		  }
		
		// Check file size
		if($uploadOk){
			if ($_FILES["myUploadedFile"]["size"] > 2500000) {
				echo "Sorry, your file is too large.";
				$uploadOk = 0;
			  }	
		}
		
		
		//converting in base64 data 
		if($uploadOk){
			$data = file_get_contents($_FILES["myUploadedFile"]["tmp_name"]);
			$data = base64_encode($data);
			echo $base64 = $data;
		}
		
		
		
		/*
		// Check if file already exists
		if($uploadOk){
			if (file_exists($target_file)) {
				echo "Sorry, file already exists.";
				$uploadOk = 0;
			  }
		}
		

		
		

		

		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		  echo "<br>Sorry, your file was not uploaded.";
		// if everything is ok, try to upload file
		} else {
		  if (move_uploaded_file($_FILES["myUploadedFile"]["tmp_name"], $target_file)) {
			echo "<br>The file ". htmlspecialchars( basename( $_FILES["myUploadedFile"]["name"])). " has been uploaded.";
		  } else {
			echo "<br>Sorry, there was an error uploading your file.";
		  }
		}*/
		
		
		
	

}




?>
<?php
if($base64 !=''){
	//https://certcapture6xrest.docs.apiary.io/#reference/filtering/upload-certificate-pdf
	$post = "pdf=".$base64;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.certcapture.com/v2/certificates/1/upload-pdf");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	//curl_setopt($ch, CURLOPT_POSTFIELDS, pdf='YTIwNzViZWQtODMwMC0zZjE1LThhODYtMWI4NDg1MjljYmRhLnR4dA==');
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	  "x-client-id: 130995",
	  "Authorization: ".$cid,
	  "Content-Type: application/x-www-form-urlencoded"
	  //"Content-Type: application/json"
	));

	$response = curl_exec($ch);
	curl_close($ch);
	echo "<br><br><br><br><br>";
	var_dump($response);
}


?>
<br><br>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method='post' enctype="multipart/form-data">
  <input type='hidden' name='doit' value='saveFile'>
  <input type="file"  name="myUploadedFile">
  <input type="submit">
</form>
