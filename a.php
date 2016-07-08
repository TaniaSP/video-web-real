<?php
$folder = "/home/u373017502/public_html/videos/";
if (is_uploaded_file($HTTP_POST_FILES['filename']['tmp_name']))  {
	echo $nombre=$HTTP_POST_FILES['filename']['tmp_name'];
    if (move_uploaded_file($HTTP_POST_FILES['filename']['tmp_name'], $folder.$HTTP_POST_FILES['filename']['name'])) {
         Echo "File uploaded";
		 echo $nombre;
    } else {
         Echo "File not moved to destination folder. Check permissions";
    };
} else {
     Echo "File is not uploaded.";
}; 
?>