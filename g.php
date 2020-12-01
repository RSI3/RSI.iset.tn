<?php

session_start();

$username = "";
$lastName = "";
$email = "";
$CIN="";
$password = "";
$phone = "";
$errors = array();

// connect to the server and select database
$db = mysqli_connect('localhost', 'root', '' ,'rsi');

//if the register button is clicked

if (isset($_POST['Register'])) {
$username = mysqli_escape_string($db,$_POST['username']);
$lastName = mysqli_escape_string($db,$_POST['lastName']);
$email = mysqli_escape_string($db,$_POST['email']);
$CIN = mysqli_escape_string($db,$_POST['CIN']);
$password = mysqli_escape_string($db,$_POST['password']);
$phone = mysqli_escape_string($db,$_POST['phone']);

// ensure that form fields are filled properly
if (empty($username)){
array_push($errors,"Username is required");
}
if (empty($lastName)){
array_push($errors,"lastName is required");
}

if (empty($email)){
array_push($errors,"Email is required");
}

if (empty($CIN)){
array_push($errors,"CIN is required");
}

if (empty($password)){
array_push($errors,"Password is required");
}
if (empty($phone)){
array_push($errors,"phone is required");
}



//if there are no errorsave user to database
if (count($errors)== 0) {
	$password = md5($confirmpassword); // encrypt password before storing 
	$sql = "INSERT INTO registration (username,lastName,email,CIN,password,phone)
	VALUES ('$username','$lastName', '$email','$CIN', '$password','$phone')";
	mysqli_query($db, $sql);
$_SESSION['username'] = $username;
$_SESSION['success'] = "you are now logged in";
header('location: home.php'); //redirect to home page
}
}

//log user from the loginpage

if (isset($_POST['login'])) {
$username = mysqli_escape_string($db,$_POST['email']);
$password = mysqli_escape_string($db,$_POST['Password']);

if (empty($email)){
array_push($errors,"email is required");
}

if (empty($password)){
array_push($errors,"Password is required");
}

  if (count($errors)== 0) {
	$password = md5($password);
	$query = "SELECT * FROM registration WHERE email='$email' AND password='$password'";
	$result = mysqli_query($db, $query);
	  if (mysqli_num_rows($result) == 1){
		//log user in
		$_SESSION['email'] = $email;
		$_SESSION['success'] = "you are now logged in";
		header('location: home.php');
	    }else{
		array_push($errors, "wrong username/password");
	       }
}
	
}

//logout
if (isset($_GET['Logout'])) {
	session_destroy();
	unset($_SESSION['email']);
	header('location: home.php');
          }

?> 