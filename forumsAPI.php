<?php


/***********************************************************/
//Forums API
/****************************************************************/ 


function tinyf_forums_get($extra = ''){
    global $tf_handle;
    $query=sprintf("SELECT * FROM `forums` %s",$extra);
    $qresult=mysqli_query($tf_handle,$query);

    if(!$qresult)
    return NULL;

    $rcount  = mysqli_num_rows($qresult);

    if($rcount == 0)
    return NULL;

    $forums = array();
    for($i = 0; $i < $rcount; $i++){
       $forums[count($forums)]= mysqli_fetch_object($qresult);
    }
    mysqli_free_result($qresult);
    return $forums;
}


function tinyf_forums_get_by_id($fid){
    $id = (int)$fid;

    if($id == 0)
    return NULL;
 $result = tinyf_forums_get('WHERE id = '.$id);
 if($result == NULL){
     return NULL;
 }
 $forum = $result[0];
 return $forum;

}


function tinyf_forums_add($title,$desc){
    global $tf_handle;
    if((empty($title))  || (empty($desc)) ){
        echo "is empty";
        return false;
    }


    
    $n_title = mysqli_real_escape_string($tf_handle,strip_tags($title));
    $n_desc = mysqli_real_escape_string($tf_handle,strip_tags($desc));
    
   $query  = "INSERT INTO `forums` VALUES (NULL,'$n_title','$n_desc')";
   
   $qresult = mysqli_query($tf_handle,$query);
   
   if(!$qresult){
    return false;
   }
      
  
   return true;
}

function tinyf_forums_delete($fid){
    global  $tf_handle;
    $id= (int)$fid;
    if($id == 0){
        echo "is zero";
        return false;

    }
   tinyf_forums_delete_all_posts($id);
    $query = sprintf("DELETE FROM `forums` WHERE `id`= %d",$id);
    $qresult = mysqli_query($tf_handle,$query);
    if(!$qresult){
        echo "is null";
     return false;
    }      
     
    return true;
}


function tinyf_forums_update($fid,$title = NULL,$desc = NULL){
    global  $tf_handle;
    $id= (int)$fid;
    
    if($id == 0){
        echo "is zero";
        return false;
    }
    $forum = tinyf_forums_get_by_id($id);
    if(!$forum){
        echo "no forum with this id";
        return false;
    }
    if((empty($title))  && (empty($desc))){
        echo "is empty";
        return false;
    }
    $fields =array();
    $query = 'UPDATE `forums` SET ';
    if(!empty($title)){
        $n_title = mysqli_real_escape_string($tf_handle,strip_tags($title)); 
        $fields[count($fields)] = " `title` = '$n_title'";
    }
    if((!empty($desc))){
        $n_desc = mysqli_real_escape_string($tf_handle,strip_tags($desc));
        $fields[count($fields)] = " `desc` = '$n_desc'";
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

function tinyf_forums_delete_all_posts($fid){
    global  $tf_handle;
    $id= (int)$fid;
    if($id == 0){
        echo "is zero";
        return false;

    }
    $forum = tinyf_forums_get_by_id($id);
    if(!$forum){
        echo "no forum with this id";
        return false;
    }
    $topicsq = sprintf('SELECT * FROM `posts` WHERE `fid` =  %d',$id);
    $tresult =@mysqli_query($topicsq);
    if(!$tresult){
        return false;
    }
    $tcount =@mysqli_num_rows($tresult);
    for($i =0;$i<$tcount;$i++){
        $topic = mysqli_fetch_object($tresult);
        mysqli_query('DELETE FROM `posts`WHERE `pid` = '.$topic->id);
        mysqli_query('DELETE FROM `posts`WHERE `id` = '.$topic->id);

    }
    mysqli_free_result($tresult);



}

?>