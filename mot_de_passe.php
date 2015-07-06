<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? include('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session_classique.php'); ?>
<?
	// Récupération des informations passées en paramètres
	$mon_action = $_POST["mon_action"];
	$anti_spam = $_POST["as"];
	
	//echo "--- mon_action : " . $mon_action . "<br>";
	//echo "--- anti_spam : " . $anti_spam . "<br>";
	
	$affichage_envoi_ok = "none";
	$affichage_envoi_erreur = "none";
	
	// Demande du mot de passe
	if ( ( $mon_action == "mdp" ) && ( $anti_spam == "" ) ) {
		$client = new client();
			
		// Tentative de chargement du client grâce à son mail
		if ( $client->loadByMail( $_POST["mail"] ) ) {
	
			$_to = $client->mail;
			//$_to = "franck_langleron@hotmail.com";
			$sujet = "ADanimalerie.com - Mot de passe";
			//echo "Envoi du message à " . $_to . "<br>";
			
			$entete = "From:AD animalerie <NePasRepondre@adanimalerie.com>\n";
			$entete .= "MIME-version: 1.0\n";
			$entete .= "Content-type: text/html; charset= iso-8859-1\n";
			//$entete .= "Bcc: franck_langleron@hotmail.com\n";
			
			$corps = "";
			$corps .= "Bonjour " . utf8_encode( $client->prenom ) . ",<br><br>";
			$corps .= "Voici vos identifiants :<br>";
			$corps .= "Login : <b>" . $client->mail . "</b><br>";
			$corps .= "Mot de passe : <b>" . $client->mdp . "</b><br><br>";
			$corps .= "A très bientôt sur ADanimalerie.com<br><br>";
			$corps .= "L'équipe AD animalerie.";
			$corps = utf8_decode( $corps );
			//echo $corps . "<br>";
			
			// Envoi des identifiants par mail
			mail($_to, $sujet, stripslashes($corps), $entete);
			
			$affichage_envoi_ok = "block";
		}
		else
			$affichage_envoi_erreur = "block";
	}
	
	$mail = ( $affichage_envoi_erreur == "block" ) ? $_POST["mail"] : "E-mail*";
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
			
			// Affichage des menus de produits associés
			include_once("./include/menu_produit_associe.php");
			?>
			
		</div>

<!-- Contenu Centre -->
		<div class="contenuPage">
			<div class="titrePage">Mot de passe perdu</div>
			<div class="encartTop formulaire">
				<form action="mot-de-passe-perdu.html" method="post" name="connexion" id="connexion">
					<input type="hidden" name="mon_action" id="mon_action" value="mdp" />
					<input type="hidden" name="as" id="as" value="" />
					
					<p style="font-size:14;">Veuillez indiquer votre adresse E-mail :</p>
					
					<div id="div_ok" style="display:<?=$affichage_envoi_ok?>">
						<h3>Merci,</h3>
						<p>Vos identifiants vont vous être envoyés...</p>
					</div>
					
					<div id="div_erreur" style="display:<?=$affichage_envoi_erreur?>">
						<h3>Attention,</h3>
						<p>Cette adresse mail est introuvable.</p>
					</div>
					
					<input type="text" name="mail" id="mail" value="<?=$mail?>" /><br/>
					<input type="submit" value="ENVOYER" class="submit" onclick="return true;" />
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