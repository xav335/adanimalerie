<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? require_once('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session_classique.php'); ?>
<? require_once("./traitement_pagination.php"); ?>
<?
	// Récupération des données passées en paramètres
	$mon_action = $_POST["mon_action"];
	$num_categorie_produit = ( $_POST["num_categorie_produit"] != "" ) ? $_POST["num_categorie_produit"] : $_GET["n"];
	$num_produit_associe = $_GET["pa"];
	//$num_categorie_produit = 9;
	
	// Récupération des données en paramètres
	$NBRE_MAX_AFFICHES = 4;
	//$nb_page = ($_GET["page"] != "") ? $_GET["page"] : $_SESSION["_nb_page"];
	$nb_page = $_GET["page"];
	
	if ($nb_page == "") $nb_page = 1;
	
	// Conservation du numéro de la page affichée
	$_SESSION["_nb_page"] = $nb_page;
	
	//echo "--- mon_action : " . $mon_action . "<br>";
	//echo "--- num_categorie_produit : " . $num_categorie_produit . "<br>";
	//echo "--- nb_page : " . $nb_page . "<br>";
	//echo "--- SESSION['_nb_page'] : " . $_SESSION["_nb_page"] . "<br>";
	
	/*echo '<pre>';
	print_r($_GET);
	echo '</pre>';
	echo "<br>------------------------------<br>";*/
	
	// Par défaut, on prend l'aquariophilie
	if ( intval( $num_categorie_produit  ) <= 0 ) $num_categorie_produit = 1;

	$produit_associe = new produit_associe();
	$produit_produit_associe = new produit_produit_associe();
	$produit_categorie = new produit_categorie();
	$produit = new produit();
	
	// Affichage des catégories (C'est du classique!)
	if ( $num_produit_associe == "" )  {
		
		// Liste des sous-catégories de cette catégorie
		$liste_categorie = $produit_categorie->getListe( $num_categorie_produit );
		
		// Liste des catégories dans lesquelles il faut chercher les produits
		$liste_categorie_texte = utf8_encode( $produit_categorie->getSousCategorie( $num_categorie_produit ) ) . "0";
		//echo "--- liste_categorie_texte : " . $liste_categorie_texte . "<br>";
		
		// Liste des produits associés à cette catégorie
		$liste_produit = $produit->getListe( 0, $liste_categorie_texte );
	}
	
	// ...
	else {
		$produit_associe->load( $num_produit_associe );
		
		$liste_produit_associe = $produit_produit_associe->getListe( 0, $num_produit_associe, 0);
		$liste_produit = array();
		
		if ( !empty( $liste_produit_associe ) ) {
			foreach( $liste_produit_associe as $_produit) {
				$produit_temp = new produit();
				if ( $produit_temp->load( $_produit->num_produit ) ) $liste_produit[] = $produit_temp;
			}
		}
	}
	
	$menu_produit = "active";
?>

