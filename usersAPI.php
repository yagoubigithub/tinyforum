<?php


/***********************************************************
$tf_host='localhost';
$tf_dbname='tinyforum';
$tf_username = 'root';
$tf_password = '';



$tf_handle = mysqli_connect($tf_host, $tf_username, $tf_password,$tf_dbname);

// Check connection
if (!$tf_handle) {
    die("Connection failed: " . mysqli_connect_error());
}

//die('OK');
//@mysqli_close($tf_handle);
mysqli_query($tf_handle,"SET NAMES 'utf8");

****************************************************************/ 


function tinyf_users_get($extra = ''){
    global $tf_handle;
    $query=sprintf("SELECT * FROM `users` %s",$extra);
    $qresult=mysqli_query($tf_handle,$query);

    if(!$qresult)
    return NULL;

    $rcount  = mysqli_num_rows($qresult);

    if($rcount == 0)
    return NULL;

    $users = array();
    for($i = 0; $i < $rcount; $i++){
       $users[count($users)]= mysqli_fetch_object($qresult);
    }
    mysqli_free_result($qresult);
    return $users;
}


function tinyf_users_get_by_id($uid){
    $id = (int)$uid;

    if($id == 0)
    return NULL;
 $result = tinyf_users_get('WHERE id = '.$id);
 if($result == NULL){
     return NULL;
 }
 $user = $result[0];
 return $user;

}

function tinyf_users_add($name,$password,$email,$isadmin){
    global $tf_handle;
    if(!((empty($name))  || (empty($password)) || (empty($email)) || (empty($isadmin)))){
        echo "is empty";
        return false;
    }
       

   $n_name = mysqli_real_escape_string($tf_handle,strip_tags($name));
   $n_email = mysqli_real_escape_string($tf_handle,strip_tags($email));
   $n_pass =md5(@mysqli_real_escape_string($tf_handle,strip_tags($password)));
   $n_isadmin =(int)$isadmin;
   $query  = sprintf("INSERT INTO `users` VALUES (NULL,'%s','%s','%s',%d)",$n_name,$n_pass,$n_email,$n_isadmin);
   $qresult = mysqli_query($tf_handle,$query);
   if(!$qresult){
       echo "is null";
    return false;
   }
      
    echo "is added";

   return true;
}

function tinyf_users_delete($uid){
    global  $tf_handle;
    $id= (int)$uid;
    if($id == 0){
        echo "is zero";
        return false;

    }
    $query = sprintf("DELETE FROM `users` WHERE `id`= %d",$id);
    $qresult = mysqli_query($tf_handle,$query);
    if(!$qresult){
        echo "is null";
     return false;
    }      
     
    return true;
}


function tinyf_users_update($uid,$name = NULL,$password = NULL,$email = NULL,$isadmin = 0){
    global  $tf_handle;
    $id= (int)$uid;
    $n_isadmin = (int)$isadmin;
    if($id == 0){
        echo "is zero";
        return false;
    }
    $user = tinyf_users_get_by_id($id);
    if(!$user){
        echo "no user with this id";
        return false;
    }
    if((empty($name))  && (empty($password)) && (empty($email)) && ($user->isadmin == $n_isadmin)){

        return false;
    }
    $fields =array();
    $query = 'UPDATE `users` SET ';

    if((!empty($name))){
        $n_name = mysqli_real_escape_string($tf_handle,strip_tags($name));
        $fields[count($fields)] = " `name` = '$n_name'";
    }
    if((!empty($password))){
        $n_pass = md5(mysqli_real_escape_string($tf_handle,strip_tags($password)));
        $fields[count($fields)] = " `password` = '$n_pass'";
    }
    if((!empty($email))){
        $n_email = mysqli_real_escape_string($tf_handle,strip_tags($email));
        $fields[count($fields)] = " `email` = '$n_email'";
    }
    $fields[count($fields)] = " `isadmin` = '$isadmin'";

    $fcount =count($fields);
    if($fcount == 1){
        $query .= $fields[0]." WHERE `id` = ".$id;
        $qresult = mysqli_query($tf_handle,$query);
        if(!$qresult){
            return false;
        }else{
            return true;
        }
    }
    for($i = 0;$i<$fcount;$i++){
        $query.=$fields[$i].' ';
        if($i != ($fcount -1 )){
            $query .= ' , ';

        }
    }
    $query .= " WHERE `id` = ".$id;
    $qresult = mysqli_query($tf_handle,$query);
    if(!$qresult){
        return false;
    }else{
        return true;
    }
}

?>