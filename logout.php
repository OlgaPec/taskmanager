<?php
// Zahájení relace
session_start();

// Odstranění uživatele z relace (odhlášení)
unset($_SESSION['username']);

// Přesměrování na úvodní stránku
header("Location: index.php");
exit(); // Důležité pro ukončení dalšího zpracování skriptu po přesměrování
?>