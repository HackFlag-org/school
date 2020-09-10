<?php

require('settings.php');
//ini_set('session.auto_start', 1);
//ini_set('session.use_cookies', 1);
$courseNames = [];
$usertypes = [];
$assignment_titles = ["SO", "Opdracht", "Mondeling", "Proefwerk"];
$assignment_colors = ["#defeff", "#dee8ff", "#f3deff", "#ffedde"];

function printSQLerror($query, $error){
  if($showQueries){
    echo "Query: ".$query."<br>";
  }
  trigger_error("Error: ".$error."<br>");
}

function getData($query){
  $data = "hooi";
  return $data;
}

function getGradesFromUser($userid, $class=0, $course=0){
  /*
  - if $class==0: $class=   userid > class
  - select assignments where class = $class       [AND course = $course indien $course != 0]
  - select grades where assignments IN [query hierboven] AND user=userid
  */
}

function getGradesFromCourse($class){
  /*
  Get the course the Teacher teaches:
  - $course = userid > class
  - select assignments where class = $class and course = $course
  - select grades where assignments IN [query hierboven]
  */
}

function getCourseListByName($name){
  global $conn;
  $sql = "SELECT * FROM courses WHERE name LIKE '%$name%'";
  $result = $conn->query($sql);
  $course_ids = [];
  $course_names = [];

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      //echo "id: " . $row["id"]."<br>";
      $course_ids[] = $row["id"];
      $course_names[] = $row["name"];
    }
  } else {
    echo "0 results";
    printSQLerror($sql, $conn->error);
  }
  mysqli_free_result($result);
  if(count($course_ids) != count($course_names)){
    echo "WARNING: course id and course name arrays have different sizes.";
  }
  $course_info = [$course_ids, $course_names];
  return $course_info;
}

function createCourseList(){
  global $courseNames;
  $courseNames[] = "Invalid";
  global $conn;
  $sql = "SELECT id, name FROM courses ORDER BY id";
  $result = $conn->query($sql);
  

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      //echo "id: " . $row["id"]."<br>";
      $courseNames[] = $row["name"];
    }
  } else {
    echo "0 results";
    echo $query."<br>";
    trigger_error('Invalid query: ' . $conn->error);
  }
  mysqli_free_result($result);
}

function createUsertypeList(){
  global $usertypes;
  global $conn;
  $sql = "SELECT id, description FROM usertypes ORDER BY id";
  $result = $conn->query($sql);
  

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      //echo "id: " . $row["id"]."<br>";
      $usertypes[] = $row["description"];
    }
  } else {
    echo "0 results";
    printSQLerror($sql, $conn->error);
  }
  mysqli_free_result($result);
}

function getGradesPerCourse($uid){   
  global $conn;
  $rowdetails = [];
  $rows = [];
  $sql = "SELECT course, title, grade, aid FROM grades P INNER JOIN assignments C ON P.aid = C.id WHERE `uid` = $uid ORDER BY course";
  $result = $conn->query($sql);
  

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      //echo "id: " . $row["id"]."<br>";
      $rowdetails[0] = $row["course"];
      $rowdetails[1] = $row["title"];
      $rowdetails[2] = $row["grade"];
      $rowdetails[3] = $row["aid"];
      $rows[] = $rowdetails;
    }
  } else {
    echo "0 results";
    printSQLerror($sql, $conn->error);
  }
  mysqli_free_result($result);
  return $rows;
}

function getAssignmentDetails($aid, $uid){
  global $conn;
  $rowdetails = [];
  $rows = [];
  //$sql = "SELECT * FROM `assignments` WHERE `id` = $aid";
  $sql = "SELECT `id`, `course`, `title`, `assignment_text`, `deadline`, `grade` FROM grades, assignments WHERE `uid`=$uid AND grades.aid = assignments.id AND assignments.id=$aid";
  $result = $conn->query($sql);
  

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      //echo "id: " . $row["id"]."<br>";
      $rowdetails[0] = $row["id"];
      $rowdetails[1] = $row["course"];
      $rowdetails[2] = $row["title"];
      $rowdetails[3] = $row["assignment_text"];
      $rowdetails[4] = $row["deadline"];
      $rowdetails[5] = $row["grade"];
      $rows[] = $rowdetails;
    }
  } else {
    echo "0 results";
    printSQLerror($sql, $conn->error);
  }
  mysqli_free_result($result);
  return $rows;

}

