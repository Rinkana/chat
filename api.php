<?php
/**
 * User: Max Berends
 * Date: 14-11-2014
 * Time: 19:21
 * For:  chat
 */

require_once("config.php");
//Default return values
$result = array(
    "posts" => array(
    ),
    "last_post" => 0
);
//Submit post
if(isset($_POST["new_text"])){

    $newPost = new Post();

    $newPost->setPoster(substr(md5($_SERVER["REMOTE_ADDR"]),0, 10));
    $newPost->setText($_POST["new_text"]);
    $newPost->setDate(date("Y/m/d H:i"));

    $newPost->insert();
}

//Get post(s)
if(isset($_POST["last_post"])){

    //Set the return last post to the current one so we will not get dupelicates when there are no new posts
    $result["last_post"] = $_POST["last_post"];

    if(is_numeric($_POST["last_post"]) && $_POST["last_post"] > 0){
        $posts = Post::loadFromID($_POST["last_post"]);//Load posts that start from this id
    }else{
        $posts = Post::loadFromID(0, 10); //Get the last 10 posts
    }

    if($posts && is_array($posts) && count($posts) > 0){
        //loop trough each post to make it useable
        foreach($posts as $post){
            $result["posts"][] = array(
                "poster" => $post->getPoster(),
                "text" => $post->getText(),
                "date" => $post->getDate(),
            );
            $result["last_post"] = $post->getID(); //Set the last post to the current ID
        }
    }

}

echo json_encode($result); //Return result
?>
