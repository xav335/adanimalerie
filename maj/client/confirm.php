<? include('../../classes/config.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<? require_once('../../classes/classes.php'); ?>
<?
	// Démarrage d'une session
	session_start();
	
	$client = new client();
	
	// Récupération des données passées en paramètres
	$code = trim( $_GET["c"] );
	//echo "--> Code : " . $code . "<br>";
	
	// On recherche un client dont le code est celui donné
	if ( $client->authentifierCode($code) ) {
		//echo "Activation du compte!<br>";
		
		$_SESSION["site"]["connexion_site_etablie"] = "valide";
		$_SESSION["site"]["num_client"] = $client->num_client;
		
		// Mise à jour du compte du client
		$client->actif = 1;
		$client->modifier();
		
		// Redirection vers l'espace client
		$page = "espace-client.html";
	}
	else {
		//echo "erreur!!!";
		unset( $_SESSION["site"] );
		$page = "accueil.html";
	}

	//echo "--->" . $_SESSION["site"]["num_client_alphatravel"] . "<br>";
	
	// Redirection vers la page d'accueil
	header("Location: " . URL_SITE . "/" . $page );
?>
<? include('../../include_connexion/connexion_site_off.php'); ?>