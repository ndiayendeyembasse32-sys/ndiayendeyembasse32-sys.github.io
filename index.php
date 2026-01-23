<?php

$produits = [
    [
        'id' => 1,
        'nom' => 'Ordinateur Portable HP 255 – Neuf',
        'marque' => 'hp',
        'prix' => 530.00,
        'image' => 'ordi.jpg',
        'description' => 'Profitez de cet ordinateur HP fin et léger que vous pourrez transporter facilement partout. Idéal pour un usage familial et aussi pour le travail professionnel.'
    ],
    [
        'id' => 2,
        'nom' => 'Apple iPhone 15 128Go – Rose (Reconditionné)',
        'marque' => 'apple',
        'prix' => 565.61,
        'image' => '15.jpg',
        'description' => 'Profitez de ce modèle d\'iPhone léger et avec sa couleur satisfaisante pour un outil adapté à tous les jours et un mode de travail dynamique.'
    ],
    [
        'id' => 3,
        'nom' => 'Apple Airpods Max Bleu',
        'marque' => 'apple',
        'prix' => 570.00,
        'image' => 'casque.jpg',
        'description' => 'Casque circum-aural fermé sans fil Réduction de bruit active. Bluetooth 5.0, commandes/micro, Autonomie 20h, Charge rapide'
    ],
    [
        'id' => 4,
        'nom' => 'Apple iPhone 17 256Go – orange',
        'marque' => 'apple',
        'prix' => 1329.00,
        'image' => '17.jpg',
        'description' => 'Profitez de ce modèle d\'iPhone léger et avec sa couleur satisfaisante pour un outil adapté à tous les jours et un mode de travail dynamique.'
    ],
    [
        'id' => 5,
        'nom' => 'Apple AirPods Pro (3rd generation) Casque True Wireless Stereo',
        'marque' => 'apple',
        'prix' => 249.00,
        'image' => 'airpods-pro-3-.jpeg',
        'description' => 'Apple AirPods Pro (3rd generation). Type de produit: Casque. Technologie de connectivité: True Wireless Stereo (TWS), Bluetooth. Utilisation recommandée: Appels/Musique/Sport/Au quotidien, Couleur du produit: Blanc'
    ]
];


$recherche = isset($_POST['recherche']) ? trim($_POST['recherche']) : '';
$marque = isset($_POST['brand']) ? $_POST['brand'] : '';
$prix_range = isset($_POST['price']) ? $_POST['price'] : '';

function filtrerProduits($produits, $recherche, $marque, $prix_range) {
    $resultat = [];
    
    foreach ($produits as $produit) {
        $afficher = true;
        
       
        if (!empty($recherche)) {
            $recherche_lower = strtolower($recherche);
            $nom_lower = strtolower($produit['nom']);
            $desc_lower = strtolower($produit['description']);
            
            if (strpos($nom_lower, $recherche_lower) === false && 
                strpos($desc_lower, $recherche_lower) === false) {
                $afficher = false;
            }
        }
        
       
        if (!empty($marque) && $produit['marque'] !== $marque) {
            $afficher = false;
        }
        
        
        if (!empty($prix_range)) {
            switch ($prix_range) {
                case '0-200':
                    if ($produit['prix'] < 0 || $produit['prix'] > 200) {
                        $afficher = false;
                    }
                    break;
                case '200-500':
                    if ($produit['prix'] < 200 || $produit['prix'] > 500) {
                        $afficher = false;
                    }
                    break;
                case '500-1000':
                    if ($produit['prix'] < 500 || $produit['prix'] > 1000) {
                        $afficher = false;
                    }
                    break;
                case '1000+':
                    if ($produit['prix'] < 1000) {
                        $afficher = false;
                    }
                    break;
            }
        }
        
        if ($afficher) {
            $resultat[] = $produit;
        }
    }
    
    return $resultat;
}


$produits_filtres = filtrerProduits($produits, $recherche, $marque, $prix_range);
session_start(); 
if (isset($_POST['ajouter_panier'])) {
    $produit_id = $_POST['produit_id'];

   
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }
    if (!isset($_SESSION['panier'][$produit_id])) {
        $_SESSION['panier'][$produit_id] = 1;
    } else {
        $_SESSION['panier'][$produit_id] += 1;
    }

   
    $message_panier = "Produit ajouté au panier !";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>epsi-tech</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="index.css">
    <link rel="icon" type="img" href="EPSI .jpg">
