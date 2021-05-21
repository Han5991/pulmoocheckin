<?php
header('Content-Type: text/html; charset=UTF-8');

// GET으로 넘겨 받은 year값이 있다면 넘겨 받은걸 year변수에 적용하고 없다면 현재 년도
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
// GET으로 넘겨 받은 month값이 있다면 넘겨 받은걸 month변수에 적용하고 없다면 현재 월
$month1 = mb_strlen($_GET['month']) == 2 ? $_GET['month'] : "0".$_GET['month'];
$month  = isset($_GET['month']) ? $month1 : date('m');

$date = "$year-$month-01"; // 현재 날짜
$time = strtotime($date); // 현재 날짜의 타임스탬프
$start_week = date('w', $time); // 1. 시작 요일
$total_day = date('t', $time); // 2. 현재 달의 총 날짜
$total_week = ceil(($total_day + $start_week) / 7); // 3. 현재 달의 총 주차

// 출석부를 읽어와서 해쉬맵으로 만듦
$fp = fopen("save/Attendance.txt", "r") or die("파일을 열 수 없습니다！");
$people = "";
// 출석부 해쉬맵
$array = array();

while (! feof($fp)) {
    $str = fgets($fp);
    
    if (strpos($str, "stop") === false) {
        $strarr = explode(' ', $str);
        
        for ($k = 1; $k <= $total_day; $k ++) {
            $array[$strarr[1]][$k] = "<td> </td>";
        }
    } else {
        break;
    }
}

// 데이터를 읽어서 반을 구분하여 출력함
$fp = fopen("save/name_table.txt", "r") or die("파일을 열 수 없습니다！");
$rose = "";
$sunflower = "";
$people = "";
$bbb="";
while (! feof($fp)) {
    
    $str = fgets($fp);
    $strarr = explode(' ', $str);
    
    $day = $strarr[0];
    $time = $strarr[1];
    $clas = $strarr[2];
    $name = $strarr[3];
    $qr = $strarr[4];
    
    if (strpos($str, $year.".".$month) !== false) {
        $array[$name][explode('.', $day)[2] * 1] = "<td>O</td>";
    }
}


foreach ($array as $key => $value) {
    $aaa = "<tr><td>".$key."</td>";
    for ($k = 1; $k <= $total_day; $k ++) {
        $aaa .= $array[$key][$k];
    }
    $aaa .= "</tr>";
    $bbb .= $aaa;
}
fclose($fp);
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>calendar</title>
<style type="text/css">
table {
	border-spacing: 0;
}

table td {
	text-align: center;
}
</style>
</head>

<body>
	<?php echo "$year 년 $month 월" ?>
	<!-- 현재가 1월이라 이전 달이 작년 12월인경우 -->
	<?php if ($month == 1): ?>
		<!-- 작년 12월 -->
	<a
		href="https://hounjini.cafe24.com/sangwook/calendar.php/?year=<?php echo $year-1 ?>&month=12">이전
		달</a>
	<?php else: ?>
		<!-- 이번 년 이전 월 -->
	<a
		href="https://hounjini.cafe24.com/sangwook/calendar.php/?year=<?php echo $year ?>&month=<?php echo $month-1 ?>">이전
		달</a>
	<?php endif ?>

	<!-- 현재가 12월이라 다음 달이 내년 1월인경우 -->
	<?php if ($month == 12): ?>
		<!-- 내년 1월 -->
	<a
		href="https://hounjini.cafe24.com/sangwook/calendar.php/?year=<?php echo $year+1 ?>&month=1">다음
		달</a>
	<?php else: ?>
		<!-- 이번 년 다음 월 -->
	<a
		href="https://hounjini.cafe24.com/sangwook/calendar.php/?year=<?php echo $year ?>&month=<?php echo $month+1 ?>">다음
		달</a>
	<?php endif ?>
	<table border="1">
		<tr>
			<th>일</th>
			<th>월</th>
			<th>화</th>
			<th>수</th>
			<th>목</th>
			<th>금</th>
			<th>토</th>
		</tr>

		<!-- 총 주차를 반복합니다. -->
		 <?php for ($n = 1, $i = 0; $i < $total_week; $i++): ?>
			<tr>
			<!-- 1일부터 7일 (한 주) -->
				<?php for ($k = 0; $k < 7; $k++): ?> 
					<td>
				<!-- 시작 요일부터 마지막 날짜까지만 날짜를 보여주도록 -->
						<?php if ( ($n > 1 || $k >= $start_week) && ($total_day >= $n) ): ?>
							<!-- 현재 날짜를 보여주고 1씩 더해줌 --> <a
				href="https://hounjini.cafe24.com/sangwook/read.php/?year=<?php echo $year ?>&month=<?php echo $month ?>&day=<?php echo $n ?>"><?php echo $n++ ?> </a>
						<?php endif ?>
					</td> 
				<?php endfor; ?> 
			</tr> 
		<?php endfor; ?> 
	</table>
	<h1><?php echo $month?>월 출석현황</h1>
	<table border="1">
		<tr>
			<th>공백</th>
			<?php for ($k = 1; $k <= $total_day; $k++): ?> 
			<th>
				<?php echo $k ?>
			</th> 
			<?php endfor; ?>
		</tr>
		<?php echo $bbb?>
	</table>
</body>
</html>