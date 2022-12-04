<?php
session_start();
if(isset($_POST['USERNAME']) && isset($_POST['PASSWORD']))
{
 // connexion à la base de données
 $db_username = 'WiseControl';
 $db_password = 'Sourar97@1912';
 $db_name = 'USERS';
 $db_host = '217.160.26.68';
 $db = mysqli_connect($db_host, $db_username, $db_password,$db_name)
 or die('could not connect to database');
 
 // on applique les deux fonctions mysqli_real_escape_string et htmlspecialchars
 // pour éliminer toute attaque de type injection SQL et XSS
 $username = mysqli_real_escape_string($db,htmlspecialchars($_POST['USERNAME'])); 
 $password = mysqli_real_escape_string($db,htmlspecialchars($_POST['PASSWORD']));
 
 if($username !== "" && $password !== "")
 {
 $requete = "SELECT count(*) FROM USERS where 
 NAME_USER = '".$username."' and PASSWORD_USER = '".$password."' ";
 $exec_requete = mysqli_query($db,$requete);
 $reponse = mysqli_fetch_array($exec_requete);
 $count = $reponse['count(*)'];
 if($count!=0) // nom d'utilisateur et mot de passe correctes
 {
 $_SESSION['username'] = $username;
 header('Location: principale.php');
 }
 else
 {
 header('Location: login.php?erreur=1'); // utilisateur ou mot de passe incorrect
 }
 }
 else
 {
 header('Location: login.php?erreur=2'); // utilisateur ou mot de passe vide
 }
}
else
{
 header('Location: login.php');
}
mysqli_close($db); // fermer la connexion
?>