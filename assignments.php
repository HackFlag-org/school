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

generateHeader($_SESSION["usertype"], "Users"); 

if($_SESSION["usertype"] != 1 && $_SESSION["usertype"] != 2){
    accessDeniederror();
}
else {
?>

		<!-- Main -->
			<section id="main">
				<div class="inner">
					<header class="major special">
						<h1>Opdrachten</h1>
						<p>Hier kan een docent cijfers geven en opdrachten aanmaken en aanpassen.</p>
					</header>

					<!-- Text -->
						<section>
							<p>
							<h3>Deze pagina is nog niet af</h3>

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