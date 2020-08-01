<?php
require_once 'core/init.php';
if(isset($_SESSION['user_id'])){
	header('Location: home.php');
}


if(isset($_POST['login']) && !empty($_POST['login'])){

	$email = $_POST['email_login'];
	$password = $_POST['password_login'];

	if(!empty($email) or !empty($password)){
		$email = $getFromU->checkInput($email);
		$password = $getFromU->checkInput($password);

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$error = "Invalidad Format";
		}else{
			if($getFromU->login($email,$password) === false){
				$error = "The email or the username is incorrect";
			}else{

			}
		}

	}else{
		$error = "Please insert username and password";
	}
}


if(isset($_POST['signup'])){
    $email = $_POST['email_signup'];
    $username = $_POST['username_signup'];
    $password = $_POST['password_signup'];
    $password1 = $_POST['password1_signup'];
    if($password === $password1){
        if(empty($username) or empty($email) or empty($password)){
            $error = "All fields are required";
        }else{
            $email = $getFromU->checkInput($email);
            $password = $getFromU->checkInput($password);
            $username = $getFromU->checkInput($username);

            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $error="Email invalidate";
            }elseif(strlen($username) > 20){
                $error="Name must be between 6-20 characters";
            }elseif(strlen($password) < 5){
                $error="Password is too short";
            }else{
                if($getFromU->checkEmail($email) === true){
                    $error="This email is already in use";
                }else{
                    $hashed = hash('sha512', $password);
                    $user_id = $getFromU->create('user', array('email'=>$email,'password'=> $hashed, 'username' => $username, 'cover'=>'assets/public/defaultCover.jpg', 'profile'=>'assets/public/defaultProfile.jpg'));
                    $_SESSION['user_id'] = $user_id;
                    header('Location: home.php');
                }
            }
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
    <link rel="stylesheet" href="./assets/css/reset.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="./assets/css/all.min.css">
</head>
<body>
    <main class="main-container-index">
        <div class="shader-background">
            <div class="singup-login-forms">
                <div class="tabs-signup-login">
                    <span class="tab-signup-login active" id="login-button">Login</span>
                    <span class="tab-signup-login" id="signup-button">Signup</span>
                </div>
                <div class="form-container" id="login-form" style='display: block;'>
                    <form method="POST" action="index.php">
                        <div class="input-container">
                            <div class="icon-input-container">
                                <div class="icon-input-aligner">
                                    <i class="fas fa-at"></i>
                                </div>
                            </div>
                            <input type="text" name="email_login" placeholder="Email" class="input-text-login-signup-form">
                        </div>
                        <div class="input-container">
                            <div class="icon-input-container">
                                <div class="icon-input-aligner">
                                    <i class="fas fa-unlock"></i>
                                </div>
                            </div>
                            <input type="password" name="password_login" placeholder="Password" class="input-text-login-signup-form">
                        </div>
                        <input type="submit" class="login-signup-button" name="login" value="Login ">
                    </form>
                </div>
                <div class="form-container" id="signup-form" style="display:none;">
                    <form method="POST" action="index.php">
                            <div class="input-container">
                                <div class="icon-input-container">
                                    <div class="icon-input-aligner">
                                        <i class="fas fa-at"></i>
                                    </div>
                                </div>
                                <input type="text" name="email_signup" placeholder="Email" class="input-text-login-signup-form">
                            </div>
                            <div class="input-container">
                                <div class="icon-input-container">
                                    <div class="icon-input-aligner">
                                            <i class="fas fa-user"></i>
                                    </div>
                                </div>
                                <input type="text" name="username_signup" placeholder="Username" class="input-text-login-signup-form">
                            </div>
                            <div class="input-container">
                                <div class="icon-input-container">
                                    <div class="icon-input-aligner">
                                        <i class="fas fa-unlock"></i>
                                    </div>
                                </div>
                                <input type="password" name="password_signup" placeholder="Password" class="input-text-login-signup-form">
                            </div>
                            <div class="input-container">
                                <div class="icon-input-container">
                                    <div class="icon-input-aligner">
                                        <i class="fas fa-unlock"></i>
                                    </div>
                                </div>
                                <input type="password" name="password1_signup" placeholder="Re - Password" class="input-text-login-signup-form">
                            </div>
                            <input type="submit" class="login-signup-button" name="signup" value="Login">
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script src="./assets/js/jquery.js"></script>
    <script>
    $("#login-button").click(function(e){
        $("#login-form").css("display", "block");
        $("#login-button").addClass("active");

        $("#signup-button").removeClass("active");
        $("#signup-form").css("display", "none");
    });

    $("#signup-button").click(function(e){
        $("#signup-form").css("display", "block");
        $("#signup-button").addClass("active");

        $("#login-button").removeClass("active");
        $("#login-form").css("display", "none");
    });
    </script>
</body>
</html>