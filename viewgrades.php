<?php
require('global.php');

createCourseList();
loginRedirect();

$uid = $_SESSION["uid"];


generateHeader($_SESSION["usertype"], "Mijn cijfers"); ?>

		<!-- Main -->
			<section id="main">
				<div class="inner">
					<header class="major special">
						<h1>Mijn cijfers</h1>
						<p>Dit zijn de cijfers die je hebt behaald.</p>
					</header>

					<!-- Text -->
						<section>
							<p><?php
							
							generateLegenda();
              $grades = getGradesPerCourse($uid);
              $currentcourse = 0;
              echo "<br><br>";

              echo "<table>";
              echo "<th>Vak</th><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th>";

              for($i = 0; $i < count($grades); $i++){
                 $course = $grades[$i][0];
                 $title = $grades[$i][1];
                 $grade = $grades[$i][2];
                 $aid = $grades[$i][3];
                 
                 /*
                 if($course > $currentcourse){
                   if($currentcourse > 0){
                      echo "</table>";
                   }
                   echo "<h1>".$courseNames[$course]."</h1>";
                   $currentcourse = $course;
                   echo "<table>";
                 }
                 echo "<tr><td>".$title."</td><td><a href=\"viewgrade.php?aid=$aid\">".$grade."</a></td></tr>";
                 */
                 
                 if($course > $currentcourse){
                   if($currentcourse > 0){
                      echo "</tr>";
                   }
                   echo "<tr><td>$courseNames[$course]</td>";
                   $currentcourse = $course;
                 }
                 if($grade < 6){
                   $gradecolor = "red";
                   $divgrade = '<div class="insufficient">';
                 }
                 else{
                   $gradecolor = "green";
                   $divgrade = '<div class="sufficient">';
                 }
                 
                 echo "<td style=\"background-color: ".$assignment_colors[$title].";\">$divgrade<a href=\"viewgrade.php?aid=$aid\">$grade</a></div></td>";
                 //echo "<td><b>$grade</b><br>".$assignment_titles[$title]."</td>";
              }
              echo "</table>"; ?>

							
							
							
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