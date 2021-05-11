<?php
header('Content-Type: text/html; charset=UTF-8');

date_default_timezone_set('Asia/Seoul');
$date = date("m.d", time());
// 파일 열기
$fp = fopen("save/name_table.txt", "r") or die("파일을 열 수 없습니다！");
// 파일 내용 출력

while (! feof($fp)) {
    $str = fgets($fp);
    
    if(strpos($str, $date) !== false) {
        print $str;
    }
}

// 파일 닫기
fclose($fp);
?>