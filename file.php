<?php

// Détails de connexion à la base de données
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "projet";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

// Récupérer les données du formulaire
$type_compte = $_POST['type_compte'];
$identifiant = $_POST['identifiant'];
$mot_de_passe = $_POST['mot_de_passe'];

// Requête SQL pour vérifier si l'utilisateur existe dans la table "users"
$sql = "SELECT * FROM users WHERE email = '$identifiant' AND mot_de_passe = '$mot_de_passe'";
$result = $conn->query($sql);

// Vérifier si la requête a renvoyé un résultat
if ($result->num_rows > 0) {
    // Récupérer les détails de l'utilisateur à partir du résultat de la requête
    $row = $result->fetch_assoc();

    // Vérifier le type de compte de l'utilisateur et rediriger vers la page correspondante
    switch ($row['type_compte']) {
        case 'admin':
            header("Location: page_administrateur.php");
            break;
        case 'coach':
            header("Location: page_coach.php");
            break;
        case 'client':
            header("Location: page_client.php");
            break;
        default:
            echo "Type de compte inconnu";
    }
} else {
    // Aucun utilisateur correspondant trouvé dans la base de données
    echo "Identifiant ou mot de passe incorrect";
}

// Fermer la connexion à la base de données
$conn->close();

?>
