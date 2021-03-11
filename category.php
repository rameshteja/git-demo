<?php
    include_once('config.php');
    if($_POST['get_categories']){
        $data = get_all_categories();
        echo json_encode($data);
    }
// print_r($_POST['category_id']);
    // function for geting all categories
    function get_all_categories(){
        $dbhandle = db_credentials();
        $sql = "select * from categories";
        $query = mysqli_query($dbhandle,$sql);
        if(mysqli_num_rows($query)>0){
            
            $arr = [];
            while($row = mysqli_fetch_assoc($query)){
                $row['category_name'] = ucfirst($row['category_name']);
                $arr[] = $row;
            }
            $data['status'] = true;
            $data['message'] = $arr;
        }else{
            echo 'ok';
            $data['status'] = false;
            $data['message'] = 'No records found...!';
        }
        return $data;
    }

    if($_POST['category_single_delete']){
        $msg = '';
        if(isset($_POST['category_id'])){
            if(empty($_POST['category_id'])){
                $msg .= 'category Id required';
            }
        }else{
            $msg .= 'category Id required';
        }

        if($msg == ''){
            $data = delete_single_category($_POST['category_id']);
        }else{
            $data['status'] = false;
            $data['message'] = $msg;
        }
        echo json_encode($data);
    }

    function delete_single_category($id){
        $dbhandle = db_credentials();
        $sql = "delete from categories where category_id = $id";
        if(mysqli_query($dbhandle,$sql)){
            $data['status'] = true;
            $data['message'] = 'Category deleted successfully';
        }else{
            $data['status'] = false;
            $data['message'] = mysqli_error($dbhandle);
        }
        return $data;
    }
    // delete all
    if($_POST['category_delete_all']){
        $dbhandle = db_credentials();
        $sql = "delete from categories where category_id in (".implode(',', $_POST['category_id'] ) . ")";
        $query = mysqli_query($dbhandle,$sql);
        if($query){
            $_SESSION['success'] = 'Records Deleted successfully';
            header('location:category_listing.php');
            exit();
    
        }else{
            $_SESSION['error'] = mysqli_error($con);
            header('location:category_listing.php'); 
            exit();
    
        }
    }
    // category add
    if($_POST['category_add'] == 'add_category'){
        $msg = '';
        if(isset($_POST['category_name'])){
            if(empty($_POST['category_name'])){
                $msg = 'Category Name required';
            }
        }else{
            $msg = 'Category Name required';
        }

        if($msg == ''){
            $data = add_category();
        }else{
            $data['status'] = false;
            $data['message'] = $msg;
        }
        echo json_encode($data);
    }
    function add_category(){
        $dbhandle = db_credentials();
        $category_name = $_POST['category_name'];
        $status = $_POST['status'];
        $sql = "INSERT INTO categories (category_name, status) values ('$category_name','$status')";
        if(mysqli_query($dbhandle,$sql)){
            $data['status'] = true;
            $data['message'] = 'Category Inserted Successfully';
            $data['category_name'] = $category_name;
            $data['category_id'] = mysqli_insert_id($dbhandle);
        }else{
            $data['status'] = false;
            $data['message'] = mysqli_error($dbhandle);
        }
        return $data;
    }
    if($_POST['edit_category']){
        // print_r($_POST);
        $dbhandle = db_credentials();
        $category_id = $_POST['category_id'];
        $sql = "select * from categories where category_id = $category_id";
        $query = mysqli_query($dbhandle,$sql);
        if(mysqli_num_rows($query)>0){
            $row = mysqli_fetch_assoc($query);
            $data['status'] = true;
            $data['message'] = $row;
        }else{
            $data['status'] = true;
            $data['message'] = 'no records';
        }
        echo json_encode($data);
    }
    
?>
