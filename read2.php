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
    $qr = substr($strarr[2], 0, - 2);
    $array[$qr] = $clas . " " . $name;
}

// 데이터를 읽어서 반을 구분하여 출력함
$fp = fopen("save/name_table.txt", "r") or die("파일을 열 수 없습니다！");
$Advanced2 = "";
$Advanced1 = "";
$Middle = "";

while (! feof($fp)) {
    $str = fgets($fp);
    $strarr = explode(' ', $str);

    $time = $strarr[1];
    $clas = $strarr[2];
    $name = $strarr[3];
    $qr = substr($strarr[4], 0, - 1);

    if (strpos($Advanced2, $name) === false && strpos($Advanced1, $name) === false && strpos($Middle, $name) === false) {
        if (strpos($str, $date) !== false) {
            $ccc = $array[$qr];
            if (strpos($ccc, "고급2") !== false) {
                $Advanced2 .= "<tr><td>" . $time . " " . $ccc . "</td></tr>";
            } else if (strpos($ccc, "고급1") !== false) {
                $Advanced1 .= "<tr><td>" . $time . " " . $ccc . "</td></tr>";
            } else if (strpos($ccc, "중급") !== false) {
                $Middle .= "<tr><td>" . $time . " " . $ccc . "</td></tr>";
            }
        }
    }
}
fclose($fp);


$asdf = $_REQUEST["qr"];

$시작일 = new DateTime($_REQUEST["start"]); // 20120101 같은 포맷도 잘됨

$종료일 = new DateTime($_REQUEST["end"]);

$차이 = date_diff($시작일, $종료일);

echo $차이->days; // 284
echo "<br>";

echo $array[$asdf[0]]."<br>";
echo $array[$asdf[1]]."<br>";
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
			<th>고급2</th>
		</tr>
        <?php
        mb_strlen($Advanced2) == 0 ? print "<tr><td>아무도 안 오셨어요ㅜㅜ</td></tr>" : print $Advanced2;
        ?>
	</table>

	<table>
		<tr>
			<th>고급1</th>
		</tr>
        <?php
        mb_strlen($Advanced1) == 0 ? print "<tr><td>아무도 안 오셨어요ㅜㅜ</td></tr>" : print $Advanced1;
        ?>
	</table>

	<table>
		<tr>
			<th>중급</th>
		</tr>
        <?php
        mb_strlen($Middle) == 0 ? print "<tr><td>아무도 안 오셨어요ㅜㅜ</td></tr>" : print $Middle;
        ?>
	</table>
</body>
</html>