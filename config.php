<?php
// DB Connection
function db_credentials() {
    if ($_SERVER['SERVER_NAME'] === "localhost") {
        $username = "root";
        $password = "root";
        $hostname = "localhost";
        $dbname = 'hb_products';
    } else {
        $username = "bopt_user";
        $password = "Clientaccess=0";
        $hostname = "localhost";
        $dbname = 'hb_products';
    }
    //connection to the database
    $dbhandle = mysqli_connect($hostname, $username, $password,$dbname) or die(mysqli_error($dbhandle));
    return $dbhandle;
}

function check_unique($table,$field,$data){
    $con = db_credentials();
    $sql = "select ".$field." from ".$table." where ".$field."='$data'";
    $check_data = mysqli_query($con,$sql);
    if(mysqli_num_rows($check_data)>0){
        //true found
        return true;
    }else{
        //not found
        return false;
    }
}

?>