<?php
$taxRate = 0.20; 
$products = [
    [
        'id' => 1,
        'name' => 'Ordinateur Portable HP 255 – Neuf',
        'price' => 530.00,
        'image' => 'ordi.jpg',
        'description' => 'Profitez de cet ordinateur HP fin et léger que vous pourrez transporter facilement partout. Idéal pour un usage familial et aussi pour le travail professionnel.'
    ],
    [
        'id' => 2,
        'name' => 'Apple iPhone 15 128Go – Rose (Reconditionné)',
        'price' => 565.61,
        'image' => '15.jpg',
        'description' => 'Profitez de ce modèle d’iPhone léger et avec sa couleur satisfaisante pour un outil adapté à tous les jours et un mode de travail dynamique.'
    ]
];

$subtotal = 0;
foreach ($products as $product) {
    $subtotal += $product['price'];
}
$taxAmount = $subtotal * $taxRate;
$totalAmount = $subtotal + $taxAmount;
$errors = [];
$successMessage = '';

$nom = $_POST['nom'] ?? '';
$prenom = $_POST['prenom'] ?? '';
$email = $_POST['email'] ?? '';
$cardNumber = $_POST['card_number'] ?? '';
$expiry = $_POST['expiry'] ?? '';
$cvc = $_POST['cvc'] ?? '';
$cardName = $_POST['card_name'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($nom) || !preg_match('/^[a-zA-ZÀ-ÿ\s-]{2,50}$/', $nom)) {
        $errors[] = 'Nom invalide (2-50 caractères, lettres uniquement)';
    }
    if (empty($prenom) || !preg_match('/^[a-zA-ZÀ-ÿ\s-]{2,50}$/', $prenom)) {
        $errors[] = 'Prénom invalide (2-50 caractères, lettres uniquement)';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email invalide';
    }
    $cleanCardNumber = preg_replace('/[\s-]/', '', $cardNumber); 
    if (empty($cleanCardNumber) || !preg_match('/^\d{13,19}$/', $cleanCardNumber)) {
        $errors[] = 'Numéro de carte invalide';
    }
    if (empty($expiry) || !preg_match('/^(0[1-9]|1[0-2])\/?([0-9]{2})$/', $expiry)) {
        $errors[] = 'Date d\'expiration invalide (format MM/AA)';
    }
    if (empty($cvc) || !preg_match('/^\d{3,4}$/', $cvc)) {
        $errors[] = 'Code CVC invalide (3 ou 4 chiffres)';
    }
    if (empty($cardName) || !preg_match('/^[a-zA-ZÀ-ÿ\s-]{2,}$/', $cardName)) {
        $errors[] = 'Nom sur la carte invalide';
    }
    if (empty($errors)) {
        
        $orderId = uniqid('CMD_');
        $successMessage = "✅ Panier validé ! Paiement de " . number_format($totalAmount, 2, ',', ' ') . "€ effectué avec succès. Votre commande #$orderId a été enregistrée.";
        $nom = $prenom = $email = $cardNumber = $expiry = $cvc = $cardName = '';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Récapitulatif de commande </title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="panier.php">
    <link rel="stylesheet" href="index.php">
    <style>
        .error { color: #d32f2f; background: #ffebee; padding: 10px; margin: 10px 0; border-radius: 4px; }
        .success { color: #388e3c; background: #e8f5e9; padding: 10px; margin: 10px 0; border-radius: 4px; }
        .cart-summary { background: #f5f5f5; padding: 20px; margin: 20px 0; border-radius: 8px; }
        .total-line { font-weight: bold; font-size: 1.2em; border-top: 2px solid #ccc; padding-top: 10px; margin-top: 10px; }
    </style>
</head>
<body>
    <h1 class="recap">Récapitulatif de commande</h1>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($successMessage)): ?>
        <div class="success"><?php echo htmlspecialchars($successMessage); ?></div>
    <?php endif; ?>

    <form action="" method="post">
        
        <div class="cxx">
            <h2>Vos informations</h2>
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required>
            <br>
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>" required>
            <br>
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <br>
        </div>

        <div class="produits">
            <h2>Votre sélection</h2>
            <?php foreach ($products as $product): ?>
                <div class="carte-produit">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <div class="details">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <span class="prix"><?php echo number_format($product['price'], 2, ',', ' '); ?>€</span>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary">
            <h3>Détail de la commande</h3>
            <?php foreach ($products as $product): ?>
                <div class="cart-item">
                    <span><?php echo htmlspecialchars($product['name']); ?></span>
                    <span><?php echo number_format($product['price'], 2, ',', ' '); ?>€</span>
                </div>
            <?php endforeach; ?>
            <div class="total-line">
                <div>Sous-total: <?php echo number_format($subtotal, 2, ',', ' '); ?>€</div>
                <div>TVA (<?php echo ($taxRate * 100); ?>%): <?php echo number_format($taxAmount, 2, ',', ' '); ?>€</div>
                <div>Total à payer: <?php echo number_format($totalAmount, 2, ',', ' '); ?>€</div>
            </div>
        </div>

        <div class="banner">
            <div class="banner-tail left"></div>
            <div class="banner-body">
                <span class="vertical-text">Mode de paiement</span>
            </div>
            <div class="banner-tail right"></div>
        </div>

        
        <aside class="payment">
            <div class="card-logos">
                <img src="visa.jpeg" alt="Visa">
                <img src="mastercard.png" alt="Mastercard">
                <img src="banque.jpeg" alt="Carte Bancaire">
            </div>

            <div class="payment-form">
                <label for="card-number">Numéro de carte</label>
                <input type="text" id="card-number" name="card_number" inputmode="numeric" maxlength="19" 
                       placeholder="1234 5678 9012 3456" value="<?php echo htmlspecialchars($cardNumber); ?>" required>

                <div class="row">
                    <div class="col">
                        <label for="expiry">Date d'expiration</label>
                        <input type="text" id="expiry" name="expiry" placeholder="MM/AA" maxlength="5" 
                               value="<?php echo htmlspecialchars($expiry); ?>" required>
                    </div>
                    <div class="col">
                        <label for="cvc">CVC / CVV</label>
                        <input type="text" id="cvc" name="cvc" inputmode="numeric" maxlength="4" placeholder="123" value="<?php echo htmlspecialchars($cvc); ?>" required>
                    </div>
                </div>

                <label for="card-name">Nom sur la carte</label>
                <input type="text" id="card-name" name="card_name" placeholder="Ndeye Mbasse" 
                       value="<?php echo htmlspecialchars($cardName); ?>" required>

                <button type="submit" class="valider et payer">
                  valider et payer<?php echo number_format($totalAmount, 2, ',', ' '); ?>€
                </button>
            </div>
        </aside>
    </form>
</body>
</html>