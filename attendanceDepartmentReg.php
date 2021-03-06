<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>PulmooQR</title>
<script type="text/javascript" src="js/adapter.min.js"></script>
<script type="text/javascript" src="js/instascan.min.js"></script>
<script type="text/javascript" src="js/jquery-3.5.1.min.js"></script>
<style type="text/css">
#msg {
	z-index: 10;
	position: absolute;
	width: 100%;
	height: 100%;
}

#msg_top {
	font-size: 50px;
	width: 100%;
	height: 20%;
	background-color: #191e24;
	color: white;
	text-align: center;
	vertical-align: middle;
}

#msg_bottom {
	font-size: 50px;
	width: 99%;
	height: 80%;
	background-color: #191e24;
	color: white;
	text-align: center;
	vertical-align: middle;
	font-size: 200px;
	float: left;
}

#msg_bottom_right {
	font-size: 50px;
	width: 1%;
	height: 80%;
	background-color: #191e24;
	color: white;
	text-align: center;
	vertical-align: middle;
	font-size: 200px;
	float: left;
}

#video_container {
	z-index: 2;
}
</style>

</head>
<body>
	<div id="msg" style="width: 100%">
		<div id="msg_top"></div>
		<div id="msg_bottom"></div>
		<div id="msg_bottom_right"></div>
	</div>
	<div id="video_container">
		<video id="preview" style="width: 100%"></video>
	</div>
	<script type="text/javascript">
$("#msg").hide();
var how_many = 0;
var audio = new Audio("mp3/ok.mp3");
var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), mirror: false, scanPeriod: 5 });

function printOk(s) {
    $("#msg_bottom").text(s)
    audio.play();
    $("#video_container").hide(0).delay(4500).show(0);
    $("#msg").show(0).delay(4500).hide(0)
}

function saveLocalStorage(s) {
    if(typeof(Storage) !== "undefined") {
        var str = "";
        let today = new Date();
        str += today.toLocaleString();
        str += "/";
        str += s;
        localStorage[localStorage.length] = str;
    }else{
    	alert("등록되지 않은 사용자입니다.");	
    }
}

scanner.addListener('scan', function (content, image) {
    var s = decodeURIComponent(content);
    
    var clas = s.split("_")[0];
    var name = s.split("_")[1];

    $.ajax({
        url: "https://hounjini.cafe24.com/sangwook/table.php",
        async: true,
        type: 'POST',
        data: {
            name: name,
            clas: clas,
            org: content
        },
        dataType: 'text'
    });

    printOk(name);
    saveLocalStorage(s);
});

Instascan.Camera.getCameras().then(function (cameras) {
    var cameras = cameras;
    var target_idx = 0;
    if (cameras.length > 0) {
	target_idx = cameras.length - 1;
        for(var i = 0; i < cameras.length; i++) {
            if(cameras[i].name != null) {
                if(cameras[i].name.indexOf("back") > -1) {
                    target_idx = i;
                    break;
                }
            }
        }
        scanner.start(cameras[target_idx]);
    } else {
        console.error('No cameras found.');
    }
}).catch(function (e) {
    console.error(e);
});

</script>
</body>
</html>

