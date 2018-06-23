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
function tinyf_posts_add($fid, $pid, $uid, $title, $content)
{
    global $tf_handle;

    $_fid = (int)$fid;
    $_pid = (int)$pid;
    $_uid = (int)$uid;
    if ($_fid == 0) //|| $$_uid == 0)
    return false;
    if ((empty($title)) || (empty($content))) {
        return false;
    }
    $n_title = mysqli_real_escape_string($tf_handle, strip_tags($title));
    $n_content = mysqli_real_escape_string($tf_handle, strip_tags($content));

    $query = sprintf("INSERT INTO `posts` VALUES (NULL,%d,%d,%d,'%s','%s')", $_fid, $_pid, $_uid, $n_title, $n_content);
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
function tinyf_posts_delete($pid)
{
    global $tf_handle;
    $id = (int)$pid;
    if ($id == 0) {
        echo "is zero";
        return false;

    }
    tinyf_posts_delete_reply($pid);
    $query = sprintf("DELETE FROM `posts` WHERE `id`= %d", $id);
    $qresult = mysqli_query($tf_handle, $query);
    if (!$qresult) {
        echo "is null";
        return false;
    }

    return true;
}


function tinyf_posts_update($_id, $_fid = 0, $_pid = -1, $_uid = 0, $title = null, $content = null)
{
    global $tf_handle;
    $id = (int)$_id;
    $fid = (int)$_fid;
    $pid = (int)$_pid;
    $uid = (int)$_uid;

    if ($id <= 0)
        return false;
    $post = tinyf_posts_get_by_id($id);
    if (!$post) {
        echo "no post with this id";
        return false;
    }
    if ((empty($title)) && (empty($content)) && $post->fid == $fid && $post->pid == $pid && $post->uid == $uid) {
        echo "is empty";
        return false;
    }

    if ($post->pid == 0) {
        if ($_fid <= 0) {
            $_fid = $post->fid;
        }
        $_pid = 0;
    } else {
        $_fid = 0;
        if ($_pid == 0) {
            $_pid = $post->pid;
        }
    }
    if ($_uid == 0) {
        $_uid = $post->uid;
    }

    $fields = array();
    $query = 'UPDATE `posts` SET ';
    if (!empty($title)) {
        $n_title = mysqli_real_escape_string($tf_handle, strip_tags($title));

        $fields[count($fields)] = " `title` = '$n_title'";
    }
    if ((!empty($content))) {
        $n_content = mysqli_real_escape_string($tf_handle, strip_tags($content));
        $fields[count($fields)] = " `content` = '$n_content'";
    }


    $fields[count($fields)] = " `fid` = '$_fid'";
    $fields[count($fields)] = " `pid` = '$_pid'";
    $fields[count($fields)] = " `uid` = '$_uid'";
    $fcount = count($fields);

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