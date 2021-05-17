<?php
header('Content-Type: text/html; charset=UTF-8');

$fp = fopen("save/Attendance.txt", "r") or die("파일을 열 수 없습니다！");
$people = "";
$array = array();
while (! feof($fp)) {
    $str = fgets($fp);

    if (strpos($str, "stop") === false) {
        $strarr = explode(' ', $str);
        $clas = $strarr[0];
        $name = $strarr[1];
        $qr = $strarr[2];

        $array[$qr] = $clas . $name;

        $people .= "<tr><td>" . $clas ."</td><td>". $name . "</td></tr>";
    } else {
        break;
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
	<table>
		<tr>
			<th colspan="2">야학 인명부</th>
		</tr>
		<tr>
			<th>반</th>
			<th>성함</th>
		</tr>
		<?php echo $people;?>
	</table>
</body>
</html>