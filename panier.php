<?php
session_start();


if (isset($_POST['action']) && $_POST['action'] === 'supprimer' && isset($_POST['produit_id'])) {
    $produit_id_a_supprimer = intval($_POST['produit_id']);
    
    if (isset($_SESSION['panier'])) {
       
        $key = array_search($produit_id_a_supprimer, $_SESSION['panier']);
        if ($key !== false) {
            unset($_SESSION['panier'][$key]);
            $_SESSION['panier'] = array_values($_SESSION['panier']); 
        }
    }
    
    header('Location: panier.php');
    exit();
}

$produits_disponibles = [
    [
        "id" => 1,
        "image" => "ordi.jpg",
        "alt" => "Ordinateur portable",
        "nom" => "Ordinateur portable hp 255",
        "description" => "Performance et fiabilité pour le travail ou les études.",
        "prix" => 530.00 
    ],
    [
        "id" => 2,
        "image" => "15.jpg",
        "alt" => "Téléphone portable",
        "nom" => "iPhone 15", 
        "description" => "Design élégant, puissance et rapidité.",
        "prix" => 534.00 
    ],
    [
        "id" => 3,
        "image" => "casque.jpg",
        "alt" => "Casque",
        "nom" => "Apple Airpods Max",
        "description" => "Son immersif et autonomie longue durée.",
        "prix" => 549.00
    ],
    [
        "id" => 4,
        "image" => "ipod touch.jpeg",
        "alt" => "iPod",
        "nom" => "iPod Touch",
        "description" => "Musique et divertissement à portée de main.",
        "prix" => 199.99
    ]
];
 
$panier_ids_en_session = isset($_SESSION['panier']) ? $_SESSION['panier'] : [];
$produits_dans_panier_pour_affichage = [];
$total_panier = 0;
$quantites_par_produit_id = array_count_values($panier_ids_en_session);

foreach ($quantites_par_produit_id as $produit_id => $quantite) {
    foreach ($produits_disponibles as $produit_detail) {
        if ($produit_detail['id'] === $produit_id) {
            $produit_detail['quantite'] = $quantite;
            $produit_detail['sous_total'] = $produit_detail['prix'] * $quantite;
            $produits_dans_panier_pour_affichage[] = $produit_detail;
            $total_panier += $produit_detail['sous_total'];
            break; 
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epsi Tech - Mon Panier</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <nav class="nav-panier">
            <h1 class="logo-panier">Epsi Tech</h1>
            <ul class="menu-panier">
                <li><a href="index.php">Accueil</a></li>
                <li><a href="produit.php">Produits</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="apropos.html">À propos</a></li>
                <li><a href="panier.php" class="active">Panier (<?php echo count($panier_ids_en_session); ?>)</a></li>
            </ul>
        </nav>
    </header>

    <div class="pv">
        <img class="img1" src="pani.jpg" alt="">
        <img class="img2" src="WhatsApp Image 2025-10-20 à 14.32.15_86fc51d7.jpg" alt="">
    </div>
    <div class="animation_text">A l'EPSI_TECH votre satisfaction notre priorité</div>

    <h2 class="panier-page-header">Votre Panier</h2>

    <div id="contenu-panier">
        <?php if (empty($produits_dans_panier_pour_affichage)) : ?>
            <div class="panier-vide-message">
                <p>Votre panier est vide pour le moment.</p>
                <p><a href="produit.php">Retourner à la boutique</a> pour découvrir nos produits.</p>
            </div>
        <?php else : ?>
            <?php foreach ($produits_dans_panier_pour_affichage as $item) : ?>
                <div class="article-panier">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['alt']); ?>">
                    <div class="details">
                        <h3><?php echo htmlspecialchars($item['nom']); ?></h3>
                        <p>Quantité : <?php echo htmlspecialchars($item['quantite']); ?></p>
                        <p>Prix unitaire : <?php echo number_format($item['prix'], 2, ',', ' '); ?> &euro;</p>
                        <p>Sous-total : <?php echo number_format($item['sous_total'], 2, ',', ' '); ?> &euro;</p>
                    </div>
                    <div class="actions">
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="action" value="supprimer">
                            <input type="hidden" name="produit_id" value="<?php echo $item['id']; ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="total">
                <h3>Total : <?php echo number_format($total_panier, 2, ',', ' '); ?> &euro;</h3>
                <a href="produit.php">← Continuer mes achats</a>
                <a href="commande.php" class="valider">Valider la commande</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>