<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
        <head>
                <title>Profile</title>
		<?php include("connectuserdb.php"); ?>
        </head>
        <body>
                <?php
                        $time=4;
                        if($_SESSION[username]==null){
                                echo "Deny Permission";
                                header("Location:login.php");
                                //echo "<meta http-equiv=REFRESH CONTENT=$time;url=login.php>";
                        }
                        else
                                $name = $_SESSION[username];
                ?>
                <h1>Profile</h1>
        	<FORM METHOD=POST ACTION="updatepro.php">
               		Name: <?php echo $name ?><BR>
                	Password: <INPUT TYPE="password" NAME="psw"><BR>
			Email address:  <INPUT TYPE="text" NAME="mailaddr"><BR>
                	<INPUT TYPE="submit" value="Update">
			<INPUT TYPE="button" value="Cancel" onclick="location.href='../2home.php'"></INPUT>
                </FORM>	
		
	</body>
</html>
