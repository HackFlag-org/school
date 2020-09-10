<?php

require('global.php');

 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["uid"]) && $_SESSION["uid"] != 0){
    echo "Al ingelogd: uid=".$_SESSION["uid"];
    header("location: welcome.php");
    exit;
}
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        $sql = 'SELECT uid, username, password, usertype FROM users WHERE username =\''.$username.'\'';
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
          // output data of each row
          while($row = $result->fetch_assoc()) {
             $encryptedpassword = $row["password"];
             $encrypted_entered_password = base64_encode($password);
             if($encrypted_entered_password == $encryptedpassword){
               echo "Login succesvol<br>";
               $_SESSION["uid"] = $row["uid"];
               $_SESSION["usertype"] = $row["usertype"];
               echo "rowuid: ".$row["uid"]." session uid: ".$_SESSION["uid"];
               header("location: welcome.php");
             }
             else{
               echo "Wachtwoord/username niet juist";
             }
          }
        }
        elseif($result->num_rows > 1){
          echo "Error: multiple results";
        
        } else {
          echo "0 results";
          echo $sql."<br>";
          trigger_error('Invalid query: ' . $conn->error);
        }
        mysqli_free_result($result);
        
    }
    
    // Close connection
    //mysqli_close($link);
}


generateHeader($_SESSION["uid"], "Inloggen"); ?>

		<!-- Main -->
			<section id="main">
				<div class="inner">
					<header class="major special">
							 <div class="wrapper">
              <h1>Inloggen</h1>
              <p>Vul hieronder je gebruikersnaam en wachtwoord in om in te loggen.</p>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                      <label>Username</label>
                      <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                      <span class="help-block"><?php echo $username_err; ?></span>
                  </div>    
                  <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                      <label>Password</label>
                      <input type="password" name="password" class="form-control">
                      <span class="help-block"><?php echo $password_err; ?></span>
                  </div>
                  <br>
                  <div class="form-group">
                      <input type="submit" class="btn btn-primary" value="Login">
                  </div>
                  
              </form>
          </div>    
							</p>

							<hr />

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>


<?php
generateFooter();
?>