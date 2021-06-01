<?php
header('Content-Type: text/html; charset=UTF-8');

date_default_timezone_set('Asia/Seoul');

$dateDifference = abs(strtotime($_REQUEST["end"]) - strtotime($_REQUEST["start"]));

$years = floor($dateDifference / (365 * 60 * 60 * 24));
$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
$days = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

$qrs = $_REQUEST["qr"];
// 출석부를 읽어와서 해쉬맵으로 만듦
$fp = fopen("save/Attendance.txt", "r") or die("파일을 열 수 없습니다！");
// 출석부 해쉬맵
$array = array();
while (! feof($fp)) {
    $str = fgets($fp);
    
    if (strpos($str, "stop") === false) {
        $strarr = explode(' ', $str);
        
        $clas = $strarr[0];
        $name = $strarr[1];
        $qr = substr($strarr[2], 0, - 2);
        if (strpos($str, "stop") !== false) {
            for ($k = 1; $k <= $days; $k ++) {
                $array[$qr][$k] = "x";
            }
        }
        
        $array[$qr][$days + 1] = $clas;
        $array[$qr][$days + 2] = $name;
    } else {
        break;
    }
}

// go1 : 월수목
// go2 : 목금
// Mid : 월수금
$go1 = 0;
$go2 = 0;
$Mid = 0;
$many = 0;
// 달계산이 어렵다 생각해보자
$datearr1 = explode('-', $_REQUEST["start"]);
$year1 = $datearr1[0];
$month1 = $datearr1[1];
$day1 = $datearr1[2];

$datearr2 = explode('-', $_REQUEST["end"]);
$year2 = $datearr2[0];
$month2 = $datearr2[1];
$day2 = $datearr2[2];
// 기간을 설정해서 요일을 체크하는 반복문
for ($i = $day1; $i <= $day2; $i ++) {
    switch (date('w', strtotime($year1 . "-" . $month1 . "-" . $i))) {
        case '1':
            $go1 ++;
            $Mid ++;
            break;
        case '3':
            $go1 ++;
            $Mid ++;
            break;
        case '4':
            $go1 ++;
            $go2 ++;
            break;
        case '5':
            $go2 ++;
            $Mid ++;
            break;
    }
}
echo "go1 : " . $go1 . "<br>";
echo "go2 : " . $go2 . "<br>";
echo "Mid : " . $Mid;
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>calendar</title>
</head>
<body>
	<table border="1">
		<tr>
			<th>공백</th>
			<?php for ($k = 1; $k <= $days; $k++): ?> 
			<th>
				<?php echo $k ?>
			</th>
			<?php endfor; ?>
			<th>-출석율-</th>
		</tr>

	</table>
</body>
</html>
