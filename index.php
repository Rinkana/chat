<?php
/**
 * User: Max Berends
 * Date: 14-11-2014
 * Time: 18:57
 * For:  chat
 */

require_once("config.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Simple chat</title>
    <script type="text/javascript">
        var ABS_PATH = "<?= ABS_PATH ?>",
            HTTP_PATH = "<?= HTTP_PATH ?>";
    </script>
    <script type="text/javascript" src="<?= HTTP_PATH ?>assets/javascript/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="<?= HTTP_PATH ?>assets/javascript/jquery.general.js"></script>
    <style>
        *{
            margin:0;
            padding:0;
        }
        ul#posts{
            max-height:200px;
            padding:10px;
            border:1px solid black;
            list-style:none;
        }
        ul li{
            background-color:#c1c1c1;
        }
        ul li:nth-child(2n+1){
            background-color:#ffffff;
        }

        ul li span.date{
            display:block;
            width:10%;
            float:left;
        }
        ul li span.poster{
             display:block;
             width:10%;
            float:left;
         }
        ul li span.text{
            display:block;
            width:80%;
        }
        ul li span.text:after{
            content:"";
            display:table;
            clear:both;
        }
    </style>
</head>
<body>

    Uw ID: <?= substr(md5($_SERVER["REMOTE_ADDR"]),0, 10) ?><br/>
    <ul id="posts">

    </ul>

    <form id="new_post" method="post" action="#">
        <input type="text" name="new_text"/>
        <input type="submit" value="verstuur">
    </form>
</body>
</html>