<? include('../../classes/config.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<? require_once('../../classes/classes.php'); ?>
<?
	// D�marrage d'une session
	session_start();
	
	$client = new client();
	
	// R�cup�ration des donn�es pass�es en param�tres
	$login = trim( $_POST["login"] );
	$mdp = trim( $_POST["mdp"] );
	$origine = $_SERVER['HTTP_REFERER'];
	
	// On recherche un client dont le code est celui donn�
	if ( $client->authentifier($login, $mdp) ) {
		//echo "Authentification r&eacute;ussie!";
		
		$_SESSION["site"]["connexion_site_etablie"] = "valide";
		$_SESSION["site"]["num_client"] = $client->num_client;
		
		$page = ( !empty( $_SESSION["site_panier"] ) ) ? URL_SITE . "/mode-de-paiement.html" : URL_SITE . "/espace-client.html";
	}
	else {
		//echo "erreur!!!";
		unset( $_SESSION["site"] );
		$page = URL_SITE . "/connexion-erreur.html";
	}

	//echo "--->" . $_SESSION["site"]["connexion_site_etablie"] . "<br>";
	//echo "--->" . $_SESSION["site"]["num_client"] . "<br>";
	//echo "--->" . $page . "<br>";
	
	// Redirection vers la page d'accueil
	header("Location: " . $page);
?>
<? include('../../include_connexion/connexion_site_off.php'); ?>