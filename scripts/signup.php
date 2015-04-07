<?php
ob_start();
session_start();

//include 'connection.php';

require_once('connection.php');
require_once('Input_sanitisation.php');


if (!$dbh)  {
    echo "An error occurred connecting to the database"; 
    exit; 
  }
?>


<!DOCTYPE HTML> 
<html>

<head>
    <title> Social News Platform</title>
<style>
.error {color: #FF0000;}
</style>
</head>
    
    <link type="text/css" rel="stylesheet" href="../stylesheets/main.css">
    <div id="header">
<h1> Social News Platform </h1>
</div>
<body> 

<?php
$emailErr = $usernameErr = $passwordErr = "";
$email = $username = $password = "";

$email=$_POST['email'];
$username=$_POST['username'];
$password=$_POST['password'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    
    //check for empty fields
    if(empty($email) || empty($username)|| empty($password)) {
        if (empty($email)){
	       $emailErr = "Email address is required!";
        }
        else{
            $email = sanitiseInput($email);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format!"; 
            }
            
            $stid = oci_parse($dbh, "SELECT * FROM REGISTERED_USER where email='$email'");
            oci_execute($stid);

            $row=oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC);
            if($row > 0){
                $duplicatedEmailErr = "This email address is taken!";   
            }
        }
                   
        if (empty($username)){
	       $usernameErr = "Username is required!";
	   }
        else{
            $username = sanitiseInput($username);
            $stid = oci_parse($dbh, "SELECT * FROM REGISTERED_USER where username='$username'");
            oci_execute($stid);

            $row=oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC);
            if($row > 0){
                $duplicatedUsernameErr = "This username is taken!";   
            }
        }
    
        if (empty($password)){
	       $passwordErr = "Password is required!";
	   }
        else
            $password = sanitiseInput($password);    
            
    }   
     
    else{ 
        
        $valid_email = 0;
        $valid_username = 0;
        
        $email = sanitiseInput($email);
            // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format!"; 
        }
            
        $stid = oci_parse($dbh, "SELECT * FROM REGISTERED_USER where email='$email'");
        oci_execute($stid);

        $row=oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC);
        if($row > 0){
            $duplicatedEmailErr = "This email address is taken!";   
        }
        else{
            $valid_email = 1;   
        }
        
    
        $username = sanitiseInput($username);
        $stid = oci_parse($dbh, "SELECT * FROM REGISTERED_USER where username='$username'");
        oci_execute($stid);

        $row=oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC);
        if($row > 0){
            $duplicatedUsernameErr = "This username is taken!";   
        }
        else{
            $valid_username = 1;    
        }
        
    
        $password = sanitiseInput($password); 
        
        if($valid_email ==1 && $valid_username == 1){
            $sql = "INSERT INTO REGISTERED_USER(email, userPassword,    username)VALUES('$email','$password', '$username')";
            $stid = oci_parse($dbh, $sql);
            $response = oci_execute($stid); 
             exit(header("Location: http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/templates/HomePage.php"));
        }
        else{
             //$_SESSION['message'] = "please try again!";
            header("Refresh: 3; url=\" http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/signup.php");
            //header("Location: http://cs2102-i.comp.nus.edu.sg/~a0101856/cs2102/scripts/signup.php");
        
        }
        
        oci_free_statement($stid);
        ob_flush();
     }
}  
?> 
    	
 
<div style="text-align: center;">
<h2>Register Account</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Email Address: <input type="text" name="email" value="<?php echo $email;?>">
   <span class="error">* <?php echo $emailErr;?><?php echo $duplicatedEmailErr;?></span>
   <br><br>
   Username: <input type="text" name="username" value="<?php echo $username;?>">
   <span class="error">* <?php echo $usernameErr;?><?php echo $duplicatedUsernameErr;?></span>
   <br><br>
   Password: <input type="password" name="password" value="<?php echo $password;?>">
   <span class="error">* <?php echo $passwordErr;?></span>
   <br><br>
   <input type="submit" name="submit" value="Submit"> 
</form>
</div>


    </body>
</html>

