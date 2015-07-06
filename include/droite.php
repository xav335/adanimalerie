<div class="contenuGauche">
	
	<?
	// Gestion des promotions
	$promotion = new promotion();
	
	$liste_promotion = $promotion->getListe( 1 );
	
	if ( ! empty( $liste_promotion ) ) {
		$display_div_promo = "block";
		$_promotion = $liste_promotion[0];
	}
	else $display_div_promo = "none";
	?>
	
	<div class="promo" style="display:<?=$display_div_promo?>;">
		<div class="titre"><?=stripslashes( $_promotion->titre )?></div>
		<div class="photoPromo">
			<img src="images/picto_promo.png" alt="" title="" style="position:absolute;border:0;margin:0;" />
			<img src="images/promo.jpg" alt="" title="" />
		</div>
		<span class="titrepromo"><?=stripslashes( $_promotion->sous_titre )?></span><br/>
		<span class="pourcentage"><?=stripslashes( $_promotion->reduction )?></span> <?=stripslashes( $_promotion->texte )?>
	</div>
	
	<div class="show">
		<img src="images/picto_show.png" alt="" title="" style="border:0;" /> notre show<br/>
		<a id="play_flash" href="http://www.adanimalerie.com/flash/VideoAdAnimalerie.swf" title="AD animarie, 35 rue Fondaudège Bordeaux"><img src="images/show.jpg" alt="" title="" /></a>
	</div>
	
	<div class="contacteznous">
		<img src="images/picto_courrier.png" alt="" title="" /> <span class="titre">contactez<br/>nous</span><br/><br/>
		<span class="vert">UNE QUESTION ?</span><br/>
		ÉCRIVEZ-NOUS<br/>
		<a href="mailto:contact@adanimalerie.com">contact@adanimalerie.com</a><br/><br/>
		<span class="titreparagraphe">Horaires</span><br/>
		Ouvert du Lundi au Samedi, sauf le Mercredi (jour de fermeture) de 9h30 à 12h30<br/>
		et de 13h30 à 19h30<br/><br/>
		<span class="titreparagraphe">Venez nous voir !</span><br/>
		35 rue Fondaudège à Bordeaux<br/>
		Tél. 05 56 44 67 88<br/>
		Fax : 05 56 51 72 01<br/>
		<span class="urgence">Numéro d'urgence :<br/>
		06 75 95 05 46</span>
	</div>
</div>