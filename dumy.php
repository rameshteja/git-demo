<?php

// Timezone Confirmation
date_default_timezone_set('NZ');

// DB Connection
function db_credentials() {
    if ($_SERVER['SERVER_NAME'] === "localhost") {
        $username = "root";
        $password = "";
        $hostname = "localhost";
    } else {
        $username = "bopt_user";
        $password = "Clientaccess=0";
        $hostname = "localhost";
    }
    //connection to the database
    $dbhandle = mysqli_connect($hostname, $username, $password) or die(mysqli_error($dbhandle));
    return $dbhandle;
}

function db_connect() {
    $dbhandle = db_credentials();
    //select a database to work with
    $selected = mysqli_select_db($dbhandle,"bopt_database") or die(mysqli_error($dbhandle)); 
    return $dbhandle;
}

// To Get Base Url
function api_baseurl() {
    if ($_SERVER['SERVER_NAME'] === "localhost") {
        $base = "http://localhost/websites/bop-trips-api/";
        return $base;
    } else {
        $base = "http://boptrips.com/api/";
        return $base;
    }
}

// To Get website_baseurl Url
function website_baseurl() {
    if ($_SERVER['SERVER_NAME'] === "localhost") {
        $base = "http://localhost/websites/bop-trips/";
        return $base;
    } else {
        $base = "http://boptrips.com/";
        return $base;
    }
}

// Encrypt and decrypt of urls
function encrypt_decrypt($action, $string) {
    $output = false;

    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';

    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}
?>