<?php include('server.php') ?>
<!doctype html>
<html lang="en">
<head>
    <title>Sign Up</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body class="img js-fullheight" style="background-image: url(images/bg.jpg);">
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
                <h2 class="heading-section">Sign Up</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="login-wrap p-0">
                    <h3 class="mb-4 text-center">Create an account</h3>
                    <form  method="post" action="register.php" class="signin-form">
                      <?php include('errors.php'); ?>
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Username"  name="username" value="<?php echo $username; ?>" required >
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                        </div>
                        <div class="form-group">
                            <input id="password-field" type="password" class="form-control" placeholder="Password"  name="password_1" required>
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <input id="password-confirm-field" type="password" class="form-control" placeholder="Confirm Password"  name="password_2"required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="form-control btn btn-primary submit px-3" name="reg_user">Sign Up</button>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-50">
                                <label class="checkbox-wrap checkbox-primary">Remember Me
                                    <input type="checkbox" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="w-50 text-md-right">
                                <a href="login.php" style="color: #fff">Sign In</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="js/jquery.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
