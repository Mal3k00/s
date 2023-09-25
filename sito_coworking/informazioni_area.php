<?php
session_start();

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se l'utente è autenticato
    if (!isset($_SESSION['id_utente'])) {
        echo "Utente non autenticato.";
        exit;
    }

    $idAreaCoworking = $_POST['idAreaCoworking'];
    $data = $_POST['data'];

    // Verifica se la data è nel formato corretto (YYYY-MM-DD)
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $data)) {
        echo "Formato data non valido.";
        exit;
    }

    // Verifica che la data sia una data valida
    list($anno, $mese, $giorno) = explode('-', $data);
    if (!checkdate($mese, $giorno, $anno)) {
        echo "Data non valida.";
        exit;
    }

    // Ottiengo l'id dell'utente dalla sessione
    $idUtente = $_SESSION['id_utente'];

    // Eseguo l'inserimento della prenotazione nel database utilizzando un prepared statement
    $query = "INSERT INTO prenotazioni (id_area_coworking, data, id_utente) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iss", $idAreaCoworking, $data, $idUtente);

    if ($stmt->execute()) {
        // Prenotazione effettuata con successo
        $conn->close();
        echo '<script>window.location.href = "area_personale.php";</script>';
        exit;
    } else {
        // Errore durante la prenotazione
        echo "Errore durante la prenotazione: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Verifica se è stato passato un parametro "id" nell'URL
    if (isset($_GET['id'])) {
        $idAreaCoworking = $_GET['id'];

        // Effettua una query per recuperare le informazioni dell'area di coworking specifica
        $query = "SELECT * FROM aree_coworking WHERE id_area_coworking = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $idAreaCoworking);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se l'area di coworking è stata trovata
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $nomeAzienda = $row['nome_azienda'];
            $indirizzo = $row['indirizzo'];
            $nomeAreaCoworking = $row['nome_area_coworking'];
            $descrizione = $row['descrizione'];
        } else {
            echo "Area di coworking non trovata.";
            exit;
        }
        $stmt->close();
    } else {
        echo "Parametro 'id' mancante nell'URL.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stile_informazioni_area.css">
    <title>Informazioni Area Coworking</title>
</head>
<body>
    <div class="container">
        <h2>Informazioni Area Coworking</h2>
        <ul>
            <li><strong>Nome Azienda:</strong> <?php echo $nomeAzienda; ?></li>
            <li><strong>Indirizzo:</strong> <?php echo $indirizzo; ?></li>
            <li><strong>Nome Area Coworking:</strong> <?php echo $nomeAreaCoworking; ?></li>
            <li><strong>Descrizione:</strong> <?php echo $descrizione; ?></li>
        </ul>

        <button id="prenotaButton">Prenota</button>
        <div id="prenotazioneForm" style="display: none;">
            <h3>Effettua una Prenotazione</h3>
            <form action="processa_prenotazione.php" method="post">
                <label for="data">Data:</label>
                <input type="date" name="data" required>
                <input type="hidden" name="idAreaCoworking" value="<?php echo $idAreaCoworking; ?>">
                <input type="submit" value="Conferma Prenotazione">
            </form>
        </div>



        <a href="area_personale.php">Torna all'Area Personale</a>
    </div>

    <script>
        document.getElementById('prenotaButton').addEventListener('click', function () {
            var prenotazioneForm = document.getElementById('prenotazioneForm');
            if (prenotazioneForm.style.display === 'none' || prenotazioneForm.style.display === '') {
                prenotazioneForm.style.display = 'block';
            } else {
                prenotazioneForm.style.display = 'none';
            }
        });
    </script>
</body>
</html>
