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
		transform-origin:50% 50%;
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

var snapCenters = [[83,82],[80,222],[82,376],[80,524],[227,77],[228,223],[227,376],[227,519],[378,79],[379,224],[378,376],[379,524],[535,77],[536,224],[536,376],[536,518],[702,80],[705,224],[703,377],[705,523]];
var snapPoints = [[0,0],[0,139],[0,282],[0,448],[148,0],[140,133],[149,291],[140,438],[285,0],[294,142],[285,285],[293,448],[450,0],[441,133],[451,293],[442,437],[604,0],[610,142],[605,285],[610,447]];

function getDistance(p1,p2) {
	return Math.sqrt(Math.pow(p1[0]-p2[0],2) + Math.pow(p1[1]-p2[1],2));
}

var dragging = {

	isDragging: false,
	mx: 0,
	my: 0,
	target: "",

	enableDragging: function(obj) {
		obj.onmousedown = dragging.mouseDown;
		obj.onmouseup = dragging.mouseUp;
		obj.oncontextmenu = function() {return false;};
	},

	mouseUp: function(e) {
		if(e.which==3)
			return;
		dragging.isDragging = false;

		var cx = !parseInt(dragging.target.style.left)?0:parseInt(dragging.target.style.left) + parseInt(dragging.target.style.width)/2;
		var cy  = !parseInt(dragging.target.style.top)?0:parseInt(dragging.target.style.top) + parseInt(dragging.target.style.height)/2;


		if(cx >30 && cx < 830 && cy>30 && cy<630) {
			var c = [cx,cy];
			var min=0,mini=0;
			for(var i=0;i<snapCenters.length;i++)
			{
				var d = getDistance(snapCenters[i],c);
				if(i==0)
					min=d;
				else if(d<min)
				{
					min = d;
					mini = i;
				}
			}

			dragging.target.style.left = snapPoints[mini][0] + "px";
			dragging.target.style.top = snapPoints[mini][1] + "px";
		}

	},

	mouseDown: function(e) {
		if(e.which==1) {
			dragging.isDragging = true;
			dragging.mx = e.pageX;
			dragging.my = e.pageY;
			dragging.target=e.target;
		}
		else
		{
			e.preventDefault();
			switch(e.target.style.transform)
			{
				case "rotate(90deg)":
					e.target.style.transform = "rotate(180deg)";
					break;
				case "rotate(180deg)":
					e.target.style.transform = "rotate(270deg)";
					break;
				case "rotate(270deg)":
					e.target.style.transform = "rotate(360deg)";
					break;
				default:
					e.target.style.transform = "rotate(90deg)";

			}
		}
	},

	mouseMove: function(e) {

		if(dragging.isDragging) {
			var X = e.pageX - dragging.mx;
			var Y = e.pageY - dragging.my;
			dragging.mx = e.pageX;
			dragging.my = e.pageY;
			var left = !parseInt(dragging.target.style.left)?0:parseInt(dragging.target.style.left);
			var top  = !parseInt(dragging.target.style.top)?0:parseInt(dragging.target.style.top);
			dragging.target.style.left = (X + left) + "px";
			dragging.target.style.top = (Y + top) + "px";
		}
	},


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
}

</script>
</head>
<body>
<div id="jigsaw-container" style="position:absolute; left:30px; top:30px; width:800px; height:600px; border:1px solid #000;">
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
</body>
<script>
var pieces = document.getElementsByClassName("piece");
for(var i=0;i<pieces.length;i++)
	dragging.enableDragging(pieces[i]);
</script
</html>