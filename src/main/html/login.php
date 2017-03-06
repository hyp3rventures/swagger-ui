<?php
$username = null;
$password = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if(!empty($_POST["username"]) && !empty($_POST["password"])) {
		$username = $_POST["username"];
		$password = $_POST["password"];

		if($username == getenv('USERNAME') && $password == getenv('PASSWORD')) {
			session_start();
			$_SESSION["authenticated"] = 'true';
			header('Location: index.php');
		}
		else {
			header('Location: login.php');
		}

	} else {
		header('Location: login.php');
	}
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">
	<title>Hyp3r Core API Documentation</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="css/index.css" rel="stylesheet"/>
	<link href="css/login.css" rel="stylesheet"/>
	<script type="text/javascript">
		$( ".input" ).focusin(function() {
		$( this ).find( "span" ).animate({"opacity":"0"}, 200);
		});

		$( ".input" ).focusout(function() {
		$( this ).find( "span" ).animate({"opacity":"1"}, 300);
		});

		$(".login").submit(function(){
		$(this).find(".submit i").removeAttr('class').addClass("fa fa-check").css({"color":"#fff"});
		$(".submit").css({"background":"#2ecc71", "border-color":"#2ecc71"});
		$(".feedback").show().animate({"opacity":"1", "bottom":"-80px"}, 400);
		$("input").css({"border-color":"#2ecc71"});
		return false;
		});
	</script>
</head>
<body>

<form id="login" class="login" method="post">
	<fieldset>
		<legend class="legend">Login</legend>
		<div class="input">
			<input id="username" name="username" placeholder="Username" required />
		<!--<span><i class="fa fa-envelope-o"></i></span>-->
		</div>
		<div class="input">
			<input id="password" name="password" type="password" placeholder="Password" required />
		<!--<span><i class="fa fa-lock"></i></span>-->
		</div>

		<input type="submit" class="submit" value="Go">
			<!--<i class="fa fa-long-arrow-right"></i>-->
		</button>
	</fieldset>

	<div class="feedback">
		login successful <br />
		redirecting...
	</div>
</form>

</body>
</html>
<?php } ?>
