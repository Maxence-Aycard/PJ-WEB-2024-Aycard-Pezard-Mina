<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Administrateur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Tableau de Bord Administrateur</h2>
        <p>Bienvenue, administrateur !</p>
        
        <!-- Formulaire pour ajouter un coach -->
        <h3>Ajouter un Coach</h3>
        <form action="add_coach2.php" method="post">
            <div class="form-group">
                <label for="coach_email">Email du Coach</label>
                <input type="email" class="form-control" id="coach_email" name="coach_email" required>
            </div>
            <div class="form-group">
                <label for="coach_password">Mot de Passe</label>
                <input type="password" class="form-control" id="coach_password" name="coach_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter le Coach</button>
        </form>

        <!-- Liste des coachs -->
        <h3 class="mt-5">Liste des Coachs</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Connexion à la base de données
                $host = 'localhost';
                $db   = 'auth_systeme';
                $user = 'root';
                $pass = '';
                $port = '3306'; // Vérifiez votre configuration XAMPP
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

                // Récupérer les coachs
                $sql = "SELECT * FROM users WHERE type = 'coach'";
                $stmt = $pdo->query($sql);
                while ($row = $stmt->fetch()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>
                            <form action='delete_coach2.php' method='post' style='display:inline;'>
                                <input type='hidden' name='coach_id' value='" . htmlspecialchars($row['id']) . "'>
                                <button type='submit' class='btn btn-danger'>Supprimer</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
