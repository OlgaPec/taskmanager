<?php
 require_once('config.php');
  // Zpracování formuláře po odeslání
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["username"]) && isset($_POST["password"]) ) {
    // Získání zadaného úkolu z formuláře
    $us = $_POST["username"];
    $pa = $_POST["password"];

    // Připojení k MySQL databázi
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Kontrola připojení
    if (!$conn) {
      die("Připojení k databázi selhalo: " . mysqli_connect_error());
    }

// Dotaz na ověření existence uživatele
$sql = "SELECT * FROM users WHERE username = '$us'";

// Vykonání dotazu
$result = mysqli_query($conn, $sql);

// Kontrola, zda došlo k nějakému výsledku (zda uživatel existuje)
if (mysqli_num_rows($result) > 0) {
  echo '<script>
  alert("Uživatel s tímto jménem již existuje.");
  window.history.back();
  </script>';
} else {  
     // Zahashování hesla
     $hashedPassword = password_hash($pa, PASSWORD_DEFAULT);

    // Příprava dotazu pro vložení úkolu do tabulky
    $sql2 = "INSERT INTO users (username, pass) VALUES ('$us', '$hashedPassword')";
    
   // Zde zpracujeme výsledek ověření a výpis do vyskakovacího okna
        if (mysqli_query($conn, $sql2)) {
            // Registrace proběhla úspěšně, takže pošleme e-mail
            echo '<script>
                alert("Registrace proběhla úspěšně.");
                window.history.back();
                </script>';
            } else {
 
              echo '<script>
              alert("Chybné uživatelské jméno nebo heslo.");
              window.history.back();
              </script>';
}
}
    // Uzavření spojení s databází
    mysqli_close($conn);
  }
  ?>