<?php
session_start();

// Distruggi la sessione corrente
session_destroy();

// Reindirizza l'utente alla pagina di login
header('Location: login.php');
exit;
?>
