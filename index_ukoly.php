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

      header("Location: index_úkoly.php");
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

  </body>
</html>