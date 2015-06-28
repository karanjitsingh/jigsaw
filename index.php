<!doctype html>

<html>
<head>
<style type="text/css">
	
	body {
		margin: 0px;
		padding: 0px;
	}

	.piece {
		position: relative;
		display:block;
		background: url(background.jpg)
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

</script>
</head>
<body>
<div style="position:absolute; left:30px; top:30px; width:800px; height:600px; border:1px solid #000;">
	<svg style="display:none;">
	<defs>
	<?php

		$dir    = './jigsaw';
		$files = scandir($dir);
		$html = "";

		$div_width = array();
		$div_height = array();


		for($i=2; $i< 3;$i++) {

			$file = fopen("./jigsaw/".$files[$i],"r");
			$data = fread($file,filesize("./jigsaw/".$files[$i]));
			$width = substr($data, strpos($data,"width="));
			$width = substr($width,0,strpos($width,"px")+3);
			$width = str_replace("=\"", ":", $width);
			$width = str_replace("\"", "", $width);
			$height = substr($data, strpos($data,"height="));
			$height = substr($height,0,strpos($height,"px")+3);
			$height = str_replace("=\"", ":", $height);
			$height = str_replace("\"", "", $height);
			array_push($div_width, $width);
			array_push($div_height, $height);

			$data = substr($data, strpos($data,"<path"),-8);
			$html .= "<clipPath id=\"abc\">".$data."</clipPath>\n";
		}

		echo $html;
	?>
	</defs>
	</svg>
	<?php

		for($i=2; $i< 3;$i++) {
			echo "<div class=\"piece\" style=\"".$div_width[$i-2].";".$div_height[$i-2].";clip-path:url(#abc);\"\></div>";
		}

	?>
</div>
</body>
<script>
dragging.enableDragging(document.getElementsByClassName("piece")[0]);
</script
</html>