<? include('../../classes/config.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<? require_once('../../classes/classes.php'); ?>
<?
	// D�marrage d'une session
	session_start();
	
	$client = new client();
	
	// R�cup�ration des donn�es pass�es en param�tres
	$code = trim( $_GET["c"] );
	//echo "--> Code : " . $code . "<br>";
	
	// On recherche un client dont le code est celui donn�
	if ( $client->authentifierCode($code) ) {
		//echo "Activation du compte!<br>";
		
		$_SESSION["site"]["connexion_site_etablie"] = "valide";
		$_SESSION["site"]["num_client"] = $client->num_client;
		
		// Mise � jour du compte du client
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