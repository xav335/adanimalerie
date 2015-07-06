<?
	function afficher_pagination($page_affichage, $parametre_url, $nbre_pages, $nombre_page_initial, $encadrement, $num_page, $precedent, $suivant) {
		$debug = false;
		if ( $debug ) echo "Dans afficher_pagination()<br>";
		if ( $debug ) echo "page_affichage : " . $page_affichage . "<br>";
		if ( $debug ) echo "nbre_pages : " . $nbre_pages . "<br>";
		if ( $debug ) echo "nombre_page_initial : " . $nombre_page_initial . "<br>";
		if ( $debug ) echo "encadrement : " . $encadrement . "<br>";
		if ( $debug ) echo "page  : " . $num_page . "<br>";
		if ( $debug ) echo "---------------<br>";
		
		if (($num_page >= ($nombre_page_initial - $encadrement)) && ($num_page <= ($nbre_pages - $nombre_page_initial + $encadrement))) {
			if ( $debug ) echo "--- Changement ---<br>";
			depaser_seuil($page_affichage, $parametre_url, $nbre_pages, $nombre_page_initial, $encadrement, $num_page, $precedent, $suivant);
		}
		
		else {
		
			// On affiche un lien vers les dernières pages
			if ($nbre_pages > $nombre_page_initial) {
				
				// On affiche les liens vers les 2 premières pages
				$liste_lien = "";
				if ($num_page >= ($nombre_page_initial + 2)) {
					$liste_lien .= "<a href='" . $page_affichage . "-1.html'>1</a>";
					
					if ($num_page > ($nombre_page_initial + 2)) {
						$liste_lien .= "<a href='" . $page_affichage . "-2.html'>2</a>";
						
						if ($num_page > ($nombre_page_initial + 3))
							$liste_lien .= "...";
					}
				}
			}
			
			echo "<div class='pagination'>";
			echo $liste_lien;
			
			// Pour les n premières pages
			if ($num_page <= $nombre_page_initial) {
				//echo "-- 1<br>";
				if ($nbre_pages >= $nombre_page_initial) {
					//echo "-- 2<br>";
					$debut = 1;
					$nombre = $nombre_page_initial;
				}
				else {
					//echo "-- 3<br>";
					$debut = 1;
					$nombre = $nbre_pages;
				}
			}
			
			// Pour les n dernières pages
			else {
				//echo "-- 10<br>";
				if ($nbre_pages >= $nombre_page_initial) {
					//echo "-- 11<br>";
					$debut = $nbre_pages - $nombre_page_initial;
					$nombre = $nbre_pages;
				}
				else {
					//echo "-- 12<br>";
					$debut = 1;
					$nombre = $nbre_pages;
				}
			}
			
			//echo "Debut : " . $debut . "<br>";
			//echo "nombre : " . $nombre . "<br>";
				
			for ($i=$debut; $i<=$nombre; $i++) {
				if ($i == $num_page)
					echo "<span class='courante'>$i</span>";
				else
					echo "<a href='" . $page_affichage . "-$i.html'>$i</a>";
			}
			
			// On affiche un lien vers les dernières pages
			if ($nbre_pages > $nombre_page_initial) {
				$liste_lien = "";
				if ($num_page < ($nbre_pages - $nombre_page_initial)) {
					if ($num_page < ($nbre_pages - $nombre_page_initial - 2))
						$liste_lien .= "...";
						
					if ($num_page <= ($nbre_pages - $nombre_page_initial - 2))
						$liste_lien .= "<a href='" . $page_affichage . "-" . ($nbre_pages-1) . ".html'>" . ($nbre_pages-1) . "</a>";
					
					$liste_lien .= "<a href='" . $page_affichage . "-" . ($nbre_pages) . ".html'>" . ($nbre_pages) . "</a>";
				}
			}
			
			echo $liste_lien;
			echo "</div>";
		}
	}
	
	function depaser_seuil($page_affichage, $parametre_url, $nbre_pages, $nombre_page_initial, $encadrement, $num_page, $precedent, $suivant) {
		$debug = false;
		if ( $debug ) echo "Dans depaser_seuil()<br>";
		if ( $debug ) echo "page_affichage : " . $page_affichage . "<br>";
		if ( $debug ) echo "nombre_page_initial : " . $nombre_page_initial . "<br>";
		if ( $debug ) echo "encadrement : " . $encadrement . "<br>";
		if ( $debug ) echo "page  : " . $num_page . "<br>";
		if ( $debug ) echo "---------------<br>";
		
		echo "<div class='pagination'>";
		
		// On affiche les liens vers les 2 premières pages
		$liste_lien = "";
		if ($num_page >= ($encadrement + 2)) {
			$liste_lien .= "<a href='" . $page_affichage . "-1.html'>1</a>";
			
			if ($num_page > ($encadrement + 2)) {
				$liste_lien .= "<a href='" . $page_affichage . "-2.html'>2</a>";
				
				if ($num_page > ($encadrement + 3))
					$liste_lien .= "...";
			}
		}
		
		echo $liste_lien;
		
		if ($num_page <= $encadrement)
			$debut = 1;
		else
			$debut = $num_page - $encadrement;
			
		if ($num_page >= ($nbre_pages - $encadrement))
			$fin = $nbre_pages;
		else
			$fin = $num_page + $encadrement;
			
		for ($i = $debut; $i <= $fin; $i++) {
			//echo "-- i : " . $i . " --<br>";
			if ($i == $num_page)
				echo "<span class='courante'>$i</span>";
			else
				echo "<a href='" . $page_affichage . "-$i.html'>$i</a>";
		}
		
		$liste_lien = "";
		if ($num_page < ($nbre_pages - $encadrement)) {
			if ($num_page < ($nbre_pages - $encadrement - 2))
				$liste_lien .= "...";
			
			if ($num_page <= ($nbre_pages - $encadrement - 2))
				$liste_lien .= "<a href='" . $page_affichage . "-" . ($nbre_pages-1) . ".html'>" . ($nbre_pages-1) . "</a>";
			
			$liste_lien .= "<a href='" . $page_affichage . "-" . ($nbre_pages) . ".html'>" . ($nbre_pages) . "</a>";
		}
		
		echo $liste_lien;
		echo "</div>";
	}
?>