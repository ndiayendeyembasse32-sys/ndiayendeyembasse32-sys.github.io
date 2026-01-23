<?php

include('bdd.php');
if (isset($_POST['nom']))
    
{
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $codepostal = $_POST['codepostal'];
    $age =$_POST['age'];
    $ville =$_POST['ville'];
    $telephone =$_POST['telephone'];
    $insert = $bdd->prepare("INSERT INTO users(nom, prenom, age, telephone, email, adresse, codepostal , ville) VALUES(?,?,?,?,?,?,?,?)");
    $insert->execute([$nom, $prenom, $age, $telephone, $email, $adresse,$codepostal,$ville]);
    echo "Inscription réussie !";
} 
else {
    echo "Erreur lors de l'inscription.";
}