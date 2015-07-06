<?
class promotion {
	var $num_promotion = 0;
	var $titre = '';
	var $sous_titre = '';
	var $reduction = '';
	var $texte = '';
	var $online = '';
	
	// Charge une catégorie grâce à son num_promotion
	function load($num_promotion=0) {
		if ($num_promotion == 0) return false;

		$requete = "SELECT * FROM promotion";
		$requete .= " WHERE num_promotion = '" . addslashes( $num_promotion ) . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;

		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;

		$this->num_promotion = $data["num_promotion"];
		$this->titre = $data["titre"];
		$this->sous_titre = $data["sous_titre"];
		$this->reduction = $data["reduction"];
		$this->texte = $data["texte"];
		$this->online = $data["online"];
		
		return true;
	}
	
	// Ajoute une catégorie d'images
	private function ajouter() {
		$requete = "INSERT INTO promotion(titre, sous_titre, reduction, texte, online) VALUES(";
		$requete .= "'" . $this->traiterNom( $this->titre ) . "', '" . $this->traiterNom( $this->sous_titre ) . "', '" . $this->traiterNom( $this->reduction ) . "', '" . $this->traiterNom( $this->texte ) . "', ";
		$requete .= "'" . $this->online . "')";
		//echo $requete . "<br><br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? mysql_insert_id() : false;
	}
	
	// Modifie une catégorie d'images
	private function modifier() {
		$requete = "UPDATE promotion SET";
		$requete .= " titre = '" . $this->traiterNom( $this->titre ) . "',";
		$requete .= " sous_titre = '" . $this->traiterNom( $this->sous_titre ) . "',";
		$requete .= " reduction = '" . $this->traiterNom( $this->reduction ) . "',";
		$requete .= " texte = '" . $this->traiterNom( $this->texte ) . "',";
		$requete .= " online = '" . $this->online . "'";
		$requete .= " WHERE num_promotion = " . $this->num_promotion;
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? $this->num_promotion : false;
	}
	
	// Supprime une catégorie d'images
	function supprimer() {
		$requete = "DELETE FROM promotion WHERE num_promotion = " . $this->num_promotion;
		//echo $requete . "<br>";
		mysql_query($requete);
	}
	
	// Interface entre le formulaire et la base
	function gererDonnee( $post=array(), $file=array() ) {
		
		// Tentative de chargement de la catégorie
		$this->load( intval( $post["num_promotion"] ) );
		
		$this->titre = utf8_decode( $post["titre"] );
		$this->sous_titre = utf8_decode( $post["sous_titre"] );
		$this->reduction = utf8_decode( $post["reduction"] );
		$this->texte = utf8_decode( $post["texte"] );
		$this->online = $post["online"];
		
		return ( intval($this->num_promotion) == 0 ) ? $this->ajouter() : $retour = $this->modifier();
	}
	
	// Fonction destinée à supprimer les caractères spéciaux des nom des catégories
	function traiterNom( $texte='' ) {
		$texte = addslashes( $texte );
		   
		return $texte;
	}
	
	// Retourne la liste des catégories
	function getListe( $online='' ) {
		$categorie = new promotion();
		
		$requete = "SELECT * FROM promotion";
		$requete .= " WHERE num_promotion > 0";
		if ( $online != '' ) $requete .= " AND online = '" . $online . "'";
		$requete .= " ORDER BY titre ASC";
		//echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				
				// Tentative de chargement du commande
				if ( $categorie->load( $data["num_promotion"] ) ) {
					$tableau[$i] = new promotion();
					
					$tableau[$i]->num_promotion = $categorie->num_promotion;
					$tableau[$i]->titre = $categorie->titre;
					$tableau[$i]->sous_titre = $categorie->sous_titre;
					$tableau[$i]->reduction = $categorie->reduction;
					$tableau[$i]->texte = $categorie->texte;
					$tableau[$i]->online = $categorie->online;
					
					$i++;
				}
			}
		}
		
		return $tableau;
	}
}
?>