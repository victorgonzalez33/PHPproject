<?php


// ON SE CONNECTE A MySQL
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=blog_ecommerce;charset=utf8', 'root', 'root');
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}


$mailTmp="";
$msg = "";

if(!empty($_POST)){
    // On récupère le $_POST['mail'] et le $_POST['pass']
    $mail = $_POST['mail'];
    $password = $_POST['pass'];

    // On regarde si $_POST['mail'] est connu dans la table user
    $req = $bdd->prepare('SELECT id FROM user WHERE mail= :mail');
    $req->bindParam(':mail', $mail);
    $req->execute();
    // Un fetch n'affiche qu'une seule ligne de la BDD
    // Un fetchAll affiche toutes les lignes de la BDD
    // On récupère un objet
    $result = $req->fetch();
    // SI oui
    if(!empty($result)){
        // On regarde si $_POST['pass'] correspond au pass de $_POST['mail']
        $req = $bdd->prepare('SELECT id FROM user WHERE mail= :mail AND password= :password');
        $req->bindParam(':mail', $mail);
        $req->bindParam(':password', $password);
        $req->execute();
        $result2 = $req->fetch();

        // Si oui
        if(!empty($result2)){
            $msg = "Bien connecté";
        }
        else {
            // Si non
            $msg = "Mot de passe incorrect";
            $mailTmp = $_POST['mail'];
        }
    }
    else{
        // Si non
        $msg = "Adresse mail inconnue";
    }
}

?>
