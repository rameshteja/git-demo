<?php
session_start();
include_once('config.php');
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);

    // adding user
    if($_POST['register']){
        if(isset($_POST['userName'])){
            if($_POST['userName'] != ''){
                $name = $_POST['userName'];
            }else{
                $_SESSION['error'] = "user name required...!";
                header('location:registration.php');
            }
        }else{
            $_SESSION['error'] = "user name required...!";
            header('location:registration.php');
        }
        if(isset($_POST['userEmail'])){
            if($_POST['userEmail'] != ''){
                $email = $_POST['userEmail'];
            }else{
                $_SESSION['error'] = "user email required...!";
                header('location:registration.php');
            }
            
        }else{
            $_SESSION['error'] = "user email required...!";
            header('location:registration.php');
        }

        if(isset($_POST['gender'])){
            if($_POST['gender'] != ''){
                $gender = $_POST['gender'];
            }else{
            $_SESSION['error'] = "gender required...!";
                header('location:registration.php');
            }
            
        }else{
            $_SESSION['error'] = "gender required...!";
                header('location:registration.php');
        }

        if(isset($_POST['mobile'])){
            if($_POST['mobile'] != ''){
                $mobile = $_POST['mobile'];
            }else{
                $_SESSION['error'] = "mobile required...!";
                header('location:registration.php');
            }
            
        }else{
            $_SESSION['error'] = "mobile required...!";
            header('location:registration.php');
        }

        if(isset($_POST['dob'])){
            if($_POST['dob'] != ''){
                $dob = $_POST['dob'];
            }else{
                $_SESSION['error'] = "dob required...!";
                header('location:registration.php');
            }
            
        }else{
            $_SESSION['error'] = "dob required...!";
            header('location:registration.php');
        }

        if(isset($_POST['password'])){
            if($_POST['password'] != ''){
                $password = md5($_POST['password']);
            }else{
                $_SESSION['error'] = "password required...!";
                header('location:registration.php');
            }
            
        }else{
            $_SESSION['error'] = "password required...!";
            header('location:registration.php');
        }
        $con = db_credentials();
        // add query 
        $date_time = date('Y-m-d h:i:s');
        $sql =  "INSERT INTO `users`(`user_name`, `user_email`, `gender`, `mobile`, `password`, `dob`, `status`) 
        VALUES ('$name','$email','$gender','$mobile','$password','$dob','1')";
        $query = mysqli_query($con,$sql);
        if(mysqli_affected_rows($con)){
            $_SESSION['success'] = 'User Registration success';
            header('location:registration.php');
        }else{
            $_SESSION['error'] = 'User Registration Failed...!';
            header('location:registration.php');
        }

    }
    //condition for login user
    if($_POST['login_form']){
        echo 'ok';
        if(isset($_POST['email'])){
            if($_POST['email'] == ''){
                $_SESSION['error'] = "email required...!";
                header('location:index.php');
            }else{
                $email = $_POST['email'];
            }
        }else{
            $_SESSION['error'] = "email required...!";
                header('location:index.php');
        }

        if(isset($_POST['password'])){
            if($_POST['password'] == ''){
                $_SESSION['error'] = "password required...!";
                header('location:index.php');
            }else{
                $password = md5($_POST['password']);
            }
        }else{
            $_SESSION['error'] = "password required...!";
                header('location:index.php');
        }
        $con = db_credentials();
        $lsql = "select * from users where user_email = '$email' and password = '$password'";
        $lquery = mysqli_query($con,$lsql);
        if(mysqli_num_rows($lquery)>0){
            $_SESSION['success'] = 'login success';
            $_SESSION['logged_in'] = true;
            // $_SESSION['user_data'] = mysqli_fetch_assoc($lquery);
            header('location:dashboard.php');
        }else{
            $_SESSION['error'] = 'invalid email/password';
            header('location:index.php');
        }
    }

    // adding product 
    if($_POST['add_product']){

        if(isset($_POST['name'])){
            if($_POST['name'] == ''){
                $_SESSION['error'] = "Name required...!";
                header('location:add_product.php');
                exit();
            }else{

                $name = $_POST['name'];
            }
        }else{
            $_SESSION['error'] = "Name required...!";
            header('location:add_product.php');
            exit();
        }

        if(isset($_POST['category'])){
            if($_POST['category'] == ''){
                $_SESSION['error'] = "category required...!";
                header('location:add_product.php');
            }else{
                $category = $_POST['category'];
            }
        }else{
            $_SESSION['error'] = "category required...!";
            header('location:add_product.php');
            exit();
        }

        if(isset($_POST['price'])){
            if($_POST['price'] == ''){
                $_SESSION['error'] = "price required...!";
                header('location:add_product.php');
                exit();
            }else{
                $price = $_POST['price'];
            }
        }else{
            $_SESSION['error'] = "price required...!";
            header('location:add_product.php');
            exit();
        }

        if(isset($_POST['rating'])){
            if($_POST['rating'] == ''){
                $_SESSION['error'] = "rating required...!";
                header('location:add_product.php');
                exit();
            }else{
                $rating = $_POST['rating'];
            }
        }else{
            $_SESSION['error'] = "rating required...!";
            header('location:add_product.php');
            exit();
        }

        if(isset($_POST['status'])){
            if($_POST['status'] == ''){
                $_SESSION['error'] = "status required...!";
                header('location:add_product.php');
                exit();
            }else{
                $status = $_POST['status'];
            }
        }else{
            $_SESSION['error'] = "status required...!";
            header('location:add_product.php');
            exit();
        }

        if(isset($_POST['code'])){
            if($_POST['code'] == ''){
                $_SESSION['error'] = "code required...!";
                header('location:add_product.php');
                exit();
            }else{
                for($j =0; $j<count($_POST['code']);$j++){
                    if(!check_unique('products','code',$_POST['code'][$j])){
                        $code = $_POST['code'];
                    }else{
                        $_SESSION['error'] = $_POST['code'][$j]." Code Already taken...!";
                        header('location:add_product.php');
                        exit(); 
                    }
                }
            }
        }else{
            $_SESSION['error'] = "code required...!";
            header('location:add_product.php');
            exit();
        }

        // if(isset($_POST['quantity'])){
        //     if($_POST['quantity'] == ''){
        //         $_SESSION['error'] = "quantity required...!";
        //         header('location:add_product.php');
        //         exit();
        //     }else{
        //         $quantity = $_POST['quantity'];
        //     }
        // }else{
        //     $_SESSION['error'] = "quantity required...!";
        //     header('location:add_product.php');
        //     exit();
        // }
        $countVal = count($_POST['name']);
        $con = db_credentials();
        $psql = "insert into products(product_name,code,product_price,quantity,category_id,rating,status)
        values ";
        for($i =0; $i<count($_POST['name']);$i++){
            if ($i == count($_POST['name'])-1){
                $psql .= "('".$name[$i]."', '".$code[$i]."', '".$price[$i]."', '', '".$category[$i]."', '".$rating[$i]."', '".$status[$i]."');";
            }else{
                $psql .= "('".$name[$i]."', '".$code[$i]."', '".$price[$i]."', '', '".$category[$i]."', '".$rating[$i]."', '".$status[$i]."'),";
            }
        }
        // echo $psql;
        // exit();
        $psql = mysqli_query($con,$psql);
        if(mysqli_affected_rows($con)){
            $_SESSION['success'] = 'Product Added success';
            header('location:add_product.php');
            if($_POST['stay'] == 'stay_here'){
                header('location:add_product.php');
            }else if($_POST['stay'] == 'back_to_dashboard'){
                header('location:dashboard.php');
            }
        }else{
            $_SESSION['error'] = 'Product Add Failed...!';
            header('location:add_product.php');
        }

    }

    // editing product 
    if($_POST['edit_product']){

        if(isset($_POST['name'])){
            if($_POST['name'] == ''){
                $_SESSION['error'] = "Name required...!";
                header('location:dashboard.php');
            }else{
                $name = $_POST['name'];
            }
        }else{
            $_SESSION['error'] = "Name required...!";
            header('location:dashboard.php');
        }

        if(isset($_POST['category'])){
            if($_POST['category'] == ''){
                $_SESSION['error'] = "category required...!";
                header('location:dashboard.php');
            }else{
                $category = $_POST['category'];
            }
        }else{
            $_SESSION['error'] = "category required...!";
            header('location:dashboard.php');
        }

        if(isset($_POST['price'])){
            if($_POST['price'] == ''){
                $_SESSION['error'] = "price required...!";
                header('location:dashboard.php');
            }else{
                $price = $_POST['price'];
            }
        }else{
            $_SESSION['error'] = "price required...!";
            header('location:dashboard.php');
        }

        if(isset($_POST['rating'])){
            if($_POST['rating'] == ''){
                $_SESSION['error'] = "rating required...!";
                header('location:dashboard.php');
            }else{
                $rating = $_POST['rating'];
            }
        }else{
            $_SESSION['error'] = "rating required...!";
            header('location:dashboard.php');
        }

        if(isset($_POST['status'])){
            if($_POST['status'] == ''){
                $_SESSION['error'] = "status required...!";
                header('location:dashboard.php');
            }else{
                $status = $_POST['status'];
            }
        }else{
            $_SESSION['error'] = "status required...!";
            header('location:dashboard.php');
        }

        // if(isset($_POST['quantity'])){
        //     if($_POST['quantity'] == ''){
        //         $_SESSION['error'] = "quantity required...!";
        //         header('location:dashboard.php');
        //     }else{
        //         $quantity = $_POST['quantity'];
        //     }
        // }else{
        //     $_SESSION['error'] = "quantity required...!";
        //     header('location:dashboard.php');
        // }

        if(isset($_POST['product_id'])){
            if($_POST['product_id'] == ''){
                $_SESSION['error'] = "product id required...!";
                header('location:dashboard.php');
            }else{
                $product_id = $_POST['product_id'];
            }
        }else{
            $_SESSION['error'] = "product id required...!";
            header('location:dashboard.php');
        }
        $con = db_credentials();
        $psql = "update products set product_name = '$name', product_price = '$price', quantity = '$quantity', category_id = '$category', rating = '$rating', status = '$status' where product_id = '$product_id'";

        $psql = mysqli_query($con,$psql);
        if(mysqli_error($con)){
            $_SESSION['error'] = 'Product update Failed...!';
        }else{
            $_SESSION['success'] = 'Product Update success';
        }
        if($_POST['stay'] != ''){
            if($_POST['stay'] == 'stay_here'){
                header('location:edit_product.php?product_id='.$product_id);
            }else if($_POST['stay'] == 'back_to_dashboard'){
                header('location:dashboard.php');
            }
        }else{
            header('location:edit_product.php?product_id='.$product_id);
        }
    }
    if($_POST['category_get']){
        $data['data'] = get_categories();
        echo json_encode($data);
    }
    function get_categories(){
        $con = db_credentials();
        $csql = "select * from categories order by category_name asc";
        $cquery = mysqli_query($con,$csql);
        if(mysqli_num_rows($cquery)>0){
            $arr =[];
            while($row = mysqli_fetch_assoc($cquery)){
                $row['category_name'] = ucfirst($row['category_name']);
            $arr[] = $row;
            }
        }
        return $arr;    
    }

    function product_list(){
        $con = db_credentials();
        $product_sql = "select  * from products order by product_name asc";
        $product_query = mysqli_query($con,$product_sql);
        if(mysqli_num_rows($product_query)>0){
            $arr = [];
            while($row = mysqli_fetch_assoc($product_query)){
                $category_id = $row['category_id'];
                $csql = "select category_name from categories where category_id = $category_id";
                $cquery = mysqli_query($con,$csql);
                $crow = mysqli_fetch_assoc($cquery);
                $row['category_name'] = $crow['category_name'];
                $arr[] = $row;
            }
            $data['product_data'] = $arr;
        }else{
            $data['product_data'] = $arr;
        }
        return $data;
    }

    function edit_product_data($id){
        $con = db_credentials();
        $sql = "select * from products where product_id = $id";
        $query = mysqli_query($con,$sql);
        $data = mysqli_fetch_assoc($query);
        return $data;  
    }

    // condition for checking unique code value
    if($_POST['code']){
        if(check_unique('products','code',$_POST['code'][0])){
            $data = 'false';
        }else{
            $data = 'true';
        }
        echo($data);
    }
    
?>