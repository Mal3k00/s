<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Utente</title>
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
        <h2>Login Utente</h2>
        <form id="loginForm" method="post">
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="login">Accedi</button>
            </div>

            <div class="input-group">
                <input type="button" class="btn" value="Registrati" onclick="redirectToRegistration()">
            </div>
        </form>
    </div>

    <script>
        function redirectToRegistration() {

            window.location.href = "registrazione.php";
        }
    </script>

<?php
session_start();

// Dati del database 
$servername = "localhost:3307";
$username = "root";
$password = "root";
$dbname = "coworking_projeckt";

// Connessione al database
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica degli errori di connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

if (isset($_SESSION['session_id'])) {
    header('Location: area_personale.php');
    exit;
}

if (isset($_POST['login'])) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $msg = 'Inserisci email e password %s';
    } else {
        // Query per verificare le credenziali dell'utente
        $query = "SELECT id_utente, nome FROM utenti WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            // L'utente è stato autenticato con successo
            $user = $result->fetch_assoc();
            $_SESSION['session_id'] = $user['id_utente']; // Utilizza l'ID utente
            $_SESSION['session_user'] = $user['nome']; // Utilizza 'nome' come chiave
            header("Location: area_personale.php");
            exit(); 
        } else {
            // Credenziali non valide
            $msg = 'Credenziali utente errate %s';
        }
    }

    printf($msg, '<a href="../login.html">torna indietro</a>');
}

// Chiudi la connessione al database
$conn->close();
?>

</body>
</html>
