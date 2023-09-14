<?php
require_once('config.php');
// Připojení k databázi
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($conn->connect_error) {
    die("Chyba připojení k databázi: " . $conn->connect_error);
}

// Získání dat z požadavku klienta
$newText = $_POST['newText'];
$taskId = $_POST['taskId'];
$column = $_POST['column']; // Nový parametr pro určení sloupce
// Aktualizace úkolu v databázi
$sql = "UPDATE tasks SET $column='$newText' WHERE ID=$taskId";
if ($conn->query($sql) === TRUE) {
    echo "Úkol byl úspěšně aktualizován";
} else {
    echo "Chyba při aktualizaci úkolu v souboru update: " . $conn->error;
}

$conn->close();
?>