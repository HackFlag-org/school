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

loginRedirect();

$uid = $_SESSION["uid"];
$usertype = $_SESSION["usertype"];
$details = getUserDetails($uid);
$userdetails = $details[0];


$numbername = "Leerlingnummer";
if ($usertype != 3 && $usertype != 0){
    $numbername = "Personeelsnummer:";
}

generateHeader($_SESSION["usertype"], "Mijn gegevens"); ?>

		<!-- Main -->
			<section id="main">
				<div class="inner">
					<header class="major special">
						<h1>Welkom</h1>
						<p>Je bent succesvol ingelogd. Hieronder zie je je gegevens.</p>
					</header>

					<!-- Text -->
						<section>
							<h3>Mijn gegevens</h3>
							<p>
							<?php
							echo "
                  <table>
                  <th>Gegevens</th><th>Waarde</th>
                  <tr><td>$numbername</td><td>".$userdetails['uid']."</td></tr>
                  <tr><td>Gebruikersnaam</td><td>".$userdetails['username']."</td></tr>
                  <tr><td>E-mailadres</td><td>".$userdetails['emailaddress']."</td></tr>
                  <tr><td>Type account</td><td>".$usertypes[$userdetails['usertype']]."</td></tr>
                  <tr><td>Voornaam</td><td>".$userdetails['firstname']."</td></tr>
                  <tr><td>Achternaam</td><td>".$userdetails['lastname']."</td></tr>
                  <tr><td>Klas:</td><td>".$userdetails['class']."</td></tr>
                  <tr><td>Geslacht</td><td>".$userdetails['gender']."</td></tr>
                  <tr><td>Geboortedatum</td><td>".$userdetails['birthday']."</td></tr>
                  <tr><td>Huisadres</td><td>".$userdetails['streetaddress']."<br>".$userdetails['zipcode']." ".$userdetails['city']."</td></tr>
                  </table>";
							
							?>
							
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