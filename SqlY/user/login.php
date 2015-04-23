<!DOCTYPE HTML>
<html>
	<head>
		<title>hello</title>
		 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=no" />
        <meta name="mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<!--<link rel="stylesheet" type="text/css" href="../../../../src/core/famous.css" />-->
        <!--<link rel="stylesheet" type="text/css" href="../../../assets/css/app.css" />-->
        <link rel="stylesheet" type="text/css" href="../sequences.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
	<!--<link rel="stylesheet" type="text/css" href="../../../assets/css/famous_styles.css?" />-->
        <script type="text/javascript" src="../../../assets/lib/functionPrototypeBind.js"></script>
        <script type="text/javascript" src="../../../assets/lib/classList.js"></script>
        <script type="text/javascript" src="../../../assets/lib/requestAnimationFrame.js"></script>
        <script type="text/javascript" src="../../../assets/lib/require.js"></script>
        <script type="text/javascript">
            require.config({
                paths: {
                    famous: '../../../../src'
                }
            });
            //require(['login']);
        </script>

	</head>
	<body>
	<div class='container'>
		<div class="form-bg">
			<FORM id='login' METHOD=POST ACTION="check.php">
				<h2>Sqly Login</h2>
				<p>
				<INPUT TYPE="text" NAME="name" placeholder="Username" value="<?php if(isset($_COOKIE["user"])){ echo $_COOKIE['user'];}?>"/>
				</p>
				<p>
				<INPUT TYPE="password" NAME="psw" placeholder="Password" value="<?php if(isset($_COOKIE["psw"])){echo $_COOKIE['psw'];}?>"/>
				</p>
				<label for="remember">
					  <input type="checkbox" id="remember" value="remember">
					  <span>Remember me</span>
				</label>
					<button TYPE="submit" value="Sign in"></button>
			</FORM>
			<p class="forgot"><a href="create.php">Create account</a></p>
		</div>

	</div>
	</body>
</html>
