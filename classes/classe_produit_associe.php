<?
class produit_associe {
	var $num_produit_associe = 0;
	var $nom = '';
	
	// Charge une catégorie grâce à son num_produit_associe
	function load($num_produit_associe=0) {
		if ($num_produit_associe == 0) return false;

		$requete = "SELECT * FROM produit_associe";
		$requete .= " WHERE num_produit_associe = '" . addslashes( $num_produit_associe ) . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;

		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;

		$this->num_produit_associe = $data["num_produit_associe"];
		$this->nom = $data["nom"];
		
		return true;
	}
	
	// Ajoute une catégorie d'images
	private function ajouter() {
		$requete = "INSERT INTO produit_associe(nom) VALUES(";
		$requete .= "'" . $this->traiterNom( $this->nom ) . "')";
		//echo $requete . "<br><br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? mysql_insert_id() : false;
	}
	
	// Modifie une catégorie d'images
	private function modifier() {
		$requete = "UPDATE produit_associe SET";
		$requete .= " nom = '" . $this->traiterNom( $this->nom ) . "'";
		$requete .= " WHERE num_produit_associe = " . $this->num_produit_associe;
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? $this->num_produit_associe : false;
	}
	
	// Supprime une catégorie d'images
	function supprimer() {
		$requete = "DELETE FROM produit_associe WHERE num_produit_associe = " . $this->num_produit_associe;
		//echo $requete . "<br>";
		mysql_query($requete);
	}
	
	// Interface entre le formulaire et la base
	function gererDonnee( $post=array(), $file=array() ) {
		
		// Tentative de chargement de la catégorie
		$this->load( intval( $post["num_produit_associe"] ) );
		
		$this->nom = utf8_decode( $post["nom"] );
		
		return ( intval($this->num_produit_associe) == 0 ) ? $this->ajouter() : $retour = $this->modifier();
	}
	
	// Fonction destinée à supprimer les caractères spéciaux des nom des catégories
	function traiterNom( $texte='' ) {
		$texte = addslashes( $texte );
		   
		return $texte;
	}
	
	// Retourne la liste des catégories
	function getListe( $liste='', $liste_exception='' ) {
		$categorie = new produit_associe();
		
		$requete = "SELECT * FROM produit_associe";
		$requete .= " WHERE num_produit_associe > 0";
		if ( $liste != '' ) $requete .= " AND num_produit_associe IN (" . $liste . ")";
		if ( $liste_exception != '' ) $requete .= " AND num_produit_associe NOT IN (" . $liste_exception . ")";
		$requete .= " ORDER BY nom ASC";
		//echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				
				// Tentative de chargement du commande
				if ( $categorie->load( $data["num_produit_associe"] ) ) {
					$tableau[$i] = new produit_associe();
					
					$tableau[$i]->num_produit_associe = $categorie->num_produit_associe;
					$tableau[$i]->nom = $categorie->nom;
					
					$i++;
				}
			}
		}
		
		return $tableau;
	}
}
?>