<?php
require('global.php');


/*
$course_search_name = $_GET["course"];

$courses = getCourseListByName($course_search_name);
echo "Results are:<br>";
for($i = 0; $i < count($courses[1]); $i++){
  echo $courses[1][$i];
}
*/

createUsertypeList();
createCourseList();

loginRedirect();

$uid = $_GET["uid"];

$sname = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $fname = $_POST['firstname'];
  if (empty($fname)) {
    //do nothing
    echo "Empty";
  } else {
    $newuserdetails = $_POST;
    updateUser($uid, $newuserdetails);
  }
}

$details = getUserDetails($uid);
$userdetails = $details[0];



generateHeader($_SESSION["usertype"], "Gebruiker aanpassen"); ?>

		<!-- Main -->
			<section id="main">
				<div class="inner">
					<header class="major special">
						<h1>Gebruiker aanpassen</h1>
						<p>Vul hieronder de nieuwe gegevens in en klik op "Wijzigingen opslaan".</p>
					</header>

					<!-- Text -->
						<section>
							<h3>Gegevens van de gebruiker</h3>
							<p>
							<form method="post" action="edituser.php?uid=<?php echo $uid; ?>">
                  <table>
                  <th>Gegevens</th><th>Waarde</th>
                  <tr><td>Gebruikersnaam</td><td><input type="text" id="username" name="username" value="<?php echo $userdetails['username']; ?>"></td></tr>
                  <tr><td>E-mailadres</td><td><input type="text" id="emailaddress" name="emailaddress" value="<?php echo $userdetails['emailaddress']; ?>"></td></tr>
                  <tr><td>Type account</td>
                  
                  <td>
                  <select id="usertype" name="usertype">
                  <?php
                  for($i = 0; $i < count($usertypes); $i++){
                    $selected = "";
                    if($userdetails['usertype'] == $i){
                      $selected = " selected";
                    }
                    echo "<option value=\"$i\"$selected>".$usertypes[$i]."</option>";
                  }
                  ?>
                  </select>
                  </td></tr>
                  
                  
                  <tr><td>Voornaam</td><td><input type="text" id="firstname" name="firstname" value="<?php echo $userdetails['firstname']; ?>"></td></tr>
                  <tr><td>Achternaam</td><td><input type="text" id="lastname" name="lastname" value="<?php echo $userdetails['lastname']; ?>"></td></tr>
                  
                  <?php
                    $classlabel = "Klas";
                    $classvalue = $userdetails['class'];
                    if($userdetails['usertype'] == 1 || $userdetails['usertype'] == 2){
                      $classlabel = "Vak";
                      ?>
                      <tr><td><?php echo $classlabel; ?></td><td>
                      <select id="class" name="class">
                      <?php
                      for($i = 0; $i < count($courseNames); $i++){
                        $selected = "";
                        if($classvalue == $i){
                          $selected = " selected";
                        }
                        echo "<option value=\"$i\"$selected>".$courseNames[$i]."</option>";
                      }
                      ?>
                      </select>
                      </td></tr>
                      <?php
                    }
                    else {
                        ?>
                        <tr><td><?php echo $classlabel; ?></td><td>
                        <select id="class" name="class">
                        <?php
                        for($i = 1; $i < 7; $i++){
                          $selected = "";
                          if($classvalue == $i || ($classvalue > 6 && $i == 6)){
                            $selected = " selected";
                          }
                          echo "<option value=\"$i\"$selected>Klas $i</option>";
                        }
                        ?>
                        </select>
                        </td></tr>
                        <?php
                     
                    }
                  ?>
                  
                  
                  <tr><td>Geslacht</td><td><input type="text" id="gender" name="gender" value="<?php echo $userdetails['gender']; ?>"></td></tr>
                  <tr><td>Geboortedatum</td><td><input type="text" id="birthday" name="birthday" value="<?php echo $userdetails['birthday']; ?>"></td></tr>
                  <tr><td>Straat + huisnummer</td><td><input type="text" id="streetaddress" name="streetaddress" value="<?php echo $userdetails['streetaddress']; ?>"></td></tr>
                  <tr><td>Postcode</td><td><input type="text" id="zipcode" name="zipcode" value="<?php echo $userdetails['zipcode']; ?>"></td></tr>
                  <tr><td>Plaats</td><td><input type="text" id="city" name="city" value="<?php echo $userdetails['city']; ?>"></td></tr>
                  </table>
                  <input type="submit" value="Wijzigingen opslaan"> <a href="users.php" class="button alt">&lt;&lt; Terug naar gebruikers zoeken</a>
							</form>
							</p>

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