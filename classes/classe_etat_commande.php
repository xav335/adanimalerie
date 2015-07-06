<?
class etat {
	var $num_etat = 0;
	var $texte = '';
	var $ordre_affichage = '';
	
	// Charge un attaché audiovisuel
	function load($num_etat=0) {
		$num_etat = intval($num_etat);
		if ($num_etat <= 0) return false;
		
		$requete = "SELECT * FROM commande_etat";
		$requete .= " WHERE num_etat = '" . $num_etat . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		$this->num_etat = $data["num_etat"];
		//echo "--> ID : " . $this->num_etat . "<br>";
		$this->texte = $data["texte"];
		$this->ordre_affichage = $data["ordre_affichage"];
		
		return true;
	}
	
	// Retourne la liste
	function getListe() {
		$etat = new etat();
		
		$requete = "SELECT * FROM commande_etat";
		$requete .= " ORDER BY ordre_affichage ASC";
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				
				// Tentative de chargement
				if ( $etat->load( $data["num_etat"] ) ) {
					$tableau[$i] = new etat();
					
					$tableau[$i]->num_etat = $etat->num_etat;
					$tableau[$i]->texte = $etat->texte;
					$tableau[$i]->ordre_affichage = $etat->ordre_affichage;
					
					$i++;
				}
			}
		}
		
		return $tableau;
	}
}
?>