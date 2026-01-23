<?php

session_start();

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

$produits = [
    [
        "id" => 1, 
        "image" => "ordi.jpg",
        "alt" => "Ordinateur portable",
        "nom" => "Ordinateur portable hp 255",
        "description" => "Performance et fiabilité pour le travail ou les études."
    ],
    [
        "id" => 2,
        "image" => "15.jpg",
        "alt" => "Téléphone portable",
        "nom" => "iPhone 15",
        "description" => "Design élégant, puissance et rapidité."
    ],
    [
        "id" => 3,
        "image" => "casque.jpg",
        "alt" => "Casque",
        "nom" => "Apple Airpods Max",
        "description" => "Son immersif et autonomie longue durée."
    ],
    [
        "id" => 4,
        "image" => "ipod touch.jpeg",
        "alt" => "iPod",
        "nom" => "iPod Touch",
        "description" => "Musique et divertissement à portée de main."
    ]
];


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajouter_panier'])) {
 
    $produit_id_a_ajouter = (int)$_POST['produit_id']; 
    $produit_trouve = null;
    foreach ($produits as $p) {
        if ($p['id'] === $produit_id_a_ajouter) {
            $produit_trouve = $p;
            break;
        }
    }

    if ($produit_trouve) {
        
        $_SESSION['panier'][] = $produit_trouve['id'];
        header("Location: produit.php");
        exit(); 
    } else {
       
    }
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epsi Tech - Produits</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="apropos.html">
    <link rel="stylesheet" href="contact.php">

</head>
<body class="body-produit">

    <?php

    echo '<div style="background-color: #e0f7fa; padding: 10px; border: 1px solid #00bcd4; margin-bottom: 20px;">';
    echo '<h3>Contenu du Panier  :</h3>';
    if (!empty($_SESSION['panier'])) {
        echo '<ul>';
        foreach ($_SESSION['panier'] as $item_id) {
            $nom_produit_debug = "Produit inconnu";
            foreach ($produits as $p) {
                if ($p['id'] === $item_id) {
                    $nom_produit_debug = $p['nom'];
                    break;
                }
            }
            echo '<li>  - Nom: ' . htmlspecialchars($nom_produit_debug) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>Le panier est vide.</p>';
    }
    echo '</div>';
   
    ?>

    <header>
        <nav class="nav-produit">
            <h1 class="logo-produit">Epsi Tech</h1>
            <ul class="menu-produit">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="produit.php" class="active">Produits</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="apropos.html">À propos</a></li>
                <li><a href="panier.php">Panier (<?php echo count($_SESSION['panier']); ?>)</a></li>
            </ul>
        </nav>
    </header>

    <section class="produits-section">
        <h2>Nos Produits</h2>
        <div class="grille-produits">
            <?php
        
            foreach ($produits as $produit) {
                echo '<div class="produit">';
                echo '    <img src="' . htmlspecialchars($produit["image"]) . '" alt="' . htmlspecialchars($produit["alt"]) . '">';
                echo '    <h3>' . htmlspecialchars($produit["nom"]) . '</h3>';
                echo '    <p>' . htmlspecialchars($produit["description"]) . '</p>';
                echo '    <form action="produit.php" method="post">';
                echo '        <input type="hidden" name="produit_id" value="' . htmlspecialchars($produit["id"]) . '">'; // On envoie l'ID
                echo '        <button type="submit" name="ajouter_panier">Ajouter au panier</button>';
                echo '    </form>';
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <footer class="footer-produit">
        <p>&copy; 2025 Epsi Tech - Tous droits réservés</p>
    </footer>
</body>
</html>