<? require_once('../classes/config.php'); ?>
<? require_once('../classes/classes.php'); ?>
<? include('../include_connexion/connexion_site_on.php'); ?>
<?
	$debug = true;
	$fic = "test.txt";
	$fp_test = fopen( $fic, "w");
	
	if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Début traitement.\n" );
	
	// Lire le formulaire provenant du système PayPal et ajouter 'cmd'
	$req = 'cmd=_notify-validate';
	 
	foreach ($_POST as $key => $value) {
		$value = urlencode(stripslashes($value));
		$req .= "&$key=$value";
	}
	if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Req : " . $req . "\n" );
	
	// renvoyer au système PayPal pour validation
	SWITCH($_SERVER['DOCUMENT_ROOT']) {
	CASE '/var/www/adanimalerie':
		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Host: www.sandbox.paypal.com:443\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
		break;
		
	CASE '/home/web/a/adanimaleriedev/www':
		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Host: www.sandbox.paypal.com:443\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
		break;
		
	DEFAULT:
		$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
		$header .= "Host: ipnpb.paypal.com:443\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
		$fp = fsockopen ('ssl://ipnpb.paypal.com', 443, $errno, $errstr, 30);
		break;
	}
	
	$item_name = $_POST['item_name'];
	$item_number = $_POST['item_number'];
	$payment_status = $_POST['payment_status'];
	$payment_amount = $_POST['mc_gross'];
	$payment_currency = $_POST['mc_currency'];
	$txn_id = $_POST['txn_id'];
	$receiver_email = $_POST['receiver_email'];
	$payer_email = $_POST['payer_email'];
	$custom = $_POST['custom'];
	
	$client = new client();
	$commande = new commande();
	$erreur = new commande_erreur();
	$paiement = new commande_paiement();
	
	// ERREUR HTTP
	if ( !$fp ) {
		$post["num_commande"] = 0;
		$post["texte"] = "Erreur HTTP";
		$num_erreur = $erreur->gererDonnees( $post );
	} 
	else {
		if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Validation HTTP : OK \n" );
		
		fputs ($fp, $header . $req);
		while ( !feof( $fp ) ) {
			$res = fgets ($fp, 1024);
			if ( $debug ) fputs( $fp_test, "-> " . $res . "\n" );
			
			// La transaction est valide
			if (strcmp ($res, "VERIFIED") == 0) {
				if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Transaction : OK \n" );
				
				// vérifier que payment_status a la valeur Completed
				if ( $payment_status == "Completed") {
					if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Paiement statut : OK \n" );
					
					// Vérifier que txn_id n'a pas été précédemment traité
					if ( !$paiement->loadByTransactionID( $txn_id ) ) {
						if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Transaction ID : OK \n" );
						
						// Vérifier que receiver_email est votre adresse email PayPal principale
						if ( $receiver_email == COMPTE_PAYPAL ) {
							if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Compte PayPal : OK \n" );
							
							// traiter le paiement
							$tab_retour = explode( ";", $custom );
							$num_commande = $tab_retour[ 0 ];
							$montant_paye = $tab_retour[ 1 ];
							
							// Vérifier que payment_amount et payment_currency sont corrects
							if ( $payment_amount == $montant_paye ) {
							
								// Modification de la commande
								$commande->load( $num_commande );
								$commande->num_etat_paiement = 2;
								$commande->prix = $payment_amount;
								$commande->transaction_id = $txn_id;
								$num_commande = $commande->modifier();
								if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "1 - num_commande : " . $num_commande . "\n" );
								
								// Ajout du paiement
								$tab["num_commande"] = $num_commande;
								$tab["transaction_id"] = $txn_id;
								$tab["payer_email"] = $payer_email;
								$tab["montant"] = $payment_amount;
								$tab["statut"] = $payment_status;
								$requete = $paiement->gererDonnees( $tab );
								if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "2 - requete : " . $requete . "\n" );
							}
							else {
								if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Montant : NOK \n" );
								
								// Mauvaise montant
								$post["num_commande"] = 0;
								$post["texte"] = "Montant initial différent du montant payé";
								$num_erreur = $erreur->gererDonnees( $post );
							}
						}
						else {
							if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Compte PayPal : NOK \n" );
							
							// Mauvaise adresse email paypal
							$post["num_commande"] = 0;
							$post["texte"] = "Mauvaise adresse email paypal";
							$num_erreur = $erreur->gererDonnees( $post );
						}
					}
					else {
						if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Transaction ID : NOK \n" );
						
						// ID de transaction déjà utilisé
						$post["num_commande"] = 0;
						$post["texte"] = "ID de transaction déjà utilisé";
						$num_erreur = $erreur->gererDonnees( $post );
					}
				}
				else {
					if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Paiement statut : NOK \n" );
					
					// Statut de paiement: Echec
					$post["num_commande"] = 0;
					$post["texte"] = "Statut de paiement: Echec";
					$num_erreur = $erreur->gererDonnees( $post );
				}
			}
			
			// Transcation INVALIDE
			else if (strcmp ($res, "INVALID") == 0) {
				if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Transaction : NOK \n" );
				
				// Transaction invalide 
				$post["num_commande"] = 0;
				$post["texte"] = "Transaction invalide";
				$num_erreur = $erreur->gererDonnees( $post );
			}
			
			// 400 Bad Request
			else if (strcmp ($res, "INVALID") == 0) {
				if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . "- Transaction : NOK \n" );
				
				// Transaction invalide 
				$post["num_commande"] = 0;
				$post["texte"] = "Transaction invalide";
				$num_erreur = $erreur->gererDonnees( $post );
			}
		}
		fclose ($fp);
		
		if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . " ----------- FIN TRAITEMENT ----------- \n" );
	}
	
	// ---------------- Préparation du mail  ---------------------------------------- //
	$entete = "From:AD animalerie <NePasRepondre@adanimalerie.com>\n";
	$entete .= "MIME-version: 1.0\n";
	$entete .= "Content-type: text/html; charset= iso-8859-1\n";
	//$entete .= "Bcc: franck_langleron@hotmail.com\n";
	
	if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . " - num_erreur = " . $num_erreur . "\n" );
	if ( $debug ) fputs( $fp_test, "- " . date("H:i:s") . " - num_commande = " . $num_commande . "\n" );
	
	// En fonction du traitement précédent, on crée le texte du mail
	$corps = "";
	if ( intval( $num_erreur ) > 0 ) {
		$sujet = "ADanimalerie.com - Commande annulée";
		$corps .= "Désolé,<br>";
		$corps .= "Votre commande a été annulée pour les raisons suivantes :<br>";
		$corps .= "- " . $post["texte"] . "<br><br>";
		$corps .= "Veuillez nous excuser du dérangement.<br><br>";
		$corps .= "L'équipe AD animalerie.";
		
	}
	else {
		$sujet = "ADanimalerie.com - Confirmation de commande";
		$corps .= "Bonjour,<br>";
		$corps .= "Nous vous confirmons la prise en charge de votre commande.<br>";
		$corps .= ".....<br>";
		$corps .= "Retour : " . $retour . "<br>";
		$corps .= ".....<br>";
		$corps .= "A très bientôt sur ADanimalerie.com<br><br>";
		$corps .= "L'équipe AD animalerie.";
	}
	//$corps = utf8_decode( $corps );
	//echo $corps . "<br>";
	// ------------------------------------------------------------------------------ //
	
	// ---------------- Mail de confirmation au client  ----------------------------- //
	if ( $client->load( $tab["num_client"] ) ) {
		//$_to = $client->mail;
		$_to = "franck_langleron@hotmail.com";
		//echo "Envoi du message à " . $_to . "<br>";
		
		// Envoi des identifiants par mail
		mail($_to, $sujet, stripslashes($corps), $entete);
	}
	// ------------------------------------------------------------------------------ //
	
	// ---------------- Mail de confirmation à l'admin  ----------------------------- //
	if ( 1 == 1 ) {
		//$_to = "franck_langleron@hotmail.com";
		$_to = "franck_langleron@hotmail.com";
		//echo "Envoi du message à " . $_to . "<br>";
		
		// Envoi des identifiants par mail
		mail($_to, $sujet, stripslashes($corps), $entete);
	}
	// ------------------------------------------------------------------------------ //
	
	fclose( $fp_test );
?>
<? include('../include_connexion/connexion_site_off.php'); ?>