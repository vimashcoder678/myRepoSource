<?php
include 'config.php';

session_start();

if (isset($_POST['login'])) {
	
	$email = $_POST['email'];
	$password = $_POST['password'];


	$sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password';";

	$userresult = mysqli_query($connect, $sql);

	$result = mysqli_fetch_assoc($userresult);
   
	if ($result) {
		if ($result['email'] == $_POST['email'] && $result['password'] == $_POST['password']) {
			$_SESSION['login'] = $result;
			header("Location:dashboard.php");
		}else{
			header("Location:index.php");
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="w-50 m-auto"> 
	<form action="index.php" method="post" >
		<label class="form-label">Email</label>
		<input type="email" class="form-control" name="email">
		<label class="form-label">Password</label>
		<input type="text" class="form-control" name="password">
		<button type="submit" name="login" class="btn btn-outline-success my-2">LogIn</button>
	</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>