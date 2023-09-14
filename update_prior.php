
<?php
require_once('config.php');
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Kontrola připojení k databázi
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Získání dat z požadavku
$taskId = $_POST['taskId'];
$newValue = $_POST['newValue'];

// Aktualizace hodnoty prioritního sloupce v databázi
$sql = "UPDATE tasks SET priorita = '$newValue' WHERE id = $taskId";
if ($conn->query($sql) === TRUE) {
    echo "Hodnota byla úspěšně aktualizována.";
  } else {
    echo "Aktualizace selhala: " . $conn->error;
  }
$conn->close();
?>