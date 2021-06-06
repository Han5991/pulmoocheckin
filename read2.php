<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set('Asia/Seoul');

$차이 = date_diff(new DateTime($_REQUEST["start"]), new DateTime($_REQUEST["end"]));
$days = $차이->days + 1;

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
                $array[$qr][$k] = "<td> </td>";
            }
        }
        
        $array[$qr][$days + 1] = $clas;
        $array[$qr][$days + 2] = $name;
    } else {
        break;
    }
}

// 데이터를 읽어서 반을 구분하여 출력함
$fp = fopen("save/name_table.txt", "r") or die("파일을 열 수 없습니다！");
while (! feof($fp)) {
    $str = fgets($fp);
    $strarr = explode(' ', $str);
    
    $day = $strarr[0];
    $time = $strarr[1];
    $clas = $strarr[2];
    $name = $strarr[3];
    $qr = substr($strarr[4], 0, - 1);
    
    if (strpos($str, $year . "." . $month) !== false) {
        $array[$qr][explode('.', $day)[2] * 1] = "<td>O</td>";
    }
}
fclose($fp);

// 차이나는 날 수
echo "차이나는 날 수 : " . $days . "<br>";

$start_date = $_REQUEST["start"];
$end_date = $_REQUEST["end"];

// go1 : 월수목
// go2 : 목금
// Mid : 월수금
$go1 = 0;
$go2 = 0;
$Mid = 0;
$many = 0;

// 기간을 설정해서 요일을 체크하는 반복문
for ($i = 0; $date < $end_date; $i ++) {
    $date = date('Y-m-d', strtotime($start_date . ' +' . $i . 'days'));
    
    switch (date('w', strtotime($date))) {
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
echo "Mid : " . $Mid . "<br>";
for ($i = 1; $i <= count($qrs[0])+5; $i ++) {
    echo $i;
    echo $array[$qrs[0]][$i]."<br>";
}

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
