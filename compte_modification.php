<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? include('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session.php'); ?>
<?
	// Récupération des informations passées en paramètres
	$mon_action = $_POST["mon_action"];
	$anti_spam = $_POST["as"];
	
	//echo "--- mon_action : " . $mon_action . "<br>";
	//echo "--- anti_spam : " . $anti_spam . "<br>";
	
	//print_r( $_POST );
	//echo "<br>------------------<br>";
	
	$client = new client();
	
	$affichage_inscription_ok = "none";
	$affichage_inscription_erreur = "none";
	
	// Confirmation de l'inscription
	if ( ( $mon_action == "inscrire" ) && ( $anti_spam == "" ) ) {
		//echo "inscription...<br>";
		
		// Enregistrement des informations du client
		$_POST["num_client"] = $_SESSION["site"]["num_client"];
		$num_client = $client->gererDonnees( $_POST );
		
		// Modification OK
		if ( $client->load( $num_client ) ) {
			$affichage_inscription_ok = "block";
			
			// Envoi du mail de confirmation d'inscription au client
			if ( 1 == 1 ) {
				//$_to = $client->mail;
				$_to = "franck_langleron@hotmail.com";
				$sujet = "adanimalerie.com - Confirmation d'inscription";
				//echo "Envoi du message à " . $_to . "<br>";
				
				$entete = "From:AD animalerie <inscription@adanimalerie.com>\n";
				$entete .= "MIME-version: 1.0\n";
				$entete .= "Content-type: text/html; charset= iso-8859-1\n";
				//$entete .= "Bcc: franck_langleron@hotmail.com\n";
				
				$lien = URL_SITE . "/confirm-" . $client->code . ".html";
				
				$corps = "";
				$corps .= utf8_encode( $client->prenom ) . " " . utf8_encode( $client->nom ) . ",<br><br>";
				$corps .= "Vous venez de vous inscrire sur ADanimalerie.com et nous vous en remercions.<br><br>";
				$corps .= "Afin de valider la création de votre compte, veuillez cliquer sur le lien suivant :<br>";
				$corps .= "<a href='" . $lien . "'>" . $lien . "</a><br><br>";
				$corps .= "Nous restons à votre écoute pour toute demande d'information complémentaire.<br><br>";
				$corps .= "L'équipe AD animalerie.";
				$corps = utf8_decode( $corps );
				$corps = stripslashes( $corps );
				//echo $corps . "<br>";
				
				// Envoi des identifiants par mail
				mail($_to, $sujet, stripslashes($corps), $entete);
			}
			
			// Envoi du mail de confirmation d'inscription à l'admin
			if ( 1 == 1 ) {
				$_to = "franck_langleron@hotmail.com";
				$sujet = "adanimalerie.com - Confirmation d'inscription";
				//echo "Envoi du message à " . $_to . "<br>";
				
				$entete = "From:AD animalerie <inscription@adanimalerie.com>\n";
				$entete .= "MIME-version: 1.0\n";
				$entete .= "Content-type: text/html; charset= iso-8859-1\n";
				//$entete .= "Bcc: franck_langleron@hotmail.com\n";
				
				$corps = "";
				$corps .= utf8_encode( $client->prenom ) . " " . utf8_encode( $client->nom ) . " vient de s'inscrire sur ADanimalerie.com,<br><br>";
				$corps .= "<b>Informations :</b><br>";
				$corps .= "<b>Nom :</b> " . utf8_encode( $client->nom ) . "<br>";
				$corps .= "<b>Prénom :</b> " . utf8_encode( $client->prenom ) . "<br>";
				$corps .= "<b>Téléphone :</b> " . utf8_encode( $client->telephone ) . "<br>";
				$corps .= "<b>Mail :</b> " . utf8_encode( $client->mail ) . "<br>";
				$corps .= "<br>";
				$corps .= "L'équipe AD animalerie.";
				$corps = utf8_decode( $corps );
				$corps = stripslashes( $corps );
				//echo $corps . "<br>";
				
				// Envoi des identifiants par mail
				mail($_to, $sujet, stripslashes($corps), $entete);
			}
		}
		else {
			$affichage_inscription_erreur = "block";
			$texte_div_inscription_erreur = "Une erreur est survenue lors de la modification...";
		}
	}
	
	// Tentative de chargement
	if ( !$client->load( $_SESSION["site"]["num_client"] ) ) header("Location: accueil.html");
	
	$nom = stripslashes( utf8_encode( $client->nom ) );
	$prenom = stripslashes( utf8_encode( $client->prenom ) );
	$adresse = stripslashes( utf8_encode( $client->adresse ) );
	$cp = stripslashes( utf8_encode( $client->cp ) );
	$ville = stripslashes( utf8_encode( $client->ville ) );
	$tel = stripslashes( utf8_encode( $client->telephone ) );
	$email = stripslashes( $client->mail );
	$mdp = stripslashes( utf8_encode( $client->mdp ) );
	
	$menu_compte = "active";
?>

<html>
<head>
	<? 
	// Titre + CSS
	include_once("./include/header.php");
	?>

</head>
<body>
<div class="conteneur">

<!-- Menu top -->
	<div class="header"><img src="images/header.jpg" alt="" title="AD animalerie - Votre animalerie à Bordeaux" /></div>
	
	<?
	// Menu principal
	include_once("./include/menu.php");
	?>
	
	<div class="contenu">
		<div class="menuLeft">

<!-- Menu gauche -->
			
			<?
			// Menu principal de gauche
			include_once("./include/menu_gauche.php");
			
			// Affichage du menu
			include_once("./include/menu_espace_client.php");
			?>
			
		</div>

<!-- Contenu Page -->
		<div class="contenuPage">
			<div class="titrePage">Mes informations</div>
			<div class="encartTop formulaire">
				<form action="espace-client-modification.html" method="post" name="inscription" id="inscription">
					<input type="hidden" name="mon_action" id="mon_action" value="" />
					<input type="hidden" name="as" id="as" value="" />
					
					<div id="div_ok" style="display:<?=$affichage_inscription_ok?>">
						<h3>Merci,</h3>
						<p>Votre modification est bien prise en compte.</p>
					</div>
					
					<div id="div_erreur" style="display:<?=$affichage_inscription_erreur?>">
						<h3>Attention,</h3>
						<p><?=$texte_div_inscription_erreur?></p>
					</div>
					
					<input type="text" name="nom" id="nom" value="<?=$nom?>" /><br/>
					<input type="text" name="prenom" id="prenom" value="<?=$prenom?>" /><br/>
					<input type="text" name="adresse" id="adresse" value="<?=$adresse?>" /><br/>
					<input type="text" name="cp" id="cp" value="<?=$cp?>" /><br/>
					<input type="text" name="ville" id="ville" value="<?=$ville?>" /><br/>
					<input type="text" name="tel" id="tel" value="<?=$tel?>" /><br/>
					<input type="text" name="email" id="email" value="<?=$email?>" readonly /><br/>
					<input type="password" name="mdp" id="mdp" value="<?=$mdp?>" /><br/>
					<input type="password" name="mdp2" id="mdp2" value="<?=$mdp?>" /><br/>
					<input type="submit" value="MODIFIER" class="submit" onclick="verifier_inscription();return false;" />
				</form>
			</div>
		</div>
	</div>

<!-- Footer -->
	<? include_once("include/footer.php"); ?>

</div>
</body>
</html>
<? include('./include_connexion/connexion_site_off.php'); ?>