<?php session_start();
if($_SESSION['logged_in']){
    include_once('config.php');
    include('user_db.php');
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Home</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous" />
    <style>
        .status_size{
            width: 96px;
            height: 30px;
            line-height: 2;
        }
    </style>
  </head>
  <body>
    <div class="container">
        <?php include_once('header.php');?>
    <h1 class="text-center mt-5 mb-5">Dashboard Page</h1>
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
    <div class="deleteErrmsg"></div>
        <div class="row mt-10">
        <!-- <div class="offset-4"></div> -->
            <div class="col-md-12">
            <div class="card">

                    <div class="card-body">
                        <form action="delete_product.php" method="post">
                            <a href="add_product.php" class="btn btn-primary float-left mb-2"><i class="far fa-plus-square"></i> Add</a>
                            <button type="submit" class="btn btn-danger ml-2 mb-2" name="delete_all" value="delete"><i class="fas fa-trash-alt"></i> Delete</button><br>
                            <table id="table_id" class="display text-center">
                                <thead>
                                    <tr> 
                                        <th><label><input type="checkbox" name="checkAll" id="checkAll"></label></th>
                                        <th>SL.No</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Rating</th>
                                        <th class="text-center">Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $data = product_list();
                                    $i = 1;
                                    // $data = get_records();
                                    // print_r($data);
                                        foreach($data['product_data'] as $key => $value){?>
                                        
                                            <tr>
                                            <td> <input type="checkbox" name="product_id[]" id="product_id" value="<?php echo $value['product_id'];?>"></td>
                                            <td> <?php echo $i;?></td>
                                            <td> <?php echo $value['product_name'];?></td>
                                            <td> <?php echo $value['category_name'];?></td>
                                            <td><?php echo $value['product_price'];?></td>
                                            <td class="text-center"><?php echo $value['rating'];?></td>
                                            <?php 
                                                    if($value['status'] == 'yes'){
                                                        
                                                        echo '<td class="text-center"><span class="badge badge-success status_size">Available</span></div>';
                                                    }else{
                                                        echo '<td class="text-center"><span class="badge badge-danger status_size">Out Of Stock</span></div>';
                                                    }
                                                    $product_id =  $value['product_id'];
                                                ?>
                                                <td class="text-center"><a class="" href="edit_product.php?product_id=<?php echo $value['product_id']?>"><i class="fas fa-pencil-alt"></i></a>&nbsp;&nbsp;<a href="#" class="text-danger" id="delete-product-<?php echo $product_id ?>"><i class="fas fa-trash-alt"></i></a></td>
                                            </tr>
                                            
                                        <?php 
                                        $i++;
                                            }
                                        ?>
                                    </tbody>
                            </table>
                            
                        </form>
                    
                    </div>
                </div>
            </div>
        </div> 
    </div>

    <!-- model -->
    <div class="modal fade" tabindex="-1" role="dialog" id="category_add_model">
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
    <script src="https://code.jquery.com/jquery-3.1.1.min.js">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    
    <script src="js/project.js"></script>
    <script>
        // $(document).ready(function(){
        //     var t = $('#table_id').DataTable( {
        //         "columnDefs": [ {
        //             "searchable": false,
        //             "orderable": false,
        //             "targets": 0
        //         } ],
        //         "order": [[ 1, 'asc' ]]
        //     } );
        
        //     t.on( 'order.dt search.dt', function () {
        //         t.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        //             cell.innerHTML = i+1;
        //         } );
        //     } ).draw();

        //     $('#checkAll').click(function(){
        //         $('input:checkbox').not(this).prop('checked', this.checked);
        //     });
        // });
    </script>
  </body>
  <?php
    unset($_SESSION['success']);
    unset($_SESSION['error']);
    }else{
        echo 'You have been logged out. <a href="index.php">Go back</a>';
    }
  ?>
</html>