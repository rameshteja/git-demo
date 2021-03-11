<?php session_start();?>
<!doctype html>
<html lang="en">
  <head>
    <title>Home</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
    <h1 class="text-center mt-5 mb-5">Home Page</h1>
        <div class="row mt-10">
        <div class="offset-4"></div>
            <div class="col-md-4">
                <?php
                    if(isset($_SESSION['success'])){
                    echo '<div class="alert alert-success" role="alert">';
                    echo $_SESSION['success'];
                    echo '</div>';
                    }
                    if(isset($_SESSION['error'])){
                    echo '<div class="alert alert-danger" role="alert">';
                    echo $_SESSION['error'];
                    echo'</div>';
                    }
                ?>
                <div class="card">
                    <div class="card-body">
                    <p class="card-text text-center">Sign in to start your session</p>
                        <form action="user_db.php" method="post" onsubmit="return validate();">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="text" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email">
                                <small id="emailError" class="form-text text-danger"></small>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                <small id="passwordError" class="form-text text-danger"></small>
                            </div>
                            <input type="submit" class="btn btn-primary w-100 mb-2" name="login_form" id="login_form">
                            <a href="forgot_password.php">I forgot my password  </a><br>
                            <a href="registration.php">Register a new membership</a>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/project.js"></script>
  </body>
  <?php
    unset($_SESSION['success']);
    unset($_SESSION['error']);
  ?>
</html>