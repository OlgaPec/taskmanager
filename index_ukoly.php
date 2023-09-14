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


  </body>
</html>