<html>
	<head>
		<? 
		// Titre + CSS
		include_once("./include/header.php");
		?>
		
		<link rel="stylesheet" href="../css/styles_pagination.css" type="text/css" charset="utf-8" />
		
		<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
		
		<script language=Javascript>
		<!--
			function changer_categorie( num ) {
				//alert("On change de categorie... " + find("categorie_" + num ).value);
				document.formulaire.action = "produit-" + find("categorie_" + num ).value + ".html";
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
				<input type="hidden" name="mon_action" value="">
				
				<div class="titrePageProduit">
					<?
					// Affichage des catégories (C'est du classique!)
					if ( $num_produit_associe == "" ) echo $produit_categorie->getTitre( $num_categorie_produit, $deroulant );
					
					// Affichage des produits associés à mot clé
					else
						echo "Produits associ&eacute;s &agrave \"" . stripslashes( utf8_encode( $produit_associe->nom ) ) . "\"";
					?>
				</div>
				
<!-- Liste des produits -->
				<?
				// On a des produits pour cette catégorie
				if ( !empty( $liste_produit ) ) {
					$index_page = 0;
					
					foreach( $liste_produit as $_produit ) {
						
						if (($index_page >= (($nb_page - 1) * $NBRE_MAX_AFFICHES)) && ($index_page < ($nb_page * $NBRE_MAX_AFFICHES))) {
							$index++;
							//echo "index_page : " . $index_page . "<br />";
							
							if ($index > 2) {
								$index = 0;
								//echo "</tr><tr>";
							}
							?>
							<div class="encartBottom" style="width:330px;">
								<div class="onglet">
									<div class="vignette"><a href="detail-produit-<?=$_produit->num_produit?>.html"><img src="<?=$_produit->getImage();?>" width="100" alt="" title="<?=stripslashes( utf8_encode( $_produit->nom ) )?>" border="0" /></a></div>
									<div class="titre_categorie"><a href="detail-produit-<?=$_produit->num_produit?>.html"><?=stripslashes( utf8_encode( $_produit->nom ) )?></a></div>
									<div style="clear:both;"></div>
									<div style="width:325px;margin-top:10px;"><?=stripslashes( utf8_encode( $_produit->resume ) )?></div>
								</div>
							</div>
							<?
						}
						
						// Incrément du compteur
						$index_page = $index_page + 1;
					}
					
					// Affichage de la pagination
					if ( count( $liste_produit ) > $NBRE_MAX_AFFICHES) {
						$nb_enregistrement = count( $liste_produit );
						//echo "---" . $nb_enregistrement . "<br />";

						// --- Définition de la page à appeler --- //
						//echo "--> " . $num_categorie_produit . "<br>";
						switch( $num_categorie_produit ) {
							case "1":
								$page_pagination = "aquariophilie-page";
								break;
								
							case "2":
								$page_pagination = "chiens-page";
								break;
								
							case "3":
								$page_pagination = "oiseaux-page";
								break;
								
							case "4":
								$page_pagination = "terrariophilie-page";
								break;
								
							default:
								$page_pagination = "produit-" . $num_categorie_produit . "-page";
								break;
						}
						// --------------------------------------- //
									
						// --- Initialisation de la pagination --- //
						$encadrement = 3;										// Nombre de pages présentes autour de la page sélectionnée
						$nombre_page_initial = 8;								// Nombre de pages disponibles en début et fin de liste
						$page_affichage = $page_pagination;						// Page appelée par la pagination
						$parametre_url = "";									// Paramètres envoyé dans l'URL
						// --------------------------------------- //
						
						$nbre_pages = ($nb_enregistrement / $NBRE_MAX_AFFICHES);
						if (round($nbre_pages,0) < $nbre_pages){ $nbre_pages = round($nbre_pages,0) + 1; }
						if (round($nbre_pages,0) > $nbre_pages){ $nbre_pages = round($nbre_pages,0); }
						//echo "nbre_pages : " . $nbre_pages . "<br />";
						//echo "nb_enregistrement : " . $nb_enregistrement . "<br />";
						
						//$nb_page_total = 40;
						//echo "nb_page_total : " . $nb_page_total . "<br />";
						//echo "page : " . $page . "<br />";
						//echo "nombre_page_initial : " . $nombre_page_initial . "<br />";
						//echo "encadrement : " . $encadrement . "<br />";
						
						afficher_pagination($page_affichage, 
							$parametre_url, 
							$nbre_pages, 
							$nombre_page_initial, 
							$encadrement, 
							$nb_page, 
							$bouton_pagination_precedent, 
							$bouton_pagination_suivant
						);
					}
				}
				
				// Pas de produit
				else {
					?>
					<div class="encartBottom" style="width:685px;">
						<div class="onglet">
							<?
							// Affichage des catégories (C'est du classique!)
							if ( $num_produit_associe == "" ) echo "D&eacute;sol&eacute;, pas de produit pour cette cat&eacute;gorie.";
							
							// Affichage des produits associés à mot clé
							else echo "D&eacute;sol&eacute;, pas de produit associ&eacute;.";
							?>
						</div>
					</div>
					<?
				}
				?>
			</form>
		</div>
	</div>

<!-- Footer -->
	<? include_once("include/footer.php"); ?>
	
</div>
</body>
</html>
<? include('./include_connexion/connexion_site_off.php'); ?>