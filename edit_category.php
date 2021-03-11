<?php
    include_once('config.php');
    if($_POST['update_category_from'] == 'edit_category_from'){
        $dbhandle = db_credentials();
        $category_name = $_POST['category_name'];
        $status = $_POST['status'];
        $category_id = $_POST['category_id'];
        $sql = "UPDATE categories SET category_name = '$category_name',status = '$status' WHERE category_id='$category_id'";
        $query = mysqli_query($dbhandle,$sql);
        if(!mysqli_error($dbhandle)){
            $data['status'] = true;
            $data['message'] = 'Update success';
        }else{
            $data['status'] = false;
            $data['message'] = 'failed to update';
        }
        echo json_encode($data);
    }
?>