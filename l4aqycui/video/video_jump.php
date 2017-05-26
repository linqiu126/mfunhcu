<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/26
 * Time: 21:23
 */

if (isset($_GET["rtsp_port"])) $rtsp_port = trim($_GET["rtsp_port"]); else $rtsp_port = "";

$contents = ""; //初始化
if (!empty($rtsp_port)) {
    $filename = "./video_jump.html";
    $handle = fopen($filename, "r");
    $contents = fread($handle, filesize($filename));
    fclose($handle);

    $contents = str_replace("__PORT__", $rtsp_port, $contents, $count);
}

echo $contents;

?>