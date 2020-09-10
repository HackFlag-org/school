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

$results = [];
$sname = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $sname = $_POST['sname'];
  if (empty($sname)) {
    //do nothing
    echo "Yo";
  } else {
    $results = getUsers($sname);
  }
}


generateHeader($_SESSION["usertype"], "Users"); 

if($_SESSION["usertype"] != 1){
    accessDeniederror();
}
else {
?>

		<!-- Main -->
			<section id="main">
				<div class="inner">
					<header class="major special">
						<h1>Gebruikers</h1>
						<p>Zoek een gebruiker om deze aan te passen.</p>
					</header>

					<!-- Text -->
						<section>
							<p>
							<form method="post" action="users.php">
                  <label for="fname">Zoek op gebruikersnaam, voornaam of achternaam</label>
                  <input type="text" id="sname" name="sname" value="<?php echo $sname; ?>"><input type="submit" value="Zoeken">
              </form>
							</p>
							<h3>Resultaten</h3>
							<table>
							<th>Gebruikersnaam</th><th>Voornaam</th><th>Achternaam</th>
              <?php
                for($i = 0; $i < count($results); $i++){
                   echo "<tr><td><a href=edituser.php?uid=".$results[$i]['uid'].">".$results[$i]['username']."</a></td><td>".$results[$i]['firstname']."</td><td>".$results[$i]['lastname']."</td></tr>";
                }
              ?>
              </table>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/skel.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>


<?php
}

generateFooter();
?>