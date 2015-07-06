<?
	// Lancement d'une session
	session_start();
	
	// ------------------------------------------------------------- //
	// Dans le cas d'une perte de session, on redirige vers la page de connexion
	if ($_SESSION["maj"]["connexion_etablie"] == "") {
		header("Location: " . URL_SITE . "/index.php");
	}
	// ------------------------------------------------------------- //
	
	//echo "-->num_type_utilisateur : " . $_SESSION["maj"]["num_type_utilisateur"] . "<br>";
	//echo "-->type_menu_gauche : " . $_SESSION["maj"]["type_menu_gauche"] . "<br>";
?>