<!doctype html>

<html>
<head>
<style type="text/css">
	
	body {
		margin: 0px;
		padding: 0px;
	}

	.piece {
		position: absolute;
		display:block;
	}

	img {
		-khtml-user-select: none;
	    -o-user-select: none;
	    -moz-user-select: none;
	    -webkit-user-select: none;
	    user-select: none;
	}
</style>

<script>

var snapPoints = [[0,0],[0,139],[0,282],[0,448],[148,0],[140,133],[149,291],[140,438],[285,0],[294,142],[285,285],[293,448],[450,0],[441,133],[451,293],[442,437],[604,0],[610,142],[605,285],[610,447]];

var dragging = {

	isDragging: false,
	mx: 0,
	my: 0,
	target: "",

	enableDragging: function(obj) {
		obj.onmousedown = dragging.mouseDown;
		obj.onmouseup = dragging.mouseUp;
	},

	mouseUp: function(e) {
		dragging.isDragging = false;
	},

	mouseDown: function(e) {
		dragging.isDragging = true;
		dragging.mx = e.pageX;
		dragging.my = e.pageY;
		dragging.target=e.target
	},

	mouseMove: function(e) {

		if(dragging.isDragging) {
			var X = e.pageX - dragging.mx;
			var Y = e.pageY - dragging.my;
			dragging.mx = e.pageX;
			dragging.my = e.pageY;
			var left = !parseInt(dragging.target.style.left)?0:parseInt(dragging.target.style.left);
			var top  = !parseInt(dragging.target.style.top)?0:parseInt(dragging.target.style.top);
			document.title = left;
			dragging.target.style.left = (X + left) + "px";
			dragging.target.style.top = (Y + top) + "px";
		}
	}


}

window.onmouseup = function() {dragging.isDragging=false};
window.onmousemove = dragging.mouseMove;

window.onkeydown = function(e) {
	if(dragging.target=="")
		return;
	var X=0,Y=0;

	switch(e.keyCode) {
		case 37:
			X=-1;
			break;
		case 38:
			Y=-1;
			break;
		case 39:
			X=1;
			break;
		case 40:
			Y=1;
			break;
	}

	var left = !parseInt(dragging.target.style.left)?0:parseInt(dragging.target.style.left);
	var top  = !parseInt(dragging.target.style.top)?0:parseInt(dragging.target.style.top);
	dragging.target.style.left = (X + left) + "px";
	dragging.target.style.top = (Y + top) + "px";
	document.title = (left + parseInt(dragging.target.style.width) + X) + " " + (top + parseInt(dragging.target.style.height) + Y);
}

function generateSnapPoints() {
	var data =  "["
	var pieces = document.getElementsByClassName("piece");
	for(var i=0;i<pieces.length;i++)
	{
		if(i>0)
			data += ",";
		data += "[" + parseInt(parseInt(pieces[i].style.left) + parseInt(pieces[i].style.width)/2) + "," + parseInt(parseInt(pieces[i].style.top) + parseInt(pieces[i].style.height)/2) + "]";
	}

	data += "]";
	document.write(data);
}
</script>
</head>
<body>
<div style="position:absolute; left:30px; top:30px; width:800px; height:600px; border:1px solid #000;">
	<?php
	/*
		$dir    = './puzzle1/';
		$files = scandir($dir);
		$html = "";

		$div_width = array();
		$div_height = array();


		for($x=1; $x<6 ; $x++) {
			for($y=1;$y<5;$y++) {
				$size=getimagesize($dir.$x.$y.".png");
				echo "<div class=\"piece\" style=\"background:url($dir$x$y.png);width:$size[0]px;height:$size[1]px;left:0px;top:0px;\"\></div>";
			}
		}
*/
		$file = fopen("ideal.html","r");
		$data = fread($file,filesize("ideal.html"));
		fclose($file);

		echo $data;
	?>
</div>
<input type=button onclick="generateSnapPoints()" value="Generate Snap Points" />
</body>
<script>
var pieces = document.getElementsByClassName("piece");
for(var i=0;i<pieces.length;i++)
	dragging.enableDragging(pieces[i]);
</script
</html>