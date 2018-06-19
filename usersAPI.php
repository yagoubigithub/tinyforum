<?php

function tinyf_users_get($extra = ''){
    global $tf_handle;
    $query=sprintf("SELECT * FROM `users` %s",$extra);
    $qresult=@mysqli_query($query);

    if(!$qresult)
    return NULL;

    $rcount  = @mysqli_num_rows($qresult);

    if($rcount == 0)
    return NULL;

    $users = array();
    for($i = 0; i < $rcount; $i++){
       $users[count($users)]= @mysqli_fetch_object($qresult);
    }
    $mysqli_free_result($qresult);
    return $users;
}
$u=tinyf_users_get();
die('OK');


function tinyf_users_get_by_id($uid){
    $id = (int)$uid;

    if($id == 0)
    return NULL;
 $result = tinyf_users_get('WHERE id = '.$uid);
 if($result == NULL){
     return NULL;
 }
 $user = $result[0];

}

function tinyf_users_add($name,$password,$email,$isadmin){
    global $tf_handle;
    if((empty($name))  || (empty($password)) || (empty($email)) || (empty($isadmin)))
       return false;

   $n_name = @mysqli_real_escape_string(strip_tags($name),$tf_handle);
   $n_email = @mysqli_real_escape_string(strip_tags($email),$tf_handle);
   $n_pass =@md5(@mysqli_real_escape_string(strip_tags($password),$tf_handle));
   $n_isadmin =(int)$isadmin;
   $query  = sprintf("INSERT INT `users` VALUES (NULL,'%s','%s','%s',%d)",$n_name,$n_pass,$n_email,$n_isadmin);
   $qresult = @mysqli_query($query);
   if(!$qresult)
      return false;

   return true;
}

?>