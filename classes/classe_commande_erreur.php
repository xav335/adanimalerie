<?
class commande_erreur {
	var $num_commande_erreur = 0;
	var $num_commande = 0;
	var $texte = '';
	var $date_creation = '';
	
	// Charge une commande
	function load($num_commande_erreur=0) {
		$num_commande_erreur = intval($num_commande_erreur);
		if ($num_commande_erreur <= 0) return false;
		
		$requete = "SELECT * FROM commande_erreur";
		$requete .= " WHERE num_commande_erreur = '" . $num_commande_erreur . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		$this->num_commande_erreur = $data["num_commande_erreur"];
		//echo "--> ID : " . $this->num_commande_erreur . "<br>";
		$this->num_commande = $data["num_commande"];
		$this->texte = $data["texte"];
		$this->date_creation = $data["date_creation"];
		
		return true;
	}
	
	// Ajoute une erreur
	function ajouter() {
		$requete = "INSERT INTO commande_erreur(num_commande, texte, date_creation) VALUES(";
		$requete .= "'" . $this->traiter_champ( $this->num_commande ) . "', ";
		$requete .= "'" . $this->traiter_champ( $this->texte ) . "', '" . $this->traiter_champ( $this->date_creation ) . "')";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? mysql_insert_id() : false;
	}
	
	// Interface entre les formulaire et la base
	function gererDonnees( $post=array() ) {
		$this->num_commande = utf8_decode( $post["num_commande"] );
		$this->texte = ( $post["texte"] );
		$this->date_creation = date("Y-m-d");
		return $this->ajouter();
	}
	
	function traiter_champ($texte='') {
		$texte = str_replace("\"", "", $texte);
		//$texte = utf8_decode( $texte );
		$texte = addslashes( $texte );
		
		return $texte;
	}
	
	function traiter_champ_affichage( $texte='' ) {
		$texte = stripslashes( $texte );
		$texte = utf8_encode( $texte );
		
		return $texte;
	}
	
	// Retourne la liste des commandes
	function getListe( $num_commande=0, $liste_exclusion='', $tri='commande_erreur.date_creation', $ordre='ASC') {
		$commande = new commande();
		
		if ( $tri == "" ) $tri = "commande.date_creation";
		if ( $ordre == "" ) $ordre = "ASC";
		
		$requete = "SELECT * FROM commande_erreur";
		$requete .= " INNER JOIN client ON client.num_commande = commande.num_commande";
		$requete .= " WHERE num_commande_erreur > 0";
		
		if ( intval( $num_commande ) > 0 ) $requete .= " AND commande.num_commande = '" . $num_commande . "'";
		if ( $liste_exclusion != "" ) $requete .= " AND commande.num_commande_erreur NOT IN (" . $liste_exclusion . ")";
		if ( $supprime != "" ) $requete .= " AND supprime = " . $supprime;
		$requete .= " ORDER BY " . $tri . " " . $ordre;
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau
		$tableau_commande = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				
				// Tentative de chargement
				if ( $commande->load( $data["num_commande_erreur"] ) ) {
					//echo "-->" . $this->num_commande . "<br>";
					$tableau_commande[$i] = new commande();
					
					$tableau_commande[$i]->num_commande_erreur = $commande->num_commande_erreur;
					$tableau_commande[$i]->num_commande = $commande->num_commande;
					$tableau_commande[$i]->texte = $commande->texte;
					$tableau_commande[$i]->date_creation = $commande->date_creation;
					
					$i++;
				}
			}
		}
		
		return $tableau_commande;
	}
}
?>