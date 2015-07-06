<? require_once('./classes/config.php'); ?>
<? require_once('./classes/classes.php'); ?>
<? include('./include_connexion/connexion_site_on.php'); ?>
<? require_once('./classes/start_session.php'); ?>
<?
	// Récupération des informations passées en paramètres
	$num_commande = $_GET["nc"];
	
	//echo "--- mon_action : " . $mon_action . "<br>";

	$etat = new etat();
	$commande = new commande();
	$commande_produit = new commande_produit();
	
	// Chargement de la commande
	$commande->load( $num_commande );
	
	// Etat de la commande
	$etat->load( $commande->num_etat );
	
	// Détail du panier
	$liste = $commande_produit->getListe( $num_commande, 0 );
	
	// Etat du paiement
	if ( $commande->num_etat_paiement == 0 ) $paiement = "<font color='#CC3300'>Annulé</font>";
	else if ( $commande->num_etat_paiement == 1 ) $paiement = "<font color='#EAA327'>En cours</font>";
	else $paiement = "<font color='green'>Validé</font>";
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

	<div class="header"><img src="images/header.jpg" alt="" title="AD animalerie - Votre animalerie à Bordeaux" /></div>
	
	<div class="contenu">
		<div class="titrePage"><center>Commande nº<?=$num_commande?></center></div>
		<div>
			<div class="detail_commande">
				<h3>Informations principales</h3>
				<p>
					- Commande passée le : <?=traitement_date_affiche( $commande->date_creation )?><br>
					- Montant : <?=$commande->prix?>€<br>
					- Etat de la commande : <?=utf8_encode( $etat->texte )?><br>
					- Etat du paiement : <b><?=$paiement?></b>
				</p>
			</div>
			
			<div class="detail_commande">
				<h3>Détail du panier</h3>
				<?
				if ( !empty( $liste ) ) {
					?>
					<table border="0">
					<tr>
						<td width="720">Titre</td>
						<td width="70" align="center">Quantité</td>
						<td width="70" align="center">prix</td>
					</tr>
					<?
					$cpt = 1;
					foreach( $liste as $_panier ) {
						$couleur = ( ( $cpt % 2 ) == 0 ) ? "#DBDBD4" : "#979787";
						?>
						<tr>
							<td bgcolor="<?=$couleur?>"><?=utf8_encode( $_panier->nom )?></td>
							<td bgcolor="<?=$couleur?>" align="center"><?=utf8_encode( $_panier->quantite )?></td>
							<td bgcolor="<?=$couleur?>" align="center"><?=$_panier->prix_unitaire?>€</td>
						</tr>
						<?
						$cpt++;
					}
					?>
					</table>
					<?
				}
				?>
			</div>
			<p>&nbsp;</p>
		</div>
	</div>
</div>
</body>
</html>
<? include('./include_connexion/connexion_site_off.php'); ?>