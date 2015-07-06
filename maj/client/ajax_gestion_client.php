<? require_once('../../classes/config.php'); ?>
<? include('../../classes/start_session_admin.php');?>
<? require_once('../../classes/classes.php'); ?>
<? include('../../include_connexion/connexion_site_on.php'); ?>
<?
	// Récupération des données passés en paramètres
	$mon_action = $_POST["ma"];
	$num_client = intval( $_POST["n"] );
	
	$client = new client();
	
	// On souhaite récupérer les informations sur un client
	if ( $mon_action == "get_client" ) {
		
		// Tentative de chargement ...
		if ( $client->load( $num_client ) ) {
			$retour = "ok#_#";
			$retour .= str_replace("\\", "", utf8_encode( $client->entreprise ) ) . "#_#";
			$retour .= str_replace("\\", "", utf8_encode( $client->adresse ) ) . "#_#";
			$retour .= str_replace("\\", "", utf8_encode( $client->cp ) ) . "#_#";
			$retour .= str_replace("\\", "", utf8_encode( $client->ville ) ) . "#_#";
			$retour .= str_replace("\\", "", utf8_encode( $client->tel1 ) ) . "#_#";
			$retour .= str_replace("\\", "", utf8_encode( $client->nom ) ) . "#_#";
			$retour .= str_replace("\\", "", utf8_encode( $client->prenom ) ) . "#_#";
		}
		else
			$retour = "NOK#_#";
	}
	
	echo $retour;
?>
<? include('../../include_connexion/connexion_site_off.php'); ?>