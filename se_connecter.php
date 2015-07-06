<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? include('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session_classique.php'); ?>
<?
	// Récupération des informations passées en paramètres
	$mon_action = $_POST["mon_action"];
	$erreur = $_GET["err"];
	
	//echo "--- mon_action : " . $mon_action . "<br>";
	//echo "--- anti_spam : " . $anti_spam . "<br>";
	
	$affichage_envoi_ok = ( $erreur != "") ? "block" : "none";
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
			<div class="titrePage">Se connecter</div>
			<div class="encartTop formulaire">
				<form action="connexion.html" method="post">
					<input type="hidden" name="mon_action" id="mon_action" value="connexion" />
					<input type="hidden" name="as" id="as" value="" />
					
					<div id="div_erreur" style="display:<?=$affichage_envoi_ok?>">
						<h3>Attention,</h3>
						<p>Le login et / ou mot de passe ne sont pas corrects.</p>
					</div>
					
					<input type="text" name="login" id="login" value="E-mail*" /><br/>
					<input type="password" name="mdp" id="mdp" value="Mot de passe*" /><br/>
					<p style="font-size:14;"><a href="mot-de-passe-perdu.html">Mot de passe perdu?</a></p>
					<input type="submit" value="SE CONNECTER" class="submit" onclick="return true;" />
				</form>
			</div>
			
			<div class="titrePage">Nouveau client</div>
			<div class="encartTop formulaire">
				<form action="inscription-client.html" method="post" name="creation" id="creation">
					<p style="font-size:14;">Je souhaite cr&eacute;er mon propre compte</p>
					<input type="submit" value="CREER MON COMPTE" class="submit" onclick="return true;" />
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