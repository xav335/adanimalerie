<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? include('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session.php'); ?>
<?
	// Récupération des informations passées en paramètres
	$mon_action = $_POST["mon_action"];
	
	//echo "--- mon_action : " . $mon_action . "<br>";

	$etat = new etat();	
	$commande = new commande();	
	
	// Gestion des messages de retour
	$affichage_div_valide = ( $_GET["v"] == 1 ) ? "block" : "none";
	$affichage_div_annule = ( $_GET["a"] == 1 ) ? "block" : "none";
	
	// En cas de paiement validé --> On vide le panier
	if ( $_GET["v"] == 1 ) {
		unset( $_SESSION["site_num_commande"] );
		unset( $_SESSION["site_panier"] );
	}
	
	// En cas de commande annulée --> On le spécifie dans l'enregistrement de la commande
	if ( $_GET["a"] == 1 ) {
		if ( $commande->load( $_SESSION["site_num_commande"] ) ) {
			$commande->num_etat_paiement = 0;
			$commande->modifier();
			
			unset( $_SESSION["site_num_commande"] );
		}
	}
	
	// Liste des commandes en cours
	//echo "--- " . $_SESSION["site"]["num_client"] . "<br>";
	//$liste_commande_en_cours = $commande->getListe( $_SESSION["site"]["num_client"], 2, "commande.num_etat_paiement = '2'" );
	$liste_commande_en_cours = $commande->getListe( $_SESSION["site"]["num_client"], 2, '' );
	
	if ( !empty( $liste_commande_en_cours ) ) {
		$liste_exclusion = "0";
		foreach($liste_commande_en_cours as $_commande) {
			$liste_exclusion .= "," . $_commande->num_commande;
		}
	}
	
	// Liste du reste de l'historique
	//$historique = $commande->getListe( $_SESSION["site"]["num_client"], 0, "commande.num_etat_paiement = '2'", $liste_exclusion );
	$historique = $commande->getListe( $_SESSION["site"]["num_client"], 0, '', $liste_exclusion );
	
	$autorise_fancybox = true;
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
			
			// Affichage du menu
			include_once("./include/menu_espace_client.php");
			?>
			
		</div>

<!-- Contenu Centre -->
		<div class="contenuPage">
			<div class="titrePage">Mes commandes</div>
			<div id="div_commande_valide" style="display:<?=$affichage_div_valide?>;">Votre commande a &eacute;t&eacute; valid&eacute;e. Elle sera trait&eacute;e dans les plus brefs d&eacute;lais.</div>
			<div id="div_commande_annule" style="display:<?=$affichage_div_annule?>;">Votre commande a &eacute;t&eacute; annul&eacute;e.</div>
			<div>
				<div class="commande">
					<h3>Commandes en cours de traitement</h3>
					<?
					// On a des commandes en cours
					if ( !empty( $liste_commande_en_cours ) ) {
						?>
						<table border="0">
						<tr>
							<td width="150"><b>Date</b></td>
							<td width="150"><b>Montant</b></td>
							<td width="180"><b>Etat</b></td>
							<td width="170">&nbsp;</td>
						</tr>
						<?
						$cpt = 1;
						foreach($liste_commande_en_cours as $_commande) {
							$etat->load( $_commande->num_etat );
							$couleur = ( ( $cpt % 2 ) == 1 ) ? "#DBDBD4" : "#979787";
							?>
							<tr>
								<td bgcolor="<?=$couleur?>">Le <?=traitement_date_affiche( $_commande->date_creation )?></td>
								<td bgcolor="<?=$couleur?>"><?=$_commande->prix?>€</td>
								<td bgcolor="<?=$couleur?>"><?=utf8_encode( $etat->texte )?></td>
								<td bgcolor="<?=$couleur?>" align="right"><a class="iframe" href="detail-commande-<?=$_commande->num_commande?>.html">Voir le détail</a>&nbsp;</td>
							</tr>
							<?
							$cpt++;
						}
						?>
						</table>
						<?
					}
					else
						echo "Aucune commande en cours...";
					?>
				</div>

				<div class="commande">
					<h3>Commandes passées</h3>
					<?
					// On a des commandes en cours
					if ( !empty( $historique ) ) {
						?>
						<table border="0">
						<tr>
							<td width="150"><b>Date</b></td>
							<td width="150"><b>Montant</b></td>
							<td width="180"><b>Etat</b></td>
							<td width="170">&nbsp;</td>
						</tr>
						<?
						$cpt = 1;
						foreach($historique as $_commande) {
							$etat->load( $_commande->num_etat );
							$couleur = ( ( $cpt % 2 ) == 1 ) ? "#DBDBD4" : "#979787";
							?>
							<tr>
								<td bgcolor="<?=$couleur?>">&nbsp;Le <?=traitement_date_affiche( $_commande->date_creation )?></td>
								<td bgcolor="<?=$couleur?>"><?=$_commande->prix?>€</td>
								<td bgcolor="<?=$couleur?>"><?=utf8_encode( $etat->texte )?></td>
								<td bgcolor="<?=$couleur?>" align="right"><a class="iframe" href="detail-commande-<?=$_commande->num_commande?>.html">Voir le détail</a>&nbsp;</td>
							</tr>
							<?
							$cpt++;
						}
						?>
						</table>
						<?
					}
					else
						echo "Aucune commande passée.";
					?>
				</div>
			</div>
		</div>
	</div>

<!-- Footer -->
	<? include_once("include/footer.php"); ?>
	
</div>
</body>
</html>
<? include('./include_connexion/connexion_site_off.php'); ?>