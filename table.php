<?php

date_default_timezone_set('Asia/Seoul');

$clas=$_POST['clas'];

$content = "";
$content .= date("m.d\tH:i:s", time());
$content .= "\t";
$content .= $clas;
$content .= "\t";
$content .= $_POST['name'];
$content .= "\t";
$content .= $_POST['org'];
$content .= "<br>";
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
