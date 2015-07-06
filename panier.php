<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? include('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session_classique.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_produit = ( $_GET["n"] != "" ) ? $_GET["n"] : $_POST["num_produit"];
	
	$produit = new produit();
	
	// Tentative de chargement...
	//unset( $_SESSION["site_panier"] );
	if ( ( $mon_action == "" ) && ( $produit->load( $num_produit ) ) ) {
		
		if ( !empty( $_SESSION["site_panier"] ) ) {
			if ( !empty( $_SESSION["site_panier"][ $num_produit ] ) ) {
				$qte = $_SESSION["site_panier"][ $num_produit ]["quantite"] + 1;
			}
			else {
				$qte = 1;
			}
		}
		else
			$qte = 1;
		
		// Chargement OK --> On ajoute le produit au panier
		$_SESSION["site_panier"][ $num_produit ]["quantite"] = $qte;
		$_SESSION["site_panier"][ $num_produit ]["detail"] = $produit;
	}
	
	// Ajout d'un produit
	if ( $mon_action == "ajouter" ) {
		//echo "Ajout...<br>";
		
		if ( !empty( $_SESSION["site_panier"] ) ) {
			if ( !empty( $_SESSION["site_panier"][ $num_produit ] ) )
				$qte = $_SESSION["site_panier"][ $num_produit ]["quantite"] + 1;
			else
				$qte = 1;
			
			// Chargement OK --> On ajoute le produit au panier
			$_SESSION["site_panier"][ $num_produit ]["quantite"] = $qte;
		}
	}
	
	// Diminution d'un produit
	else if ( $mon_action == "diminuer" ) {
		//echo "Diminution...<br>";
		
		if ( !empty( $_SESSION["site_panier"] ) ) {
			if ( !empty( $_SESSION["site_panier"][ $num_produit ] ) )
				$qte = $_SESSION["site_panier"][ $num_produit ]["quantite"] - 1;
			else
				$qte = 1;
			
			// Si on tombe à 0 --> On supprime le produit
			if ( $qte <= 0 )
				unset( $_SESSION["site_panier"][ $num_produit ] );
			else
				$_SESSION["site_panier"][ $num_produit ]["quantite"] = $qte;
		}
	}
	
	// Suppression d'un produit
	else if ( $mon_action == "supprimer" ) {
		//echo "Suppression...<br>";
		unset( $_SESSION["site_panier"][ $num_produit ] );
	}
	
	//echo "--- " . $_SESSION["site"]["num_client"] . "<br>";
	//print_r( $_SESSION["site_panier"][ $num_produit ] );
	//print_r( $_SESSION["site_panier"] );
	//echo "<br>---------------<br>";
	$num_produit = 0;
	
	$autorise_fancybox = true;
	$menu_panier = "active";
?>

<html>
	<head>
		<? 
		// Titre + CSS
		include_once("./include/header.php");
		?>
		
		<script type="text/javascript" language="javascript" src="js/js.js"></script>
		<script language=Javascript>
		<!--
			function diminuer_produit( num ) {
				find("wait_" + num).style.display = "block";
				document.formulaire.mon_action.value = "diminuer";
				document.formulaire.num_produit.value = num;
				document.formulaire.submit();
			}
			
			function ajouter_produit( num ) {
				find("wait_" + num).style.display = "block";
				document.formulaire.mon_action.value = "ajouter";
				document.formulaire.num_produit.value = num;
				document.formulaire.submit();
			}
			
			function supprimer_produit( num ) {
				find("wait_" + num).style.display = "block";
				document.formulaire.mon_action.value = "supprimer";
				document.formulaire.num_produit.value = num;
				document.formulaire.submit();
			}
			
			function valider() {
				document.formulaire.action = "mode-de-paiement.html";
				document.formulaire.mon_action.value = "valider";
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

<!-- Contenu Centre -->
		<div class="contenuCentre">
			<form name="formulaire" method="post" action="mon-panier.html">
				<input type="hidden" name="mon_action" value="">
				<input type="hidden" name="num_produit" value="">
				
				<div class="titrePage">Mon panier</div>
			
<!-- Affichage du panier -->
				<div class="encartPanier">
					<?
					// On a des produits dans le panier
					if ( !empty( $_SESSION["site_panier"] ) ) {
						echo "<div class='ongletPanier'>";
						echo "	<div class='panier_qte'><b>Qt&eacute;</b></div>";
						echo "	<div class='panier_produit'><b>Produit</b></div>";
						echo "	<div class='panier_prix'><b>Prix</b></div>";
						echo "	<div class='panier_bouton'>&nbsp;</div>";
						echo "	<div class='panier_wait'>&nbsp;</div>";
						echo "	<div style='clear:both;'></div>";
						
						$total = 0;
						
						foreach( $_SESSION["site_panier"] as $_produit ) {
							//echo "--- " . $_produit->num_produit . "<br>";
							
							// Définition du tarif à appliquer
							$prix = ( $_produit["detail"]->prix_promo > 0 ) ? $_produit["detail"]->prix_promo : $_produit["detail"]->prix;
							$prix = $_produit["quantite"] * $prix;
							$total += $prix;
							?>
							<div style="height:25px;margin-top:2px;padding-top:10px;border:1px solid #8F8979;">
								<div class="panier_qte"><?=$_produit["quantite"]?></div>
								<div class="panier_produit">
									<a href="detail-produit-<?=$_produit["detail"]->num_produit?>.html"><?=stripslashes( utf8_encode( $_produit["detail"]->nom ) )?></a>
								</div>
								<div class="panier_prix"><?=$prix?>&euro;</div>
								<div class="panier_bouton">
									<a href="javascript:diminuer_produit(<?=$_produit["detail"]->num_produit?>);">-</a>&nbsp;|&nbsp;
									<a href="javascript:ajouter_produit(<?=$_produit["detail"]->num_produit?>);">+</a>&nbsp;|&nbsp;
									<a href="javascript:supprimer_produit(<?=$_produit["detail"]->num_produit?>);">x</a>
								</div>
								<div id="wait_<?=$_produit["detail"]->num_produit?>" class="panier_wait"><img src="./images/activity.gif" alt="Loading..." border="0" /></div>
							</div>
							<div style="clear:both;"></div>
							<?
						}
						?>
						<div style="height:25px;margin-top:2px;padding-top:10px;border:1px solid #8F8979;">
							<div class="panier_qte"></div>
							<div class="panier_produit"><b>Total</b></div>
							<div class="panier_prix"><b><?=$total?>&euro;</b></div>
						</div>
						<div style="height:30px"></div>
						<div style="height:30px; text-align:right; border:0px solid blue;">
							<input type="button" value="Valider ma commande" onclick="javascript:valider();">
						</div>
						
						<div style="clear:both;"></div>
						<?
						
						echo "</div>";
					}
					
					// Rien dans le panier...
					else {
						?>
						<div class="ongletPanier">Aucun article dans votre panier</div>
						<?
					}
					?>
				</div>
			</form>
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