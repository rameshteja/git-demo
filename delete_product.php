<?php
session_start();
include_once('config.php');
if($_POST['delete_product']){
    $con = db_credentials();
    $product_id = $_POST['id'];
    $sql = "delete from products where product_id = '$product_id'";
    // $query = mysqli_query($con,$sql);
    echo mysqli_error($con);
    // exit(); 
    if(mysqli_query($con,$sql)){
        // $_SESSION['success'] = 'Product Deleted Succesfully';
        // header('location:dashboard.php');
        $data['status'] = true;
        $data['message'] = 'Record Deleted Successfully'; 
    }else{
        // $_SESSION['error'] = 'Product Deletetion failed...!';
        // header('location:dashboard.php');
        $data['status'] = false;
        $data['message'] = 'Record Deletion Failed...!'; 
    }
    echo json_encode($data);
}

if($_POST['delete_all']){
    $con = db_credentials();
    if(isset($_POST['product_id'])){
        if($_POST['product_id'] == ''){
            $_SESSION['error'] = 'Please Select Records';
            // header('location:dashboard.php');
            exit();
        }
    }else{
        $_SESSION['error'] = 'Please Select Records';
        header('location:dashboard.php');
        exit();
    }
    $sql = "delete from products where product_id in (".implode(',', $_POST['product_id'] ) . ")";
    $query = mysqli_query($con,$sql);
    if($query){
        $_SESSION['success'] = 'Records Deleted successfully';
        header('location:dashboard.php');

    }else{
        $_SESSION['error'] = mysqli_error($con);
        header('location:dashboard.php'); 

    }
}


?>