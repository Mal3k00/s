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

// Ottengo il nome dell'utente dalla sessione
$nomeUtente = $_SESSION['session_user']; // Utilizzo 'session_user' come chiave
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="stile_area_personale.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area Personale</title>
</head>
<body>
    <div class="container">
        <h2>Benvenuto, <?php echo $nomeUtente; ?>!</h2>

        <!--  link per effettuare il logout -->
        <a href="logout.php">Esci</a>

        <!--  link per aggiungere un'area di coworking -->
        <a href="aggiungi_area_coworking.php">Aggiungi Area Coworking</a>
        
        <!-- link per visualizzare le tue aree personali -->
        <a href="aree_personali.php">Le tue aree personali</a>

        <!-- Visualizza gli spazi di coworking disponibili -->
        <?php
        //  query per recuperare tutti gli spazi di coworking
        $query = "SELECT * FROM aree_coworking";
        $result = $conn->query($query);

        // Verifica se sono presenti spazi di coworking
        if ($result->num_rows > 0) {
            echo "<h3>Spazi di Coworking Disponibili:</h3>";
            echo "<ul>";

            while ($row = $result->fetch_assoc()) {
                echo "<li>";
                echo "<a href='informazioni_area.php?id=" . $row['id_area_coworking'] . "'>" . $row['nome_area_coworking'] . "</a>";
                echo "</li>";
            }

            echo "</ul>";
        } else {
            echo "<p>Nessuno spazio di coworking disponibile.</p>";
        }
        ?>
        
    </div>
    <script src="stile_area_personale.js"></script>
</body>
</html>
