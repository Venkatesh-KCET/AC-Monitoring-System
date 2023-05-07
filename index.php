<?php 
	include 'settings.php'; //include settings 
	$error = "Username or Password is invalid"; // Variable To Store Error Message
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login</title>
  <link href="https://getbootstrap.com/docs/4.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="assets/style.css">
</head>

<body>
  <div class="container">
    <div class="row rwcenter">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
        <div class="card card-signin my-5">
          <div class="card-body">
            <h5 class="card-title text-center">Sign In</h5>
			<?php if(isset($_GET['error'])) { ?>
			<div class="alert alert-danger" role="alert" style="border-radius:2rem;"><?php echo $error; ?></div>
			<?php } ?>
            <form class="form-signin" action="includes/login.php" method="POST">
              <div class="form-label-group">
                <input name="login" type="text" id="inputEmail" class="form-control" placeholder="Email address / Username" required autofocus>
                <label for="inputEmail">Email address / Username</label>
              </div>

              <div class="form-label-group">
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>

              <div class="custom-control custom-checkbox mb-3">
                <input type="checkbox" class="custom-control-input" id="customCheck1">
                <label class="custom-control-label" for="customCheck1">Remember password</label>
              </div>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" type="submit" name="submit">Sign in</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
