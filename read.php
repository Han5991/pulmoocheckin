<?php
header('Content-Type: text/html; charset=UTF-8');

// 날짜 데이터 수정 및 받아오기
date_default_timezone_set('Asia/Seoul');
$year = $_REQUEST["year"];
$month = mb_strlen($_REQUEST["month"]) == 2 ? $_REQUEST["month"] : "0" . $_REQUEST["month"];
$day = mb_strlen($_REQUEST["day"]) == 2 ? $_REQUEST["day"] : "0" . $_REQUEST["day"];
$date = $year . "." . $month . "." . $day;

// 출석부를 읽어와서 해쉬맵으로 만듦
$fp = fopen("save/Attendance.txt", "r") or die("파일을 열 수 없습니다！");
// 출석부 해쉬맵
$array = array();

while (! feof($fp)) {
    $str = fgets($fp);
    
    $strarr = explode(' ', $str);
    
    $clas = $strarr[0];
    $name = $strarr[1];
    $qr = $strarr[2];
    $array[$qr] = $clas . " " . $name;
    echo strlen($qr)."<br>";
}

foreach ($array as $key => $value) {
    echo $key."<br>";
}

echo $array['%EC%B5%9C%EC%88%98%EB%B9%88
']."<br>"; // 1


// 데이터를 읽어서 반을 구분하여 출력함
$fp = fopen("save/name_table.txt", "r") or die("파일을 열 수 없습니다！");
$rose = "";
$sunflower = "";

while (! feof($fp)) {
    $str = fgets($fp);
    $strarr = explode(' ', $str);
    
    $time = $strarr[1];
    $clas = $strarr[2];
    $name = $strarr[3];
    $qr = $strarr[4];
    
    
    if (strpos($str, $date) !== false) {
        
        if (strpos($rose, $name) === false && strpos($sunflower, $name) === false) {
            
            if (strpos($str, "장미") !== false || strpos($str, "고급2") !== false) {
                $rose .= "<tr><td>" . $time . " " . $clas . " " . $name . "</td></tr>";
            } else if (strpos($str, "해바라기") !== false) {
                $sunflower .= "<tr><td>" . $time . " " . $clas . " " . $name . "</td></tr>";
            }
        }
    }
}
fclose($fp);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>calendar</title>
</head>
<body>
	<?php print "$year 년 $month 월 $day 일 출석현황" ?>
	<table>
		<tr>
			<th>장미반</th>
		</tr>
        <?php
        mb_strlen($rose) == 0 ? print "<tr><td>아무도 안 오셨어요ㅜㅜ</td></tr>" : print $rose;
        ?>
	</table>

	<table>
		<tr>
			<th>해바라기반</th>
		</tr>
        <?php
        mb_strlen($sunflower) == 0 ? print "<tr><td>아무도 안 오셨어요ㅜㅜ</td></tr>" : print $sunflower;
        ?>
	</table>
</body>
</html>