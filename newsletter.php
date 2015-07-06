<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? include('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session_classique.php'); ?>
<?
	
	$autorise_fancybox = true;
	$menu_newsletter = "active";
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
		<div class="contenuCentre">
			<div class="titrePage">Newsletter</div>
			
		</div>

<!-- Colonne de droite -->
		<?
		// Affichage de la colonne de droite
		include_once("./include/droite.php");
		?>
		
	</div>

<!-- Footer -->
	<? include_once("include/footer.php"); ?>
	
</div>
</body>
</html>
<? include('./include_connexion/connexion_site_off.php'); ?>