<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? include('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session_classique.php'); ?>
<?
	// Récupération des données passées en paramètres
	$num_categorie_animal = ( $_POST["num_categorie_animal"] != "" ) ? $_POST["num_categorie_animal"] : $_GET["n"];
	
	$animal_categorie = new animal_categorie();
	$animal = new animal();
	
	// Liste des sous-catégories de cette catégorie
	$liste_categorie = $animal_categorie->getListe( $num_categorie_animal );
	
	// Liste des animaux associés à cette catégorie
	$liste_animal = ( $num_categorie_animal != "" ) ? $animal->getListe( $num_categorie_animal ) : array();
	
	$menu_animaux = "active";
?>

<html>
	<head>
		<? 
		// Titre + CSS
		include_once("./include/header.php");
		?>
		
		<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		
		<script language=Javascript>
		<!--
			function changer_categorie() {
				//alert("On change de categorie...");
				document.formulaire.submit();
			}
		//-->
		</script>
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
			<form name="formulaire" method="post" action="">
				<div class="titrePageProduit"><? echo $animal_categorie->getTitre( $num_categorie_animal )?></div>
				
<!-- Liste des produits -->
				<?
				// On a des animaux pour cette catégorie
				if ( !empty( $liste_animal ) ) {
					foreach( $liste_animal as $_animal ) {
						?>
						<div class="encartBottom" style="width:330px;">
							<div class="onglet">
								<div class="vignette"><a href="detail-animal-<?=$_animal->num_animal?>.html"><img src="<?=$_animal->getImage();?>" width="100" alt="" title="<?=stripslashes( utf8_encode( $_animal->nom ) )?>" border="0" /></a></div>
								<div class="titre_categorie"><a href="detail-animal-<?=$_animal->num_animal?>.html"><?=stripslashes( utf8_encode( $_animal->nom ) )?></a></div>
								<div style="clear:both;"></div>
								<div style="width:325px;margin-top:10px;"><?=stripslashes( utf8_encode( $_animal->resume ) )?></div>
							</div>
						</div>
						<?
					}
				}
				
				// Pas d'animal
				else {
					?>
					<div class="encartBottom" style="width:685px;">
						<div class="onglet">D&eacute;sol&eacute;, pas de animal pour cette cat&eacute;gorie.</div>
					</div>
					<?
				}
				?>
			</form>
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