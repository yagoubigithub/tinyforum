<?php  
$tf_host='localhost';
$tf_dbname='tinyforum';
$tf_username = 'root';
$tf_password = '';
/*
$tf_handle = @mysqli_connect($tf_host,$tf_username,$tf_password);
if(!$tf_handle){
    die('connection Failed');
}

$tf_db_result=@mysqli_select_db($tf_dbname);
if(!$tf_db_result){
    @mysqli_close($tf_handle);
    die('selection Failed');
}
die('OK');
@mysqli_close($tf_handle);
*/

// Create connection
$tf_handle = mysqli_connect($tf_host, $tf_username, $tf_password,$tf_dbname);

// Check connection
if (!$tf_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

//die('OK');
//@mysqli_close($tf_handle);
mysqli_query($tf_handle,"SET NAMES 'utf8");

function tinyf_db_close(){
    global $tf_handle;
    mysqli_close($tf_handle);
}

?>
