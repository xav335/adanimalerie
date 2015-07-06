<?
	function selectionner_menu($menu, $valeur) {
		if ($menu == $valeur)
			return "amenuleftselected";
		else
			return "amenuleft";
	}
?>
	<td width="150" style="vertical-align:top;padding:0 1px 10px 1px;border-right:solid 1px #A9BFE7;background:#D2E3F3;">
		<b class=groupmenu>Gestion des produits</b>
		<a href="<?=$url_absolue?>/produit/liste_categorie.php" class="<?=selectionner_menu($menu, 'produit categorie')?>">Cat&eacute;gories de produits</a>
		<a href="<?=$url_absolue?>/produit/liste.php" class="<?=selectionner_menu($menu, 'produit')?>">Liste des produits</a>
		<a href="<?=$url_absolue?>/produit/ajout.php" class="<?=selectionner_menu($menu, 'produit ajout')?>">Ajouter / Modifier</a>
		<br>
		
		<b class=groupmenu>Gestion des animaux</b>
		<a href="<?=$url_absolue?>/animal/liste_categorie.php" class="<?=selectionner_menu($menu, 'animal categorie')?>">Cat&eacute;gories d'animaux</a>
		<a href="<?=$url_absolue?>/animal/liste.php" class="<?=selectionner_menu($menu, 'animal')?>">Liste des animaux</a>
		<a href="<?=$url_absolue?>/animal/ajout.php" class="<?=selectionner_menu($menu, 'animal ajout')?>">Ajouter / Modifier</a>
		<br>
		
		<b class=groupmenu>Produits associ&eacute;s</b>
		<a href="<?=$url_absolue?>/produit_associe/liste.php" class="<?=selectionner_menu($menu, 'produit associe')?>">Liste des produits associ&eacute;s</a>
		<br>
		
		<b class=groupmenu>Gestion des actualit&eacute;s</b>
		<a href="<?=$url_absolue?>/actualite/liste.php" class="<?=selectionner_menu($menu, 'actu')?>">Liste des actualit&eacute;s</a>
		<a href="<?=$url_absolue?>/actualite/ajout.php" class="<?=selectionner_menu($menu, 'actu ajout')?>">Ajouter / Modifier</a>
		<br>
		
		<b class=groupmenu>Gestion des promotions</b>
		<a href="<?=$url_absolue?>/promotion/liste.php" class="<?=selectionner_menu($menu, 'promotion')?>">Liste des promotions</a>
		<a href="<?=$url_absolue?>/promotion/ajout.php" class="<?=selectionner_menu($menu, 'promotion ajout')?>">Ajouter / Modifier</a>
		<br>
		
		<b class=groupmenu>Gestion des newsletters</b>
		<a href="<?=$url_absolue?>/newsletter/liste.php" class="<?=selectionner_menu($menu, 'newsletter')?>">Liste des commandes</a>
		<a href="<?=$url_absolue?>/newsletter/ajout.php" class="<?=selectionner_menu($menu, 'newsletter ajout')?>">Ajouter / Modifier</a>
		<br>
		
		<b class=groupmenu>Gestion des clients</b>
		<a href="<?=$url_absolue?>/client/liste_client.php" class="<?=selectionner_menu($menu, 'client')?>">Liste des clients</a>
		<a href="<?=$url_absolue?>/client/ajout_client.php" class="<?=selectionner_menu($menu, 'client ajout')?>">Ajouter / Modifier</a>
		<br>
		
		<b class=groupmenu>Gestion des commandes</b>
		<a href="<?=$url_absolue?>/commande/liste.php" class="<?=selectionner_menu($menu, 'commande')?>">Liste des commandes</a>
		<br>
		
		<b class=groupmenu>Administration</b>
		<a href="<?=$url_absolue?>/compte/mon_compte.php" class="<?=selectionner_menu($menu_compte, 'mon compte')?>">Mon compte</a>
		<a href="<?=$url_site?>" class="amenuleft" target="_blank">Acc&egrave;s au site</a>
		<a href="<?=$url_absolue?>/compte/deconnexion.php" class="amenuleft">D&eacute;connexion</a>
	</td>