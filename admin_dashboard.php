<?php
session_start();

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projet";

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $type_compte = $_POST['type_compte'];
    $identifiant = $_POST['identifiant'];
    $mot_de_passe = $_POST['mot_de_passe'];

    // Requête SQL pour vérifier les identifiants
    $sql = "SELECT * FROM users WHERE email = ? AND type = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $identifiant, $type_compte);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Vérification du mot de passe
        if (password_verify($mot_de_passe, $row['mot_de_passe'])) {
            // Démarrer une session et stocker les informations utilisateur
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_type'] = $row['type'];
            $_SESSION['user_email'] = $row['email'];

            // Rediriger en fonction du type de compte
            if ($type_compte == 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($type_compte == 'coach') {
                header("Location: coach_dashboard.php");
            } else {
                header("Location: client_dashboard.php");
            }
            exit();
        } else {
            echo "Identifiant ou mot de passe incorrect.";
        }
    } else {
        echo "Identifiant ou mot de passe incorrect.";
    }
    $stmt->close();
}

$conn->close();
?>
