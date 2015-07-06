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
	
	//print_r( $_POST );
	//echo "<br>------------------<br>";
	
	$affichage_envoi_ok = "none";
	
	if ( ( $mon_action == "envoyer" ) && ( $anti_spam == "" ) ) {
		//echo "Envoyer...<br>";
		
		//$_to = "contact@adanimalerie.com";
		$_to = "franck_langleron@hotmail.com";
		$sujet = "ADanimalerie.com - Contact";
		//echo "Envoi du message à " . $_to . "<br>";
		
		$entete = "From:ADanimalerie <contact@adanimalerie.com>\n";
		$entete .= "MIME-version: 1.0\n";
		$entete .= "Content-type: text/html; charset= iso-8859-1\n";
		//$entete .= "Bcc: franck_langleron@hotmail.com\n";
		
		$corps = "";
		$corps .= "Bonjour,<br><br>";
		$corps .= "Vous avez un message de :<br><b>" . $_POST["nom"] . " " . $_POST["prenom"] . "</b> (" . $_POST["email"] . ")<br>";
		$corps .= $_POST["adresse"] . ", " . $_POST["cp"] . " " . $_POST["ville"] . "<br><br>";
		$corps .= "<b>Sujet :</b><br>";
		$corps .= $_POST["sujet"] . "<br><br>";
		$corps .= "<b>Message :</b><br>";
		$corps .= $_POST["msg"] . "<br><br>";
		$corps .= "L'équipe AD animalerie.";
		$corps = utf8_decode( $corps );
		//echo $corps . "<br>";
		
		// Envoi des identifiants par mail
		mail($_to, $sujet, stripslashes($corps), $entete);
		
		$affichage_envoi_ok = "block";
		$affichage_formulaire = "none";
	}
	
	$menu_contact = "active";
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

<!-- Contenu Page -->
		<div class="contenuPage">
			<div class="titrePage">Contact</div>
			<div class="encartTop formulaire">
				<form action="contactez-nous.html" method="post" name="contacte" id="contacte">
					<input type="hidden" name="mon_action" id="mon_action" value="" />
					<input type="hidden" name="as" id="as" value="" />
					
					<div style="border: 1px solid #0F4D02; padding: 3px; margin-bottom: 5px; display:<?=$affichage_envoi_ok?>">
						<div class="description">
							<h3>Merci,</h3>
							<p>Votre message nous a bien été envoyé.</p><br/>
							<p>Nous vous répondrons dans les plus brefs délais.</p><br/>
						</div>
					</div>
					
					<input type="text" name="nom" id="nom" value="Nom*" /><br/>
					<input type="text" name="prenom" id="prenom" value="Prénom*" /><br/>
					<input type="text" name="adresse" id="adresse" value="Adresse*" /><br/>
					<input type="text" name="cp" id="cp" value="Code postal*" /><br/>
					<input type="text" name="ville" id="ville" value="Ville*" /><br/>
					<input type="text" name="tel" id="tel" value="N° de Téléphone*" onkeypress="return isNumberKey(event);" /><br/>
					<input type="text" name="email" id="email" value="E-mail*" /><br/>
					<input type="text" name="sujet" id="sujet" value="Sujet*" /><br/>
					<textarea name="msg" id="msg">Votre message*</textarea><br/>
					<input type="submit" value="ENVOYER" class="submit" onclick="verif_form();return false;" />
				</form>
			</div>
<!-- Contenu Bas de Page -->
			<div class="encartBottom" style="width:407px;">
				<iframe width="407" height="245" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.fr/maps?f=q&amp;source=s_q&amp;hl=fr&amp;geocode=&amp;q=AD+animalerie,+Rue+Fondaud%C3%A8ge,+Bordeaux&amp;aq=0&amp;oq=ad+ani&amp;sll=44.846354,-0.579529&amp;sspn=0.007333,0.014033&amp;g=35+Rue+Fondaud%C3%A8ge,+Bordeaux&amp;ie=UTF8&amp;hq=AD+animalerie,&amp;hnear=Rue+Fondaud%C3%A8ge,+33000+Bordeaux,+Gironde,+Aquitaine&amp;t=m&amp;ll=44.846361,-0.579529&amp;spn=0.003347,0.008755&amp;z=16&amp;iwloc=A&amp;output=embed"></iframe>
			</div>
			<div class="encartBottomRight">
				<img src="images/picto_courrier.png" alt="" title="" /> <span class="titre">contactez-nous !</span>
				<span class="vert">UNE QUESTION ?</span> ÉCRIVEZ-NOUS<br/>
				<a href="mailto:contact@adanimalerie.com">contact@adanimalerie.com</a><br/><br/>
				<span class="titreparagraphe">Horaires</span><br/>
				Ouvert du Lundi au Samedi,<br/>sauf le Mercredi (jour de fermeture)<br/>
				de 9h30 à 12h30 et de 13h30 à 19h30<br/><br/>
				<span class="titreparagraphe">Venez nous voir !</span><br/>
				35 rue Fondaudège à Bordeaux<br/>
				Tél. 05 56 44 67 88<br/>
				Fax : 05 56 51 72 01<br/>
				<span class="urgence gras">Numéro d'urgence : 06 75 95 05 46</span>
			</div>
		</div>
	</div>

<!-- Footer -->
	<? include_once("include/footer.php"); ?>

</div>
</body>
</html>
<? include('./include_connexion/connexion_site_off.php'); ?>