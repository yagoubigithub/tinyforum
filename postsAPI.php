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

function tinyf_users_add($name, $password, $email, $isadmin)
{
    global $tf_handle;
    if ((empty($name)) || (empty($password)) || (empty($email))) {

        return false;
    }



    $n_email = mysqli_real_escape_string($tf_handle, strip_tags($email));
    if (!filter_var($n_email, FILTER_VALIDATE_EMAIL)) {

        return false;
    }
    $n_name = mysqli_real_escape_string($tf_handle, strip_tags($name));

    $n_pass = md5(@mysqli_real_escape_string($tf_handle, strip_tags($password)));
    $n_isadmin = (int)$isadmin;

    if ($n_isadmin != 0 && $n_isadmin != 1) {
        $n_isadmin = 0;
    }
    $query = sprintf("INSERT INTO `users` VALUES (NULL,'%s','%s','%s',%d)", $n_name, $n_pass, $n_email, $n_isadmin);
    $qresult = mysqli_query($tf_handle, $query);
    if (!$qresult) {

        return false;
    }


    return true;
}

function tinyf_users_delete($uid)
{
    global $tf_handle;
    $id = (int)$uid;
    if ($id == 0) {
        echo "is zero";
        return false;

    }
    $query = sprintf("DELETE FROM `users` WHERE `id`= %d", $id);
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