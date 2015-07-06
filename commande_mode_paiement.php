<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? include('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session.php'); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_produit = ( $_GET["n"] != "" ) ? $_GET["n"] : $_POST["num_produit"];
	
	$produit = new produit();
	$commande = new commande();
	$commande_produit = new commande_produit();
	
	/*echo "<pre>";
	print_r( $_POST );
	echo "</pre>";*/
	
	// Création ou modification de la commande en attente
	//echo "--- num_client : " . $_SESSION["site"]["num_client"] . "<br>";
	if ( ( $_SESSION["site"]["num_client"] != "" ) && ( !$commande->load( $_SESSION["site_num_commande"] ) ) ) {
		$post["num_etat"] = 2;
		$post["num_etat_paiement"] = 1;
		$post["num_client"] = $_SESSION["site"]["num_client"];
		$num_commande = $commande->gererDonnees( $post );
		//echo "--> num_commande : " . $num_commande . "<br>";
		$_SESSION["site_num_commande"] = $num_commande;
	}
	
	/*echo "<pre>";
	//print_r( $_SESSION["site_panier"][ $num_produit ] );
	//print_r( $_SESSION["site_panier"] );
	echo "</pre>";*/
	//echo "<br>---------------<br>";
	$num_produit = 0;
	
	// On recrée le détail de la commande
	$commande_produit->supprimer( $_SESSION["site_num_commande"], 0 );
	
	// On recalcule la valeur du panier (En même temps que l'on construit le détail de la commande)
	$total = 0;
	foreach( $_SESSION["site_panier"] as $_produit ) {
		//echo "--- " . $_produit["detail"]->num_produit . "<br>";
		
		// Définition du tarif à appliquer
		$prix_unitaire = ( $_produit["detail"]->prix_promo > 0 ) ? $_produit["detail"]->prix_promo : $_produit["detail"]->prix;
		$prix = $_produit["quantite"] * $prix_unitaire;
		$total += $prix;
		
		// Enregistrement du détail
		if ( intval( $_SESSION["site_num_commande"] ) > 0 ) {
			
			// Chargement du produit
			$produit->load( $_produit["detail"]->num_produit );
			$post["nom"] = $produit->nom;
			
			$post["num_commande"] = $_SESSION["site_num_commande"];
			$post["num_produit"] = $_produit["detail"]->num_produit;
			$post["quantite"] = $_produit["quantite"];
			$post["prix_unitaire"] = $prix_unitaire;
			$commande_produit->gererDonnees( $post );
		}
	}
	
	// Mise à jour du tarif total
	if ( $commande->load( $_SESSION["site_num_commande"] ) ) $commande->setValue( 'prix', $total );
	
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
				<div class="titrePage">Modes de paiement possibles</div>
			
<!-- Affichage du panier -->
			<div class="encartPanier">
				<div class='ongletPanier'>
					<p style="color:#0e4d01;font-size:18px;padding-bottom:10px;">PayPal</p>
					<p>
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
					</p>
					<p>&nbsp;</p>
					<p align="right">
						<form action="<?=URL_PAYPAL?>" method="post">
							<input type="hidden" name="custom" value="<?=$_SESSION["site_num_commande"]?>;<?=$total?>" />
							<input type="hidden" name="amount" value="<?=$total?>" />
							<input type="hidden" name="currency_code" value="EUR" />
							<input type="hidden" name="shipping" value="0.00" />
							<input type="hidden" name="tax" value="0.00" />
							<input type="hidden" name="cmd" value="_xclick" />
							<input type="hidden" name="business" value="<?=COMPTE_PAYPAL?>" />
							<input type="hidden" name="item_name" value="Commande AD animalerie Bordeaux" />
							<input type="hidden" name="no_note" value="1" />
							<input type="hidden" name="lc" value="FR" />
							<input type="hidden" name="bn" value="PP-BuyNowBF" />
							<input type="hidden" name="return" value="<?=URL_SITE?>/paiement-valide.html" />
							<input type="hidden" name="cancel_return" value="<?=URL_SITE?>/commande-annulee.html" />
							<input type="hidden" name="notify_url" value="<?=URL_SITE?>/paypal/paiement_validation.php" />
							
							<input alt="Effectuez vos paiements via PayPal : une solution rapide, gratuite et sécurisée" name="submit" src="https://www.paypal.com/fr_FR/FR/i/btn/btn_buynow_LG.gif" type="image" /><img src="https://www.paypal.com/fr_FR/i/scr/pixel.gif" border="0" alt="" width="1" height="1" />
						</form>
					</p>
				</div>
			</div>
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