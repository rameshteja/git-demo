<?php session_start();
if($_SESSION['logged_in']){
    include_once('config.php');
    include_once('user_db.php');
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Product Edit</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
        <div class="container">
        <?php include_once('header.php');?>
    <h1 class="text-center mt-5 mb-5">Edit Product Page</h1>
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

        // getting data from url id
        $product_id = $_GET['product_id'];
        $data = edit_product_data($product_id);
        // print_r($data);
      ?>
        <div class="row">
        <!-- <div class="offset-4"></div> -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="user_db.php" method="post" onsubmit="return validate_editProduct();">
                            <div class="row">
                                <div class="form-group col-md-6">
                                <input type="hidden" class="form-control" id="product_id" name="product_id" value="<?php echo $data['product_id'];?>">
                                    <label for="oldpassword">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?php echo $data['product_name'];?>" placeholder="Product Name">
                                    <small id="nameError" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Code</label>
                                    <input type="nubmer" class="form-control" id="code" name="code" value="<?php echo $data['code'];?>" readonly placeholder="Product Code">
                                    <small id="quantityError" class="form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Price</label>
                                    <input type="text" class="form-control" id="price" name="price" value="<?php echo $data['product_price'];?>" placeholder="Product Price">
                                    <small id="priceError" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Rating</label>
                                    <input type="nubmer" class="form-control" id="rating" name="rating" value="<?php echo $data['rating'];?>" placeholder="Product Rating"> 
                                    <small id="ratingError" class="form-text text-danger"></small>
                                </div>
                            </div>
                            <div class="row">
                            <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Category</label>
                                    <select name="category" id="category" class="form-control">
                                      <option value="">Select</option>
                                      <?php
                                        $categories_data = get_categories();
                                        
                                        foreach($categories_data as $key=>$row){
                                              if($row['category_id'] == $data['category_id']){
                                                  $selected = 'selected';
                                              }else{
                                                  $selected = '';
                                              }
                                            echo '<option value="'.$row['category_id'].'" '.$selected.'>'.ucfirst($row['category_name']).'</option>';
                                          }
                                      ?>
                                    </select>
                                    <small id="categoryError" class="form-text text-danger"></small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputPassword1">Status</label>
                                    <select name="status" id="status" class="form-control">
                                      <option value="">Select</option>
                                      <option value="yes" <?php if($data['status'] == 'yes'){ echo 'selected';}?>>Available</option>
                                      <option value="no" <?php if($data['status'] == 'no'){ echo 'selected';}?>>Out Of Stock</option>
                                    </select>
                                    <small id="statusError" class="form-text text-danger"></small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <label><input type="radio" class="" name="stay" id="stay" value="stay_here" checked> Stay Here</label>
                                    <label><input type="radio" class="" name="stay" id="stay" value="back_to_dashboard"> Back To Listing</label>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="btn btn-primary mb-2" name="edit_product" id="edit_product" value="Update">
                                    <a href="dashboard.php" class="btn btn-info mb-2">Back</a>
                                </div>
                            </div>
                            
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
    }else{
        echo 'You have been logged out. <a href="index.php">Go back</a>';
    }
  ?>
</html>