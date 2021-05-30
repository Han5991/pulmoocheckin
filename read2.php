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
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>calendar</title>
</head>
<body>
	<table border="2">
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