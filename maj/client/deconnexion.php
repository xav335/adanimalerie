<? include('../../classes/config.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<? require_once('../../classes/classes.php'); ?>
<?
	// D�marrage d'une session
	session_start();
	
	$client = new client();
	
	// R�cup�ration des donn�es pass�es en param�tres
	unset( $_SESSION["site"] );
	//echo "--->" . $_SESSION["site"]["message_erreur"] . "<br>";
	
	// Redirection vers la page d'accueil
	header("Location: " . URL_SITE . "/accueil.html");
?>
<? include('../../include_connexion/connexion_site_off.php'); ?>