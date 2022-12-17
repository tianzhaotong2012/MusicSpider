<?php
$user = array(
	"user_name" => 'tian',
	"user_pass" => 'abcdef',
	"cookie" => 'xsaxasxsxa',
);

if($_COOKIE['user'] == $user['cookie']){
		
}else{
	//not login
	if($_POST['user_name'] == $user['user_name'] && $_POST['user_pass'] == $user['user_pass']){
		setcookie("user",$user['cookie'], time()+3600*24);
		echo "login true";
		header("Location:" . $_SERVER['HTTP_REFERER']); 
		exit();
	}else{
		echo '<form action="login.php" method="post">
  		<p>name: <input type="text" name="user_name" /></p>
  		<p>pass: <input type="text" name="user_pass" /></p>
  		<input type="submit" value="Submit" />
	</form>';
		exit();
	}

}
