<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? include('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session_classique.php'); ?>
<?
	// Récupération des données passées en paramètres
	$num_produit = $_GET["n"];
	
	$produit_categorie = new produit_categorie();
	$produit = new produit();
	
	// Tentative de chargement...
	if ( $produit->load( $num_produit ) ) {
		$display_cdc = ( $produit->coup_de_coeur == '1' ) ? "block" : "none";
		if ( $produit->prix_promo > 0 ) {
			$prix = $produit->prix_promo . "&euro;";
			$aulieude = " <span class='aulieude'>(Au lieu de " . $produit->prix . "&euro;)</span>";
		}
		else $prix = $produit->prix . "&euro;";
	}
	
	// Pas valable --> Redirection vers la page d'accueil
	else header("Location: index.php");
	
	$menu_produit = "active";
?>

<html>
	<head>
		<? 
		// Titre + CSS
		include_once("./include/header.php");
		?>
		
		<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
		<script>
			!window.jQuery && document.write('<script src="../../js/jquery-1.4.3.min.js"><\/script>');
		</script>
		<script type="text/javascript" src="../../fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
		<script type="text/javascript" src="../../fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<link rel="stylesheet" type="text/css" href="../../fancybox/jquery.fancybox-1.3.4.css" media="screen" />
		
		<script type="text/javascript">
			$(document).ready(function() {
				$(".simple").fancybox();
				
				$("a[rel=groupe_image]").fancybox({
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'titlePosition' 	: 'over',
					'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
						return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
					}
				});
			});
			
			function changer_categorie( num ) {
				//alert("On change de categorie... " + find("categorie_" + num ).value);
				document.formulaire.action = "produit-" + find("categorie_" + num ).value + ".html";
				document.formulaire.submit();
			}
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
				<input type="hidden" name="mon_action" value="">
				
				<div class="coupdecoeur" style="display:<?=$display_cdc?>;"><img src="images/coupdecoeur.png" alt="" title="Coup de cœur" /></div>
				<div class="titrePageProduit"><? echo $produit_categorie->getTitre( $produit->num_produit_categorie )?> - <?=stripslashes( utf8_encode( $produit->nom ) )?></div>
				<div class="encartTop">
					<div class="agrandissement"><img src="<?=$produit->getImage();?>" width="412" alt="" title="<?=stripslashes( utf8_encode( $produit->nom ) )?>" /></div>
					<div style="width:230px;margin-left:12px;">
						<span class="titre"><?=stripslashes( utf8_encode( $produit->nom ) )?></span>
						<p><?=stripslashes( utf8_encode( $produit->resume ) )?></p>
						<p class="prix"><?=$prix?><?=$aulieude?><p>
						<a href="ajouter-au-panier-produit-<?=$produit->num_produit?>.html" class="ajoutpanier"></a>
					</div>
					<div style="min-height:60px; border:0px solid blue;"><?=$produit->getListeImage();?></div>
				</div>
<!-- Contenu Bas de Page -->
				<div class="encartBottom" style="width:407px; min-height:245px;">
					<a href="javascript:void(0);" onclick="$('#ongletDescription').show();$('#ongletInfos').hide();$(this).addClass('actif');$('#infosgenerales').removeClass('actif');" class="lienOnglet actif" id="description">Description</a> <a href="javascript:void(0);" onclick="$('#ongletDescription').hide();$('#ongletInfos').show();$(this).addClass('actif');$('#description').removeClass('actif');" class="lienOnglet" id="infosgenerales">Informations générales</a>
					<div id="ongletDescription" class="onglet"><?=stripslashes( utf8_encode( $produit->texte ) )?></div>
					<div id="ongletInfos" class="onglet"><?=stripslashes( utf8_encode( $produit->info ) )?></div>
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