<?php
try {
    $bdd = new PDO('mysql:host=localhost;port=3306;dbname=projetecommerce', 'root', '');
    // echo "connexion réussie";
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
} 