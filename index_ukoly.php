<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Správa úkolů</title>
  
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
</head>
<body>

<h1>Správa úkolů</h1>
 
  <form action="logout.php" method="post">
      <button type="submit">Odhlásit se</button>
  </form>
  <form class="tasks-container" action="" method="POST">
    <input type="text" id="task-input" name="task-input" placeholder="Zadejte úkol ...">
    <input type="text" id="task-input" name="task-podrobnosti" placeholder="Zadejte podrobnosti ...">
    <input type="date" id="task-input-pul" name="task-termin">
    <select id="task-input-pul" name="task-priorita">
      <option value="" disabled selected>Priorita...</option>
      <option value="Nízká">Nízká</option>
      <option value="Střední">Střední</option>
      <option value="Vysoká">Vysoká</option>
    </select>
    <button type="submit">Přidat&nbsp;úkol</button>
  </form>

  <?php
   require_once('config.php');
  session_start();
  // Zpracování formuláře po odeslání
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["task-input"])) {
    // Získání zadaného úkolu z formuláře
    $task = $_POST["task-input"];
    $taskpodr = $_POST["task-podrobnosti"];
    $taskterm = $_POST["task-termin"];
    $taskprior = $_POST["task-priorita"];
  
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
  }
    // Připojení k MySQL databázi
    $conn =  mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Kontrola připojení
    if (!$conn) {
      die("Připojení k databázi selhalo: " . mysqli_connect_error());
    }
    if (!empty($username)) {

      header("Location: index_ukoly.php");
  } 
    // Příprava dotazu pro vložení úkolu do tabulky
    $sql = "INSERT INTO tasks (username, task_name, podrobnosti, termin, priorita) VALUES ('$username', '$task', '$taskpodr','$taskterm', '$taskprior')";

    // Spuštění dotazu
    if (mysqli_query($conn, $sql)) {
      
    } else {
      echo '<script>
      alert("Chyba při ukládání úkolu.");
      window.history.back();
      </script>';
    }

    // Uzavření spojení s databází
    mysqli_close($conn);
  }
  ?>

<h2>Seznam úkolů:</h2>
  <?php
   require_once('config.php');
  // Připojení k MySQL databázi
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Kontrola připojení
  if (!$conn) {
    die("Připojení k databázi selhalo: " . mysqli_connect_error());
  }
  
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
  }

  // Dotaz pro získání úkolů z tabulky
  $sql = "SELECT * FROM tasks WHERE username='$username' ORDER BY termin, priorita DESC";

  // Spuštění dotazu
  $result = mysqli_query($conn, $sql);

  // Kontrola, zda jsou k dispozici úkoly
  if (mysqli_num_rows($result) > 0) {
   // Výpis úkolů jako tabulka

   echo "<table class='responsive-table'>";
echo "<tr><th class='hidden-column'>ID</th><th>Úkol</th><th>Podrobnosti</th><th>Termín</th><th>Priorita</th><th>Akce</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo '<td class="hidden-column" name="task_id">' . $row['id'] . '</td>';
  echo '<td class="editable-cell" name="task_name" onclick="editText(this)">' . $row['task_name'] . '          <img class="tuzka" src="tuzka.png" alt="Editovat"></td>';
  echo '<td class="editable-cell" name="podrobnosti" onclick="editText(this)">' . $row['podrobnosti'] . '          <img class="tuzka" src="tuzka.png" alt="Editovat"></td>'; // Nový sloupec
  echo '<td class="editable-cell" name="termin" onclick="editText(this)">' . $row['termin'] . '          <img class="tuzka" src="tuzka.png" alt="Editovat"></td>';

 echo '<td class="editable-cell" name="priorita" onclick="editCell(' . $row['id'] . ', this)">' . $row['priorita'] . '          <img class="tuzka" src="tuzka.png" alt="Editovat"></td>';

 echo "<td><button class='tab_button' type='button' data-task-id='" . $row["id"] . "' onclick='deleteTask(" . $row["id"] . ")'>Smazat</button></td>";
  echo "</tr>";
}
echo "</table>";

  } else {
    echo "Žádné úkoly k zobrazení.";
  }

  // Uzavření spojení s databází
  mysqli_close($conn);
  ?>



  </body>
</html>