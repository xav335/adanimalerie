<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? include('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session_classique.php'); ?>
<?
	// Récupération des données passées en paramètres
	$num_categorie_animal = ( $_POST["num_categorie_animal"] != "" ) ? $_POST["num_categorie_animal"] : $_GET["n"];
	//$num_categorie_animal = 6;
	
	// Par défaut, on prend l'aquariophilie
	if ( intval( $num_categorie_animal  ) <= 0 ) $num_categorie_animal = 1;

	$animal_categorie = new animal_categorie();
	$animal = new animal();
	
	// Liste des sous-catégories de cette catégorie
	$liste_categorie = $animal_categorie->getListe( $num_categorie_animal );
	
	// Liste des animaux associés à cette catégorie
	$liste_animal = $animal->getListe( $num_categorie_animal );
	
	$menu_animaux = "active";
?>

<html>
	<head>
		<? 
		// Titre + CSS
		include_once("./include/header.php");
		?>
		
		<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
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
			<div class="coupdecoeur"><img src="images/coupdecoeur.png" alt="" title="Coup de cœur" /></div>
			<div class="titrePage">AMPHIBIENS - <span class="vert">CRAPAUDS</span></div>
			<div class="encartTop">
				<div class="agrandissement"><img src="images/visuel_crapaud.jpg" alt="" title="Amphibiens - Crapauds" /></div>
				<div style="width:230px;margin-left:12px;">
					<span class="titre">Dislophus Guineti</span>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed cursus tortor a lacus blandit tempor.</p>
					<p>Vestibulum eu tortor lacus. In congue ipsum vel justo placerat ac laoreet est sodales. Nam lacus purus, consectetur in euismod nec, rutrum non nisl. Vivamus laoreet lacus eget felis tristique vitae pharetra metus dictum.</p>
					<a href="#" class="ajoutpanier"></a>
				</div>
				<div><a href=""><img src="images/vignette_crapaud_01.jpg" alt="" title="" /></a> <a href=""><img src="images/vignette_crapaud_02.jpg" alt="" title="" /></a> <a href=""><img src="images/vignette_crapaud_02.jpg" alt="" title="" /></a></div>
			</div>
<!-- Contenu Bas de Page -->
			<div class="encartBottom" style="width:407px;">
				<a href="#" onclick="$('#ongletDescription').show();$('#ongletInfos').hide();$(this).addClass('actif');$('#infosgenerales').removeClass('actif');" class="lienOnglet actif" id="description">Description</a> <a href="#" onclick="$('#ongletDescription').hide();$('#ongletInfos').show();$(this).addClass('actif');$('#description').removeClass('actif');" class="lienOnglet" id="infosgenerales">Informations générales</a>
				<div id="ongletDescription" class="onglet">
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed cursus tortor a lacus blandit tempor.
Vestibulum eu tortor lacus. In congue ipsum vel justo placerat ac laoreet est sodales. Nam lacus purus, consectetur in euismod nec, rutrum non nisl. Vivamus laoreet lacus eget felis tristique vitae pharetra metus dictum.
				</div>
				<div id="ongletInfos" class="onglet">
					<span class="titre">Origine :</span>
					Vénézuela<br/><br/>
					<span class="titre">Taille :</span>
					5cm<br/><br/>
					<span class="titre">Nourriture :</span>
					Lorem ipsum<br/><br/>
					<span class="titre">Environnement :</span>
					Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed cursus tortor a lacus blandit tempor.
				</div>
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
	<div class="footer">
		AD Animalerie 35 rue Fondaudège à Bordeaux  / Tél. 05 56 44 67 88 / Fax : 05 56 51 72 01 / Numéro d‘urgence : 06 75 95 05 46<br/>
		<a href="">Mentions légales</a> / <a href="">Conception-réalisation Iconéo</a></div>
</div>
</body>
</html>
<? include('./include_connexion/connexion_site_off.php'); ?>