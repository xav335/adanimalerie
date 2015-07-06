<? require_once('../../classes/start_session_admin.php'); ?>
<? require_once('../../classes/config.php'); ?>
<? require_once('../../classes/classes.php'); ?>
<?
	$utilisateur = new utilisateur();
	
	// Déconnexion
	$utilisateur->deconnecter();
	
	// Redirection
	header("Location: " . $url_site . "/maj/index.php");
?>
