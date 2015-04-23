<!DOCTYPE HTML>
<html>
        <head>
				<title>create</title>
				<meta http-equiv="content-type" content="text/html; charset=utf-8" />
			    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=no" />
			    <meta name="mobile-web-app-capable" content="yes" />
			    <meta name="apple-mobile-web-app-capable" content="yes" />
			    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
				<!--<link rel="stylesheet" type="text/css" href="../../../../src/core/famous.css" />-->
			    <!--<link rel="stylesheet" type="text/css" href="../../../assets/css/app.css" />-->
        			<link rel="stylesheet" type="text/css" href="../sequences.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />
				<!--<link rel="stylesheet" type="text/css" href="../../../assets/css/famous_styles.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" />-->
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
			        //require(['create']);
		        </script>	
        </head>
        <body>

	<div class='container'>
		<div class="form-bg">
        		<FORM id='create' METHOD=POST ACTION="newaccount.php">
				<h2>Create account</h2>
				<p>	
				<INPUT TYPE="text" NAME="name"  placeholder="Username">
	        		</p>
				<p>
				<INPUT TYPE="password" NAME="psw"  placeholder="Password">
				</p>
				<p>
				<INPUT TYPE="text" NAME="mailaddr" placeholder="Mail">
				</p>

				<input TYPE="submit" value="Create account"></input>
        		</FORM>
        		<p class="forgot"><a href="login.php">Sign in</a></p>
		</div>
        </div>
	</body>
</html>
