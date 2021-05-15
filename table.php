<?php

date_default_timezone_set('Asia/Seoul');

$clas=$_POST['clas'];

$content = "";
$content .= date("Y.m.d H:i:s", time());
$content .= ' ';
$content .= $clas;
$content .= ' ';
$content .= $_POST['name'];
$content .= ' ';
$content .= $_POST['org'];
$content .= "\n";

if((strpos($clas, "장미") !== false) || (strpos($clas, "고급2") !== false)) {
    file_put_contents("save/rose_table.txt", $content, FILE_APPEND);
} else if( strpos($clas, "해바라기") !== false){
    file_put_contents("save/sunflower_table.txt", $content, FILE_APPEND);
} else {
    file_put_contents("save/teacher_table.txt", $content, FILE_APPEND);
}
file_put_contents("save/name_table.txt", $content, FILE_APPEND);
echo "OK";
?>
