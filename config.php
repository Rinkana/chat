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
define("ROOT_PATH",$_SERVER["DOCUMENT_ROOT"]."/".PROJECT_DIR);

require_once(ROOT_PATH."assets/helpers/class.Database.php");
require_once(ROOT_PATH."assets/helpers/class.Post.php");
$db = Database::GetInstance(new PDO("sqlite:".ROOT_PATH."assets/database/test.sqlite", "", ""));
?> 