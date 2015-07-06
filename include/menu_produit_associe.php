<?
	$produit_associe_menu = new produit_associe();
	$produit_produit_associe_menu = new produit_produit_associe();
	
	// Un produit est sélectionné
	if ( intval( $num_produit ) > 0 ) {
		$_num = intval( $num_produit );
		$_num_animal = intval( $num_animal );
	}
	else if ( intval( $num_animal ) > 0 ) {
		$_num = intval( $num_produit );
		$_num_animal = intval( $num_animal );
	}
	else {
		$_num = 0;
		$_num_animal = 0;
	}
	
	//echo "--> num_produit : " . $_num . "<br>";
	//echo "--> num_animal : " . $_num_animal . "<br>";
	
	// Liste globale des produits associés
	if ( ( $_num == 0 ) && ( $_num_animal == 0 ) ) {
		$liste_produit_associe_menu = $produit_associe_menu->getListe();
	
		if ( !empty( $liste_produit_associe_menu ) ) {
			echo "<ul>\n";
			foreach( $liste_produit_associe_menu as $_produit_associe ) {
				echo "<li><a href='produit-associe-" . $_produit_associe->num_produit_associe . ".html'>" . stripslashes( utf8_encode( $_produit_associe->nom ) ) . "</a></li>";
			}
			echo "</ul>\n";
		}
	}
	
	// Liste spécifique
	else {
		$liste_produit_associe_menu = $produit_produit_associe_menu->getListe( $_num, 0, $_num_animal );
	
		if ( !empty( $liste_produit_associe_menu ) ) {
			echo "<ul>\n";
			foreach( $liste_produit_associe_menu as $_produit_associe ) {
				$produit_associe_menu->load( $_produit_associe->num_produit_associe );
				echo "<li><a href='produit-associe-" . $_produit_associe->num_produit_associe . ".html'>" . stripslashes( utf8_encode( $produit_associe_menu->nom ) ) . "</a></li>";
			}
			echo "</ul>\n";
		}
	}
?>
<!--<ul>
	<li><a href="">Crapauds</a></li>
	<li><a href="">Grenouilles</a></li>
	<li><a href="">Rainettes</a></li>
	<li><a href="">Tritons</a></li>
	<li><a href="">Aquariophilie</a></li>
	<li><a href="">Eau Froide</a></li>
	<li><a href="">Eau Tropicale</a></li>
	<li><a href="">Furets</a></li>
	<li><a href="">Insectes</a></li>
	<li><a href="">Divers</a></li>
	<li><a href="">Mantes religieuses</a></li>
	<li><a href="">Phasmes</a></li>
	<li><a href="">Reptiles</a></li>
	<li><a href="">Lézards</a></li>
	<li><a href="">Serpents</a></li>
	<li><a href="">Tortues</a></li>
	<li><a href="">Reptiles Alimentations</a></li>
	<li><a href="">Insectes d'alimentation</a></li>
	<li><a href="">Nourriture Congelé</a></li>
	<li><a href="">Rongeurs</a></li>
	<li><a href="">Chinchillas</a></li>
	<li><a href="">Cochons d'Inde</a></li>
	<li><a href="">Degue Du Chili</a></li>
	<li><a href="">Ecureuil</a></li>
	<li><a href="">Gerbilles</a></li>
	<li><a href="">Hamsters</a></li>
	<li><a href="">Lapins Nains</a></li>
	<li><a href="">Rats</a></li>
	<li><a href="">Souris</a></li>
</ul>-->
