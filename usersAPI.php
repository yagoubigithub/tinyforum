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
?>