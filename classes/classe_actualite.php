<?
class actualite {
	var $num_actualite = 0;
	var $titre = '';
	var $resume = '';
	var $texte = '';
	var $date_creation = '';
	
	// Charge une catégorie grâce à son num_actualite
	function load($num_actualite=0) {
		if ($num_actualite == 0) return false;

		$requete = "SELECT * FROM actualite";
		$requete .= " WHERE num_actualite = '" . addslashes( $num_actualite ) . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;

		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;

		$this->num_actualite = $data["num_actualite"];
		$this->titre = $data["titre"];
		$this->resume = $data["resume"];
		$this->texte = $data["texte"];
		$this->date_creation = $data["date_creation"];
		
		return true;
	}
	
	// Ajoute une catégorie d'images
	private function ajouter() {
		$requete = "INSERT INTO actualite(titre, resume, texte, date_creation) VALUES(";
		$requete .= "'" . $this->traiterNom( $this->titre ) . "', '" . $this->traiterNom( $this->resume ) . "', '" . $this->traiterNom( $this->texte ) . "', ";
		$requete .= "'" . $this->date_creation . "')";
		//echo $requete . "<br><br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? mysql_insert_id() : false;
	}
	
	// Modifie une catégorie d'images
	private function modifier() {
		$requete = "UPDATE actualite SET";
		$requete .= " titre = '" . $this->traiterNom( $this->titre ) . "',";
		$requete .= " resume = '" . $this->traiterNom( $this->resume ) . "',";
		$requete .= " texte = '" . $this->traiterNom( $this->texte ) . "',";
		$requete .= " date_creation = '" . $this->date_creation . "'";
		$requete .= " WHERE num_actualite = " . $this->num_actualite;
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? $this->num_actualite : false;
	}
	
	// Supprime une catégorie d'images
	function supprimer() {
		$requete = "DELETE FROM actualite WHERE num_actualite = " . $this->num_actualite;
		//echo $requete . "<br>";
		mysql_query($requete);
	}
	
	// Interface entre le formulaire et la base
	function gererDonnee( $post=array(), $file=array() ) {
		
		// Tentative de chargement de la catégorie
		$this->load( intval( $post["num_actualite"] ) );
		
		$this->titre = utf8_decode( $post["titre"] );
		$this->resume = utf8_decode( $post["resume"] );
		$this->texte = utf8_decode( $post["texte"] );
		$this->date_creation = inserer_date( $post["date_creation"] );
		
		return ( intval($this->num_actualite) == 0 ) ? $this->ajouter() : $retour = $this->modifier();
	}
	
	// Fonction destinée à supprimer les caractères spéciaux des nom des catégories
	function traiterNom( $texte='' ) {
		$texte = addslashes( $texte );
		   
		return $texte;
	}
	
	// Retourne la liste des catégories
	function getListe() {
		$categorie = new actualite();
		
		$requete = "SELECT * FROM actualite";
		$requete .= " WHERE num_actualite > 0";
		$requete .= " ORDER BY titre ASC";
		//echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				
				// Tentative de chargement du commande
				if ( $categorie->load( $data["num_actualite"] ) ) {
					$tableau[$i] = new actualite();
					
					$tableau[$i]->num_actualite = $categorie->num_actualite;
					$tableau[$i]->titre = $categorie->titre;
					$tableau[$i]->resume = $categorie->resume;
					$tableau[$i]->texte = $categorie->texte;
					$tableau[$i]->date_creation = $categorie->date_creation;
					
					$i++;
				}
			}
		}
		
		return $tableau;
	}
}
?>