<?php
require_once('config.php');
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["delete-task"])) {
  // Získání ID úkolu k odstranění
  $taskId = $_POST["delete-task"];

  // Připojení k MySQL databázi
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Kontrola připojení
  if (!$conn) {
    die("Připojení k databázi selhalo: " . mysqli_connect_error());
  }

  // Příprava dotazu pro odstranění úkolu z tabulky
  $sql = "DELETE FROM tasks WHERE id = $taskId";

  // Spuštění dotazu
  if (mysqli_query($conn, $sql)) {
    echo json_encode(array("success" => true, "message" => "Úkol byl úspěšně odstraněn."));
  } else {
    echo json_encode(array("success" => false, "message" => "Chyba při odstraňování úkolu: " . mysqli_error($conn)));
  }

  // Uzavření spojení s databází
  mysqli_close($conn);
}
?>