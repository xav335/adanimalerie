<? include('../../classes/config.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<? require_once('../../classes/classes.php'); ?>
<?
	// Démarrage d'une session
	session_start();
	
	$client = new client();
	
	// Récupération des données passées en paramètres
	unset( $_SESSION["site"] );
	//echo "--->" . $_SESSION["site"]["message_erreur"] . "<br>";
	
	// Redirection vers la page d'accueil
	header("Location: " . URL_SITE . "/accueil.html");
?>
<? include('../../include_connexion/connexion_site_off.php'); ?>