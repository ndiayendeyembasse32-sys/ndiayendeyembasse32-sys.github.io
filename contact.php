<?php
$host = 'localhost';
$dbname = 'projetecommerce';  
$username = 'root';    
$password = '';
$message_success = '';
$message_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $message_content = $_POST['message'];
    
  
    if (empty($nom) || empty($email) || empty($message_content)) {
        $message_error = "Tous les champs sont obligatoires.";
    } else {
        try {
          
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $sql = "INSERT INTO contacts (nom, email, message, date_creation) VALUES (?, ?, ?, NOW())";
            $stmt = $pdo->prepare($sql);
            
            if ($stmt->execute([$nom, $email, $message_content])) {
                $message_success = "Votre message a été envoyé avec succès !";
                $nom = $email = $message_content = '';
            } else {
                $message_error = "Erreur lors de l'envoi du message.";
            }
        } catch (Exception $e) {
            $message_error = "Erreur de connexion à la base de données.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epsi Tech - Contact</title>
    <link rel="stylesheet" href="index.css">
    <style>
        .message-success {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            margin: 20px 0;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
        }
        
        .message-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin: 20px 0;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }
    </style>
</head>
<body class="body-contact">
    <header>
        <nav class="nav-contact">
            <h1 class="logo-contact">Epsi Tech</h1>
            <ul class="menu-contact">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="produit.php">Produits</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
                <li><a href="apropos.html">À propos</a></li>
            </ul>
        </nav>
    </header>

    <section class="contact-section">
        <h2>Contactez-nous</h2>
        <p>Une question ? Une demande ? Remplissez le formulaire ci-dessous :</p>

        <?php if ($message_success): ?>
            <div class="message-success"><?php echo $message_success; ?></div>
        <?php endif; ?>

        <?php if ($message_error): ?>
            <div class="message-error"><?php echo $message_error; ?></div>
        <?php endif; ?>

        <form class="form-contact" method="POST">
            <input type="text" name="nom" placeholder="Votre nom" value="<?php echo $nom ?? ''; ?>" required>
            <input type="email" name="email" placeholder="Votre email" value="<?php echo $email ?? ''; ?>" required>
            <textarea name="message" placeholder="Votre message" required><?php echo $message_content ?? ''; ?></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </section>

    <footer class="footer-contact">
        <p>&copy; 2025 Epsi Tech - Tous droits réservés</p>
    </footer>
</body>
</html>