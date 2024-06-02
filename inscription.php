<?php
// Connexion à la base de données
$host = 'localhost';
$db   = 'auth_systeme';
$user = 'root';
$pass = '';
$port = '3306';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $type_compte = $_POST['type_compte'];

    // Vérifier si l'email est déjà utilisé
    $stmt = $pdo->prepare("SELECT COUNT(*) AS count FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch();
    if ($result['count'] > 0) {
        echo "Cet email est déjà utilisé. Veuillez en choisir un autre.";
        exit();
    }

    // Vérifier si les mots de passe correspondent
    if ($password !== $confirm_password) {
        echo "Les mots de passe ne correspondent pas.";
        exit();
    }

    // Hasher le mot de passe
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insérer le nouvel utilisateur dans la base de données
    $stmt = $pdo->prepare("INSERT INTO users (email, password, type) VALUES (:email, :password, :type)");
    $stmt->execute(['email' => $email, 'password' => $hashed_password, 'type' => $type_compte]);

    // Rediriger vers une page de succès
    header("Location: index.html");
    exit();
}
?>