</head>
<body>
    <?php if (isset($message_panier)): ?>
    <p style="color: green; text-align: center; font-weight: bold;"><?php echo $message_panier; ?></p>
   <?php endif; ?>
    <header>
        <div class="navbar">
            <div class="logo">
                <i class="fa-solid fa-microchip"></i> EPSI_TECH
            </div>

            <nav class="nav-links">
                <a href="index.php">Accueil</a>
                <a href="produit.php">Produits</a>
                <a href="apropos.html">À propos</a>
                <a href="contact.php">Contact</a>
            </nav>

            <div class="nav-icons">
                <i class="fa-solid fa-magnifying-glass"></i>
                <a href="inscription.html"><i class="fa-solid fa-user"></i></a>
                <a href="panier.php"><i class="fa-solid fa-cart-shopping"></i></a>
            </div>
        </div>
    </header>

    <div class="top-bar">
       
        <section class="filter-section">
            <h3 class="filter-title">Filtrer</h3>
            <form class="filter-container" method="POST" action="index.php">
                <div class="filter-group">
                    <label for="brand">Marques</label>
                    <select id="brand" name="brand" class="filter-select">
                        <option value="">Toutes les marques</option>
                        <option value="apple" <?php echo ($marque === 'apple') ? 'selected' : ''; ?>>Apple</option>
                        <option value="hp" <?php echo ($marque === 'hp') ? 'selected' : ''; ?>>HP</option>
                        <option value="samsung" <?php echo ($marque === 'samsung') ? 'selected' : ''; ?>>Samsung</option>
                        <option value="asus" <?php echo ($marque === 'asus') ? 'selected' : ''; ?>>Asus</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="price">Prix</label>
                    <select id="price" name="price" class="filter-select">
                        <option value="">Tous les prix</option>
                        <option value="0-200" <?php echo ($prix_range === '0-200') ? 'selected' : ''; ?>>0 € - 200 €</option>
                        <option value="200-500" <?php echo ($prix_range === '200-500') ? 'selected' : ''; ?>>200 € - 500 €</option>
                        <option value="500-1000" <?php echo ($prix_range === '500-1000') ? 'selected' : ''; ?>>500 € - 1000 €</option>
                        <option value="1000+" <?php echo ($prix_range === '1000+') ? 'selected' : ''; ?>>1000 € et plus</option>
                    </select>
                </div>

              
                <input type="hidden" name="recherche" value="<?php echo htmlspecialchars($recherche); ?>">
                
                <button type="submit" class="filter-btn">Appliquer</button>
            </form>
        </section>

       
        <form class="search-box" method="POST" action="index.php">
            <input class="search-input" type="search" name="recherche" 
                   placeholder="Rechercher" 
                   value="<?php echo htmlspecialchars($recherche); ?>">
            
            
            <input type="hidden" name="brand" value="<?php echo htmlspecialchars($marque); ?>">
            <input type="hidden" name="price" value="<?php echo htmlspecialchars($prix_range); ?>">
            
            <button class="search-btn" type="submit">Rechercher</button>
        </form>
    </div>

    <div class="button-group">
        <button><i class="fas fa-mobile-alt"></i><span>Téléphones & Tablettes</span></button>
        <button><i class="fas fa-laptop"></i><span>Informatique</span></button>
        <button><i class="fas fa-tv"></i><span>TV</span></button>
        <button><i class="fas fa-headphones"></i><span>Audio</span></button>
        <button><i class="fas fa-ellipsis-h"></i><span>Autres</span></button>
    </div>

    <div class="produits">
        <?php if (count($produits_filtres) > 0): ?>
            <?php foreach ($produits_filtres as $produit): ?>
                <div class="carte-produit">
                    <img src="<?php echo htmlspecialchars($produit['image']); ?>" 
                         alt="<?php echo htmlspecialchars($produit['nom']); ?>">
                    <div class="details">
                        <h3><?php echo htmlspecialchars($produit['nom']); ?></h3>
                        <span class="prix"><?php echo number_format($produit['prix'], 2, ',', ' '); ?>€</span>
                        <p><?php echo nl2br(htmlspecialchars($produit['description'])); ?></p>
                        <form method="post" action="">
                         <input type="hidden" name="produit_id" value="<?php echo $produit['id']; ?>">
                         <button type="submit" name="ajouter_panier">Ajouter au panier</button>
</form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 50px; width: 100%;">
                <h2>Aucun produit trouvé</h2>
                <p>Essayez de modifier vos critères de recherche ou de filtrage.</p>
                <a href="index.php" style="color: #007bff; text-decoration: none;">
                    <i class="fas fa-redo"></i> Réinitialiser les filtres
                </a>
            </div>
        <?php endif; ?>
    </div>

    <footer>
        <p>epsitech01@gmail.com</p>
        <p>un rue Sainte Marie, Courbevoie</p>
    </footer>
</body>
</html>