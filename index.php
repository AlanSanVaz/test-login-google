<?php

//Include Configuration File
include('config.php');

$login_button = '';

if (isset($_GET["code"])) {

    $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
    if (!isset($token['error'])) {

        $google_client->setAccessToken($token['access_token']);

        $_SESSION['access_token'] = $token['access_token'];

        $google_service = new Google_Service_Oauth2($google_client);

        $data = $google_service->userinfo->get();

        if (!empty($data['given_name'])) {
            $_SESSION['user_first_name'] = $data['given_name'];
        }

        if (!empty($data['family_name'])) {
            $_SESSION['user_last_name'] = $data['family_name'];
        }

        if (!empty($data['email'])) {
            $_SESSION['user_email_address'] = $data['email'];
        }

        if (!empty($data['gender'])) {
            $_SESSION['user_gender'] = $data['gender'];
        }

        if (!empty($data['picture'])) {
            $_SESSION['user_image'] = $data['picture'];
        }
    }
}

//Ancla para iniciar sesión
if (!isset($_SESSION['access_token'])) {
    //$login_button = '<a href="' . $google_client->createAuthUrl() . '" style=" background: #dd4b39; border-radius: 5px; color: white; display: block; font-weight: bold; padding: 20px; text-align: center; text-decoration: none; width: 200px;">Login With Google</a>';
	$login_button = '<a href="' . $google_client->createAuthUrl() . '" class="btn btn-light">Iniciar sesión con Google <img src="img/logoGoogle.png" style="max-width:10%;"></a>';
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Conoce Tu Pasión - Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
	
	<style>
		.card-header{
			//background: #ff5a2c;
		}
	</style>
</head>

<body style="background: #111b51;">
    <div class="container">
        <br />
        <h2 align="center" style="text-align: center;"><img src="img/logo2.png" style=""></h2>
        <br />
        <div>
            <div class="col-lg-4 offset-4">
                <div class="card">
                    <?php
                    if ($login_button == '') {
                        echo '<div class="card-header" align="center">Bienvenido</div><div class="card-body">';
                        echo '<img src="' . $_SESSION["user_image"] . '" class="rounded-circle container"/>';
                        echo '<h5><b>Name :</b> ' . $_SESSION['user_first_name'] . ' ' . $_SESSION['user_last_name'] . '</h5>';
                        echo '<h5><b>Email :</b> ' . $_SESSION['user_email_address'] . '</h5>';
                        //echo '<h3><a href="logout.php" >Logout</h3>';
						echo '<a href="logout.php" class="btn btn-block btn-danger">Cerrar sesión</a>';
						echo '</div>';
                    } else {
                        echo '<div align="center">' . $login_button . '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>