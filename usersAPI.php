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
    
}
?>