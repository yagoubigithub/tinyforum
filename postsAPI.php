<?php


/***********************************************************/
//POSTS API
/****************************************************************/


function tinyf_posts_get($extra = '')
{
    global $tf_handle;
    $query = sprintf("SELECT * FROM `posts` %s", $extra);
    $qresult = mysqli_query($tf_handle, $query);

    if (!$qresult)
        return null;

    $rcount = mysqli_num_rows($qresult);

    if ($rcount == 0)
        return null;

    $posts = array();
    for ($i = 0; $i < $rcount; $i++) {
        $posts[count($posts)] = mysqli_fetch_object($qresult);
    }
    mysqli_free_result($qresult);
    return $posts;
}


function tinyf_posts_get_by_id($pid)
{
    $id = (int)$pid;

    if ($id == 0)
        return null;
    $result = tinyf_posts_get('WHERE id = ' . $id);
    if ($result == null) {
        return null;
    }
    $post = $result[0];
    return $post;

}

function tinyf_posts_get_reply_by_id()
{
    $id = (int)$pid;

    if ($id == 0)
        return null;
    $result = tinyf_posts_get('WHERE `pid` = ' . $id);
    if ($result == null) {
        return null;
    }
    $post = $result[0];
    return $post;
}
function tinyf_posts_add($fid, $pid, $uid,$title, $content)
{  
    global $tf_handle;

    $_fid = (int)$fid;
    $_pid = (int)$pid;
    $_uid = (int)$uid;
    if ($_fid == 0 ) //|| $$_uid == 0)
        return false;
    if ((empty($title)) || (empty($content)) ) {
        return false;
    }
    $n_title = mysqli_real_escape_string($tf_handle, strip_tags($title));
    $n_content = mysqli_real_escape_string($tf_handle, strip_tags($content));
    
    $query = sprintf("INSERT INTO `posts` VALUES (NULL,%d,%d,%d,'%s','%s')", $_fid, $_pid, $_uid, $n_title,$n_content);
    $qresult = mysqli_query($tf_handle, $query);
    if (!$qresult) {

        return false;
    }


    return true;
}

function tinyf_posts_delete_reply($pid)
{
    global $tf_handle;
    $id = (int)$pid;
    if ($id == 0) {
        echo "is zero";
        return false;

    }
    $query = sprintf("DELETE FROM `posts` WHERE `pid`= %d", $id);
    $qresult = mysqli_query($tf_handle, $query);
    if (!$qresult) {
        echo "is null";
        return false;
    }

    return true;
}


function tinyf_users_update($uid, $name = null, $password = null, $email = null, $isadmin = -1)
{
    global $tf_handle;
    $id = (int)$uid;
    $n_isadmin = (int)$isadmin;
    if ($id == 0) {
        echo "is zero";
        return false;
    }
    $user = tinyf_users_get_by_id($id);
    if (!$user) {
        echo "no user with this id";
        return false;
    }
    if ((empty($name)) && (empty($password)) && (empty($email)) && ($user->isadmin == $n_isadmin)) {
        echo "is empty";
        return false;
    }
    $fields = array();
    $query = 'UPDATE `users` SET ';
    if (!empty($email)) {
        $n_email = mysqli_real_escape_string($tf_handle, strip_tags($email));
        if (!filter_var($n_email, FILTER_VALIDATE_EMAIL)) {
            echo "email not valid";
            return false;
        }
        $fields[count($fields)] = " `email` = '$n_email'";
    }
    if ((!empty($name))) {
        $n_name = mysqli_real_escape_string($tf_handle, strip_tags($name));
        $fields[count($fields)] = " `name` = '$n_name'";
    }
    if ((!empty($password))) {
        $n_pass = md5(mysqli_real_escape_string($tf_handle, strip_tags($password)));
        $fields[count($fields)] = " `password` = '$n_pass'";
    }
    if ($n_isadmin == -1) {
        $n_isadmin = $user->isadmin;
    }
    $fields[count($fields)] = " `isadmin` = '$n_isadmin'";

    $fcount = count($fields);
    if ($fcount == 1) {
        $query .= $fields[0] . " WHERE `id` = " . $id;
        $qresult = mysqli_query($tf_handle, $query);

        if (!$qresult) {

            return false;
        } else {
            return true;
        }
    }
    for ($i = 0; $i < $fcount; $i++) {
        $query .= $fields[$i] . ' ';
        if ($i != ($fcount - 1)) {
            $query .= ' , ';

        }
    }
    $query .= " WHERE `id` = " . $id;

    $qresult = mysqli_query($tf_handle, $query);
    if (!$qresult) {

        return false;
    } else {
        return true;
    }
}



?>