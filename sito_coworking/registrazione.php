<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connessione al database
    $servername = "localhost:3307";
    $username = "root";
    $password = "root";
    $dbname = "coworking_projeckt";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connessione al database fallita: " . $conn->connect_error);
    }

    // Recupera i dati dal modulo di registrazione
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // query SQL per l'inserimento dell'utente nel database
    $stmt = $conn->prepare("INSERT INTO utenti (nome, cognome, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $cognome, $email, $password);

    if ($stmt->execute()) {
        // L'utente è stato registrato con successo
        //reindirizzare l'utente alla pagina di login o eseguire altre azioni qui
        header('Location: login.php');
        exit;
    } else {
        // Errore durante la registrazione dell'utente nel database
        echo "Errore durante la registrazione: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione Utente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 400px;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Stile per il tasto "Registrati" e "Accedi" */
        .btn {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registrazione Utente</h2>
        <form id="registrazioneForm" action="" method="post">
            <div class="input-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="input-group">
                <label for="cognome">Cognome:</label>
                <input type="text" id="cognome" name="cognome" required>
            </div>
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <input type="submit" class="btn" value="Registrati">
            </div>
            <!-- Tasto "Accedi" con lo stesso stile -->
            <div class="input-group">
                <input type="button" class="btn" value="Accedi" onclick="redirectToLogin()">
            </div>
        </form>
    </div>

    <script>
        function redirectToLogin() {
            // Redirect to login page
            window.location.href = "login.php";
        }
    </script>
</body>
</html>
