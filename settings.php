<?php

$host = "localhost";
$database = "school";
$dbuser = "root";
$dbpass = "";
$showQueries = False; //Hiermee kan je de query verklappen in errorberichten. 

// Create connection
$conn = new mysqli($host, $dbuser, $dbpass, $database);

// Check connection
if ($conn->connect_error) {
  echo "<hr>";
  echo "<div style='text-align: center;'>";
  echo "<h1><font color=\"red\">Error: kan niet verbinden met de database</font></h1><br>";
  echo "Zorg dat je de juiste gegevens hebt ingevoerd in settings.php.";
  echo "</div><br><br>";
  echo "Meer gedetailleerde error:<br>";
  die("Connection failed: " . $conn->connect_error);
}

$schoolname = "Super School";

?>