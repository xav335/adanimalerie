<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? include('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session_classique.php'); ?>
<?
	
	$autorise_fancybox = true;
	$menu_accueil = "active";
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
			<div class="titrePage">Bienvenue</div>
			<div class="encartLeft">aquariophilie<br/><a href="aquariophilie.html"><img src="images/aquariophilie.jpg" alt=""  title="aquariophilie" /></a></div>
			<div class="encart">chiens<br/><a href="chiens.html"><img src="images/chiens.jpg" alt=""  title="chiens" /></a></div>
			<div class="encartLeft">oiseaux<br/><a href=""><img src="images/oiseaux.jpg" alt=""  title="oiseaux" /></a></div>
			<div class="encart">terrarophilie<br/><a href="terrariophilie.html"><img src="images/terrariophilie.jpg" alt=""  title="terrariophilie" /></a></div>
			<div class="infospratiques">
				<div class="titre">infos pratiques</div>
				<img src="images/patte.png" alt=""  title="" class="puce" />Les Insectes d'Alimentations arrivent en règle générale tous les Jeudis.<br/>
				(Renseignement en Magasin)
			</div>
		</div>

<!-- Colonne de gauche -->
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