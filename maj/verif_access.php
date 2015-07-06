<? require_once('../classes/config.php');?>
<? require_once('../classes/classes.php');?>
<? require_once('../include_connexion/connexion_site_on.php');?>
<?
	// Lancement d'une session
	session_start();
	
	// Récupération des données passées en paramètres
	$login = $_POST["log"];
	$mdp = $_POST["mdp"];
	
	//echo $mdp . "<br>";
	//echo md5($mdp) . "<br>";
	
	$utilisateur = new utilisateur();

	// Utilisateur autorisé?
	$liste_utilisateur = $utilisateur->authentifier($login, $mdp);

	// Connexion valide en tant que CLIENT
	if ((!is_null($liste_utilisateur)) && (mysql_num_rows($liste_utilisateur) != 0)) {
		$data = mysql_fetch_assoc($liste_utilisateur);
		
		$_SESSION["maj"]["connexion_etablie"] = "valide";
		$_SESSION["maj"]["num_utilisateur"] = $data["num_utilisateur"];
		//echo "--- " . $_SESSION["num_utilisateur"] . "<br>";
		
		$action = "./page_accueil.php";
	}

	// La personne n'est pas autorisée à rentrer
	else {
		unset( $_SESSION["maj"] );
		$action = "./index.php";
		$erreur = "erreur";
	}
	echo "--- " . $_SESSION["maj"]["connexion_etablie"] . "<br>";
	echo "-->" . $action;
?>
<html>
	<body onload="document.formulaire.submit();">
	<!--<body>-->
		<form name="formulaire" action="<?=$action?>" method="POST">
			<input type="hidden" name="erreur" value="<?=$erreur?>">
			<!--<input type="submit" value="Valider">-->
		</form>
	</body>
</html>
<? require_once('../include_connexion/connexion_site_off.php'); ?>