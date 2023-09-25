<?php
session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION['session_id'])) {
    header('Location: login.html'); // Reindirizza l'utente alla pagina di login se non è autenticato
    exit;
}

// Connessione al database (se necessario)
$servername = "localhost:3307";
$username = "root";
$password = "root";
$dbname = "coworking_projeckt";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica degli errori di connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Ottiengo l'ID dell'utente dalla sessione
$idUtente = $_SESSION['session_id'];

// Effettua una query per recuperare le aree di coworking personali dell'utente
$query = "SELECT * FROM aree_coworking WHERE id_utente = $idUtente";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stile_aree_personali.css">
    <title>Aree di Coworking Personali</title>
</head>
<body>
    <div class="container">
        <h2>Aree di Coworking Personali</h2>

        <?php
        // Verifica se sono presenti aree di coworking personali
        if ($result->num_rows > 0) {
            echo "<ul>";
            
            while ($row = $result->fetch_assoc()) {
                echo "<li>";
                echo "<strong>Nome Area Coworking:</strong> " . $row['nome_area_coworking'] . "<br>";
                echo "<strong>Nome Azienda:</strong> " . $row['nome_azienda'] . "<br>";
                echo "<strong>Indirizzo:</strong> " . $row['indirizzo'] . "<br>";
                echo "<strong>Descrizione:</strong> " . $row['descrizione'] . "<br>";

                // Aggiungi una query per recuperare le prenotazioni relative a questa area
                $areaId = $row['id_area_coworking'];
                $prenotazioniQuery = "SELECT p.id_utente, p.data, u.nome, u.cognome, u.email 
                                    FROM prenotazioni p
                                    INNER JOIN utenti u ON p.id_utente = u.id_utente
                                    WHERE p.id_area_coworking = $areaId";
                $prenotazioniResult = $conn->query($prenotazioniQuery);

                echo "<strong>Prenotazioni:</strong><br>";
                if ($prenotazioniResult->num_rows > 0) {
                    echo "<ul>";
                    while ($prenotazioneRow = $prenotazioniResult->fetch_assoc()) {
                        echo "<li>ID Utente: " . $prenotazioneRow['id_utente'] . "<br>";
                        echo "Nome: " . $prenotazioneRow['nome'] . "<br>";
                        echo "Cognome: " . $prenotazioneRow['cognome'] . "<br>";
                        echo "Email: " . $prenotazioneRow['email'] . "<br>";
                        echo "Data: " . $prenotazioneRow['data'] . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "Nessuna prenotazione per questa area.";
                }

                echo "</li>";
            }
            
            echo "</ul>";
        } else {
            echo "<p>Nessuna area di coworking personale disponibile.</p>";
        }
        ?>

        <!-- Torna alla pagina dell'area personale -->
        
        <!-- Torna all'Area Personale -->
<a href="area_personale.php" class="button">Torna all'Area Personale</a>

    </div>
</body>
</html>
