<?php
/**
 * User: Max Berends
 * Date: 14-11-2014
 * Time: 19:21
 * For:  chat
 */

require_once("config.php");
$result = array(
    "success" => true,
    "posts" => array(

    ),
    "last_post" => 0
);
//Submit post
if(isset($_POST["new_text"])){
    $SQL = "
      INSERT INTO
        tblPosts
      VALUES(
        null,
        :poster,
        :text,
        :date
      )";

    $values = array(
        substr(md5($_SERVER["REMOTE_ADDR"]),0, 10),
        $_POST["new_text"],
        date("Y/m/d H:i")
    );

    $db->Insert($SQL,$values);
}

//Get post(s)
if(isset($_POST["last_post"])){
    $SQL = "SELECT * FROM tblPosts";

    $result["last_post"] = $_POST["last_post"];

    $aValues = array();

    if(is_numeric($_POST["last_post"]) && $_POST["last_post"] > 0){
        $SQL .= " WHERE ID > :ID";
        $aValues[] = $_POST["last_post"];
    }else{
        $SQL .= " LIMIT 10 ";
    }

    $posts = $db->FetchArray($SQL,$aValues);

    if($posts && is_array($posts) && count($posts) > 0){
        $result["posts"] = $posts;

        $lastPost = end($posts);
        $result["last_post"] = $lastPost["ID"];
    }

}

echo json_encode($result);
?>
