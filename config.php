<?php
/**
 * User: Max Berends
 * Date: 14-11-2014
 * Time: 19:24
 * For:  chat
 */
define("PROJECT_DIR","chat/");
define("ABS_PATH","/".PROJECT_DIR);
define("HTTP_PATH","//".$_SERVER['HTTP_HOST'].ABS_PATH);

require_once("E:/xampp/htdocs/chat/assets/helpers/class.Database.php");
$db = new Database(new PDO("sqlite:E:/xampp/htdocs/chat/assets/database/test.sqlite", "", ""));
?> 