<?php
//Codigo que muestra solo los errores exceptuando los notice.
error_reporting(E_ALL & ~E_NOTICE);
?>
<?php session_start();

if ($_SESSION["logueado"]==TRUE) {
	Header("Location: pages/main.php");
}else {
	$errorLogin=$_GET["error"];
	if($errorLogin=="login") {
		$error="El usuario o contraseña es invalido.";
		msg($error);
	 }
}
 ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>SistemaContable</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
		<link rel="stylesheet" href="assets/css/main.css"/>
		<link rel="stylesheet" href="assets/css/login.css"/>
		<!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
		<!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
		<script type="text/javascript">
function llamar(){
	mostraLog(" ");
//	location.href="pages/Cuenta.php";
}
		function mostraLog(str){
if (str==""){document.getElementById("logindiv").innerHTML="";return;}
if (window.XMLHttpRequest){// code for IE7+, Firefox, Chrome, Opera, Safari
xmlhttp=new XMLHttpRequest();}
else  {// code for IE6, IE5
xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
}xmlhttp.onreadystatechange=function(){if (xmlhttp.readyState==4 && xmlhttp.status==200){document.getElementById("logindiv").innerHTML=xmlhttp.responseText;}}

xmlhttp.open("GET","pages/ajaxUser.php",true);
xmlhttp.send();
}
		</script>

	</head>
	<body class="loading">
		<div id="wrapper">
			<div id="bg"></div>
			<div id="overlay"></div>
			<div id="main">
				<!-- Header -->

					<header id="header">
						<h1>Sistema Contable</h1>
						<p>CODIFI</p>
						<nav>
							<ul>
								<li class="tooltip"><a class="icon fa-user" onclick="llamar()"><span class="label tooltiptext">Iniciar Sesion</span></a></li>

							<!--
								<li><a href="#" class="icon fa-archive"><span class="label">Facebook</span></a></li>
								<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
								<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
								<li><a href="#" class="icon fa-envelope-o"><span class="label">Email</span></a></li>!
							-->
							</ul>
							<ul>
									<div id="logindiv">

									</div>
							</ul>
						</nav>
					</header>


				<!-- Footer -->
					<footer id="footer">
						<span class="copyright">&copy; Pacholi2018. CODIFI 2018.</span>
					</footer>

			</div>
		</div>
		<!--[if lte IE 8]><script src="assets/js/ie/respond.min.js"></script><![endif]-->
		<script>
			window.onload = function() { document.body.className = ''; }
			window.ontouchmove = function() { return false; }
			window.onorientationchange = function() { document.body.scrollTop = 0; }
		</script>
	</body>
</html>
<?php
function msg($texto)
{
    echo "<script type='text/javascript'>";
    echo "alert('$texto');";
  //  echo "document.location.href='cuenta.php';";
    echo "</script>";
}

 ?>