function getUserDetails($uid){
  global $conn;
  $rowdetails = [];
  $rows = [];
  $sql = "SELECT * FROM `users` WHERE `uid` = $uid";
  $result = $conn->query($sql);
  

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      //echo "id: " . $row["id"]."<br>";
      $rows[] = $row;
    }
  } else {
    echo "0 results";
    printSQLerror($sql, $conn->error);
  }
  mysqli_free_result($result);
  return $rows;

}

function getUsers($searchterm){
global $conn;
  $rowdetails = [];
  $rows = [];
  $sql = "SELECT * FROM `users` WHERE `username` LIKE '%$searchterm%' OR `firstname` LIKE '%$searchterm%' OR `lastname` LIKE '%$searchterm%'";
  $result = $conn->query($sql);
  

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $rows[] = $row;
    }
  } else {
    echo "0 results";
    printSQLerror($sql, $conn->error);
  }
  mysqli_free_result($result);
  return $rows;

}

function updateUser($uid, $details){
  global $conn;
  $sql = "UPDATE users SET 
  username='".$details['username']."',
  firstname='".$details['firstname']."',
  lastname='".$details['lastname']."',
  usertype='".$details['usertype']."',
  emailaddress='".$details['emailaddress']."',
  class='".$details['class']."',
  gender='".$details['gender']."',
  streetaddress='".$details['streetaddress']."',
  zipcode='".$details['zipcode']."',
  city='".$details['city']."' 
  WHERE uid=$uid";

  if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conn->error;
  }

}

function updateGrade($aid, $uid, $newgrade){
  global $conn;
  $sql = "UPDATE grades SET grade=$newgrade WHERE aid=$aid AND uid=$uid";

  if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conn->error;
  }

}



function generateHeader($usertype=0, $pagename=""){
  global $schoolname;
  echo '
  <html>
	<head>
		<title>'.$schoolname.' - '.$pagename.'</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body>
  
  <!-- Header -->
			<header id="header">
				<div class="inner">
					<a href="index.php" class="logo">'.$schoolname.'</a>
					<nav id="nav">';
  
  switch($usertype){
    case 0:
      echo '<a href="index.php">Home</a> <a href="logout.php">Uitloggen</a>';
      break;
    case 1:
      echo '<a href="welcome.php">Home</a> <a href="users.php">Users</a> <a href="assignments.php">Opdrachten</a> <a href="logout.php">Uitloggen</a>';
      break;
    case 2:
      echo '<a href="welcome.php">Home</a> <a href="assignments.php">Opdrachten</a> <a href="logout.php">Uitloggen</a>';
      break;
    case 3:
      echo '<a href="welcome.php">Home</a> <a href="viewgrades.php">Mijn cijfers</a> <a href="logout.php">Uitloggen</a>';
      break;
    case 5:
      echo '<a href="index.php">Home</a> <a href="login.php">Inloggen</a>';
      break;
  }

  
  echo '  
					</nav>
				</div>
			</header>
			<a href="#menu" class="navPanelToggle"><span class="fa fa-bars"></span></a>
	';
  
  
}

function generateFooter(){
  $currentyear = date("Y");
  echo '<i>Website van een fictieve school</i> | &copy; '.$currentyear.' <a href="https://hackflag.org">HackFlag.org</a>';
}

function generateLegenda(){
  global $assignment_titles;
  global $assignment_colors;
  echo "<b>Legenda</b><br>";
  for($i = 0; $i < count($assignment_titles); $i++){
    echo "<div style=\"background-color: ".$assignment_colors[$i]."; width: 100px;\">".$assignment_titles[$i]."</div>";
  }
}

function loginRedirect(){
  if(!isset($_SESSION["uid"]) || $_SESSION["uid"] == 0){
    header("location: index.php");
    exit;
  }
}

function guestSession(){
  global $_SESSION;
  $_SESSION["uid"] = 0;
  $_SESSION["usertype"] = 5;
}


function accessDeniederror(){
  echo '<!-- Main -->
			<section id="main">
				<div class="inner">
					<header class="major special">
						<h1>Toegang geweigerd</h1>
						<p>Je hebt geen toegang tot deze pagina.</p>
					</header>';
}


//echo "status: ".session_status();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    guestSession();
}
if (session_status() == PHP_SESSION_ACTIVE && !isset($_SESSION["uid"])){
    guestSession();
}
//generateHeader($_SESSION["uid"]);

?>