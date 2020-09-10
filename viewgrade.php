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

createCourseList();
loginRedirect();

$aid = $_GET["aid"];
$usertype = $_SESSION["usertype"];
$uid = $_SESSION["uid"];
if(isset($_GET["uid"]) && ($usertype == 1 || $usertype == 2)){
  $uid = $_GET["uid"];
}

$grade = -1;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // collect value of input field
  $grade = $_POST['grade'];
  if (empty($grade)) {
    //do nothing
    echo "Empty";
  } else {
    updateGrade($aid, $uid, $grade);
  }
}

$details = getAssignmentDetails($aid, $uid);

generateHeader($_SESSION["usertype"], "Bekijk cijfer"); ?>

		<!-- Main -->
			<section id="main">
				<div class="inner">
					<header class="major special">
						<h1>Bekijk je cijfer</h1>
						<p>Hieronder zie je de gegevens van de opdracht en het door jouw behaalde cijfer.</p>
					</header>

					<!-- Text -->
						<section>
							<h3>Opdracht gegevens</h3>
							<p>
							<?php
							echo "<b>Vak:</b><br>".$courseNames[$details[0][1]]."<br><br>";
              echo "<b>Type opdracht:</b><br>".$assignment_titles[$details[0][2]]."<br><br>";
              echo "<b>Deadline:</b><br>".$details[0][4]."<br><br>";
              echo "<b>Uitleg opdracht:</b><br>".$details[0][3]."<br><br>";
              if($usertype == 1 || $usertype == 2){
                ?>
                <b>Cijfer:</b>
                <form method="post" action="viewgrade.php?aid=<?php echo $aid; ?>&uid=<?php echo $uid; ?>">
                <input type="text" id="grade" name="grade" value="<?php echo $details[0][5]; ?>"><br><br>
                <input type="submit" value="Cijfer aanpassen"> <a href="users.php" class="button alt">&lt;&lt; Terug naar gebruikers zoeken</a>
                </form>
                <?php
                
                
              }
              else{
                echo "<b>Cijfer:</b><br>".$details[0][5]."<br><br>";
                echo "<a href=\"viewgrades.php\" class=\"button\">&lt;&lt; Terug naar alle cijfers</a>";
              }
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