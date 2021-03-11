<?php session_start();
if($_SESSION['logged_in']){
  include_once('config.php');
  include_once('user_db.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Product Add</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <style>
      .errormsg{
        color:red;
      }
    </style>
  </head>
  <body>
    <div class="container-fluid">
    <?php include_once('header.php');?>
    <h1 class="text-center mt-5 mb-5">Add Product Page</h1>
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
        // echo 'ok';
        // $cdata = get_categories();
        //   print_r($cdata);
      ?>
        <div class="row">
        <!-- <div class="offset-4"></div> -->
            <div class="col-md-12 mb-2">
                <form id="addProductForm" action="user_db.php" method="post">
                    <table class="table">
                      <thead>
                        <tr>
                          <!-- <th>Sl.no</th> -->
                          <th>Name</th>
                          <th>Code</th>
                          <th>Category </th>
                          <!-- <button type="button" class="btn btn-primary mb-2 float-right" data-toggle="modal" data-target="#category_add_model_1"><i class="far fa-plus-square"></i></button> -->
                          <th>Price</th>
                          <th>Rating</th>
                          <th>Status</th>
                          <th><button type="button" class="btn btn-success" onclick="add_new_row();"><i class="far fa-plus-square"></i></button></th>
                        </tr>
                      </thead>
                      <tbody class="product_body">
                      <form id="addProductForm" action="user_db.php" method="post">
                        <tr id="row_1" class="product_row">
                          <!-- <td >1</td> -->
                          <td>
                            <input type="text" name="name[]" id="name_1" class="form-control" onkeyup = "copytext(this);" placeholder="Product Name">
                            <div class="errormsg" id="errname_1" >
                          </td>
                          <td>
                            <input type="text" name="code[]" id="code_1" class="form-control" placeholder="Product Code">
                            <div class="errormsg" id="errcode_1" >
                          </td>
                          <td>
                          <select name="category[]" id="category_1" class="form-control">
                            <!-- js categories will load heare -->
                            </select>
                          <div class="errormsg" id="errcategory_1" >
                          </td>
                          <td>
                            <input style="width:90px" type="text" name="price[]" id="price_1" class="form-control" placeholder="Price">
                            <div class="errormsg" id="errprice_1" >
                          </td>
                          <td>
                            <input style="width:90px" type="text" name="rating[]" id="rating_1" class="form-control" placeholder="Rating">
                            <div class="errormsg" id="errrating_1" >
                          </td>
                          <td>
                              <select name="status[]" id="status_1" class="form-control">
                                      <option value="yes">Available</option>
                                      <option value="no">Out Of Stock</option>
                              </select>
                              <div class="errormsg" id="errstatus_1" >
                          </td>
                          <td></button></td>
                        </tr>
                        
                      </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <label><input type="radio" class="" name="stay" id="stay" value="stay_here" checked> Stay Here</label>
                            <label><input type="radio" class="" name="stay" id="stay" value="back_to_dashboard"> Back To Listing</label>

                        </div>
                    </div>
                    <div class="row mt-2">
                          <div class="col md-12 text-center">
                              <div class="col md-12">
                                    <input type="submit" class="btn btn-primary mb-2" name="add_product" id="add_product" value="Submit">
                                    <a href="dashboard.php" class="btn btn-info mb-2">Back</a>
                                </div>
                          </div>
                      </div>
                </form>

            </div>
        </div> 
    </div>
    <!-- model -->
    <div class="modal fade" tabindex="-1" role="dialog" id="category_add_model_1">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Add Category</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12"><div id="modelError"></div></div>
                <div class="form-group col-md-12">
                    <label for="exampleInputPassword1">Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Category Name">
                    <small id="categoryError" class="form-text text-danger"></small>
                </div>
                <div class="form-group col-md-12">
                  <select name="status" id="status" class="form-control">
                      <option value="active">Active</option>
                      <option value="inactive">Inactive</option>
                  </select>
                  <div class="errormsg" id="errstatus_1" >
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="add_form_submit">Submit</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <!-- model ends -->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1"></script> -->
    <script src="js/jquery.validate.js"></script>
    <script src="js/project.js"></script>
   
  </body>
  <?php
    unset($_SESSION['success']);
    unset($_SESSION['error']);
    }else{
        echo 'You have been logged out. <a href="index.php">Go back</a>';
    }
  ?>
</html>