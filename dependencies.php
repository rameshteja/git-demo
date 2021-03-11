<?php
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	//include php mailer files.
	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	// check unique data function
	function check_unique($table,$field,$data){
		$dbhandle = db_connect();
		$sql = "select ".$field." from ".$table." where ".$field."='$data'";
		$check_data = mysqli_query($dbhandle,$sql);
		if(mysqli_num_rows($check_data)>0){
			//true found
			return true;
		}else{
			//not found
			return false;
		}
	}

	// check unique for update
    function check_unique_update($table,$check,$data,$row_field,$row_id){
		$dbhandle = db_connect();
        $sql = "SELECT ".$check." FROM ".$table." WHERE ".$check."='$data' AND ".$row_field."!='$row_id'";
        $check_data = mysqli_query($dbhandle,$sql);
        if(mysqli_num_rows($check_data)>0){
            //true found
            return true;
        }else{
            //not found
            return false;
        }
	}
	
	// to send email
	function sendEmail($to,$subject,$body,$fromEmail,$fromName){
		//Load Composer's autoloader
		require 'php_mailer/autoload.php';

		// php mailer prerequisite
		$send_email     =   "bluplateau.clients@gmail.com";
		$send_password  =    "B_p2587528";

		if($fromEmail == ''){
			$fromEmail = 'info@boptrips.com';
		}

		if($fromName == ''){
			$fromName = 'Bop Trips';
		}

		$message = "
			<html>
				<head>
				</head>
				<body>
					".$body."
				</body>
			</html>
		";
		
		$mail = new PHPMailer;

		$mail->SMTPDebug = 0;   // Enable verbose debug output

		$mail->isSMTP();    // Set mailer to use SMTP
		$mail->Host         = 'smtp.gmail.com'; // Specify main and backup SMTP servers
		$mail->SMTPAuth     = true; // Enable SMTP authentication
		$mail->Username     = $send_email;  // SMTP username
		$mail->Password     = $send_password;   // SMTP password
		$mail->SMTPSecure   = 'tls';  // Enable TLS encryption, `ssl` also accepted
		$mail->Port         = 587;  // TCP port to connect to
		$mail->SMTPOptions  = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		$mail->setFrom($fromEmail, $fromName);
		$mail->addReplyTo($fromEmail, $fromName);
		$mail->addAddress($to); // Add a recipient sample@website.com
		$mail->isHTML(true);    // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $message;

		if(!$mail->send()) {
			$result['status']   =   false;
			$result['message']  =   "Failed to Send Email!";
			$result['error']    =   $mail->ErrorInfo;
		} else {
			$result['status']   =   true;
			$result['message']  =   "Mail Sent Successfull!";
			$result['error']    =   0;
		}
		return $result;
	}
?>