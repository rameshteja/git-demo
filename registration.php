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
    <h1 class="text-center mt-5 mb-5">User Registration Page</h1>
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
        <div class="row">
        <!-- <div class="offset-4"></div> -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <p class="card-text text-center">Please Fill bellow fields</p>
                        <form action="user_db.php" method="post" onsubmit="return validate_userRegister();">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="oldpassword">Name</label>
                                    <input type="text" class="form-control" id="userName" name="userName"placeholder="Enter User Name">
                                    <small id="userNameError" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Email</label>
                                    <input type="text" class="form-control" id="userEmail" name="userEmail" placeholder="Enter User Email">
                                    <small id="userEmailError" class="form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                      <option value="">Select</option>
                                      <option value="male">Male</option>
                                      <option value="female">Female</option>
                                    </select>
                                    <small id="genderError" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Mobile</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile">
                                    <small id="mobileError" class="form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Date Of Birth</label>
                                    <input type="date" class="form-control" data-date-end-date="0d" id="dob" name="dob">
                                    <small id="dobError" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                    <small id="passwordError" class="form-text text-danger"></small>
                                </div>
                            </div>
                            
                            <input type="submit" class="btn btn-primary mb-2" name="register" id="register"><br>
                            <a href="index.php">I already have a membership </a><br>
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