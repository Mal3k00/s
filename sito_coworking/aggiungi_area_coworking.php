<?php
session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION['session_id'])) {
    header('Location: login.html'); // Reindirizza l'utente alla pagina di login se non è autenticato
    exit;
}

// Connessione al database 
$servername = "localhost:3307";
$username = "root";
$password = "root";
$dbname = "coworking_projeckt";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica degli errori di connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Gestire il modulo per l'aggiunta di un'area di coworking qui
if (isset($_POST['aggiungi_area'])) {
    // Recupera i dati inviati dal modulo
    $nomeAzienda = $_POST['nome_azienda'];
    $indirizzo = $_POST['indirizzo'];
    $nomeAreaCoworking = $_POST['nome_area_coworking'];
    $descrizione = $_POST['descrizione'];
    
    // Ottiengo l'ID dell'utente dalla sessione
    $idUtente = $_SESSION['session_id'];

    // Inserisci i dati nel database nella tabella 'aree_coworking'
    $stmt = $conn->prepare("INSERT INTO aree_coworking (id_utente, nome_azienda, indirizzo, nome_area_coworking, descrizione) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issss", $idUtente, $nomeAzienda, $indirizzo, $nomeAreaCoworking, $descrizione);
    
    if ($stmt->execute()) {
        // L'area di coworking è stata aggiunta con successo
        header('Location: area_personale.php');
        exit;
    } else {
        // Errore durante l'inserimento nel database
        echo "Errore durante l'inserimento dell'area di coworking: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<link rel="stylesheet" href="stile_aggiungi_area_coworking.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stile_aggiungi_area_coworking.css">

    <title>Aggiungi Area Coworking</title>
</head>
<body>

    <div class="container">
        <h2>Aggiungi Area Coworking</h2>
        <form id="aggiungiAreaForm" method="post">
            <div class="input-group">
                <label for="nome_azienda">Nome Azienda:</label>
                <input type="text" id="nome_azienda" name="nome_azienda" required>
            </div>
            <div class="input-group">
                <label for="indirizzo">Indirizzo:</label>
                <input type="text" id="indirizzo" name="indirizzo" required>
            </div>
            <div class="input-group">
                <label for="nome_area_coworking">Nome Area Coworking:</label>
                <input type="text" id="nome_area_coworking" name="nome_area_coworking" required>
            </div>
            <div class="input-group">
                <label for="descrizione">Descrizione:</label>
                <textarea id="descrizione" name="descrizione" rows="4" required></textarea>
            </div>

           
            <div class="input-group">
                <button type="submit" name="aggiungi_area">Aggiungi</button>
            </div>
        </form>

        <div class="button-container">
            <a href="area_personale.php" class="button">Torna all'Area Personale</a>
        </div>

    </div>
</body>
</html>


