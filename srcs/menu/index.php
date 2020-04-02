<style>
@import url('https://fonts.googleapis.com/css?family=Source+Code+Pro&display=swap');

body {
	background-color: grey;
	font-family: 'Source Code Pro', monospace;
	padding:0;
	margin:0;
}
h1 {
	text-align: center;
	font-size: 50px;
}
h2 {
	text-align: center;
	font-size: 40px;
}
/* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}

a {
  color: inherit; /* blue colors for links too */
  text-decoration: inherit; /* no underline */
}

a:hover {
  color: inherit; /* blue colors for links too */
  text-decoration: inherit; /* no underline */
}

ai:visited {
  color: inherit; /* blue colors for links too */
  text-decoration: inherit; /* no underline */
}
</style>

<html>
<head>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
</head>
<script>
$(document).ready(function() {
	$(".checkbox").change(function() {
		if(this.checked == 1) {
			console.log("test");
			window.location="switch.php?autoindex=1"
		} else {
			console.log("test2");
			window.location="switch.php?autoindex=0"
		}
	});
});
</script>
<body>
	<h1 style="width:100%;padding:50px;background-color:#03a5fc">MENU</h1>
	<h2 style="margin-top:100px;padding:50px;width:100%;background-color:#3e6478;color:orange"><a href="/phpmyadmin">PhpMyAdmin</a></h2>
	<h2 style="margin-top:100px;padding:50px;width:100%;background-color:#3e6478;color:white"><a href="/website">Wordpress</a></h2>
	<h2 style="margin-top:100px;padding:50px;width:100%;background-color:#3e6478;color:white">
		<div style="width:100%">
			<h2>SWITCH AUTOINDEX</h2>
			<label class="switch">
			<input class="checkbox" type="checkbox"
				<?php
					if (isset($_GET['start']) && intval($_GET['start']) == 1) {
						echo 'checked="checked"';
					}
				?>>
				<span class="slider round"></span>
			</label>
		</div>
	</h2>
</body>
</html>
