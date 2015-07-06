<?
class produit_produit_associe {
	var $num_produit = 0;
	var $num_produit_associe = 0;
	var $num_animal = 0;
	
	// Charge une catégorie grâce à son num_produit_associe
	function load( $num_produit=0, $num_produit_associe=0, $num_animal=0 ) {
		$requete = "SELECT * FROM produit_produit_associe";
		$requete .= " WHERE num_produit = '" . addslashes( $num_produit ) . "'";
		$requete .= " AND num_produit_associe = '" . addslashes( $num_produit_associe ) . "'";
		$requete .= " AND num_animal = '" . addslashes( $num_animal ) . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;

		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;

		$this->num_produit = $data["num_produit"];
		$this->num_produit_associe = $data["num_produit_associe"];
		$this->num_animal = $data["num_animal"];
		
		return true;
	}
	
	// Ajoute une catégorie d'images
	private function ajouter() {
		$requete = "INSERT INTO produit_produit_associe(num_produit, num_produit_associe, num_animal) VALUES(";
		$requete .= "'" . $this->traiterChiffre( $this->num_produit ) . "', '" . $this->traiterChiffre( $this->num_produit_associe ) . "', ";
		$requete .= "'" . $this->traiterChiffre( $this->num_animal ) . "')";
		//echo $requete . "<br><br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? $this->num_produit : false;
	}
	
	// Supprime une catégorie d'images
	function supprimer( $num_produit=0, $num_produit_associe=0, $num_animal=0 ) {
		$num_produit = intval( $num_produit );
		$num_produit_associe = intval( $num_produit_associe );
		$num_animal = intval( $num_animal );
		
		if ( ($num_produit == 0) && ($num_produit_associe == 0)  && ($num_animal == 0) ) return false;
		
		$requete = "DELETE FROM produit_produit_associe";
		if ( $num_produit > 0) $requete .= " WHERE num_produit = " . $num_produit;
		else if ( $num_produit_associe > 0) $requete .= " WHERE num_produit_associe = " . $num_produit_associe;
		else $requete .= " WHERE num_animal = " . $num_animal;
		//echo $requete . "<br>";
		mysql_query($requete);
	}
	
	// Interface entre le formulaire et la base
	function gererDonnee( $post=array() ) {
		$num_produit = intval( $post["num_produit"] );
		$num_produit_associe = intval( $post["num_produit_associe"] );
		$num_animal = intval( $post["num_animal"] );
		
		// Enregistrer les nouveaux produits associés sélectionnés
		if ( ( $num_produit > 0 ) || ( $num_animal > 0 ) ) {
			$this->num_produit = intval( $num_produit );
			$this->num_animal = intval( $num_animal );
			
			if ($post["toBox"] != "") {
				foreach($post["toBox"] AS $id) {
					$this->num_produit_associe = $id;
					$this->ajouter();
				}
			}
		}
	}
	
	// Fonction destinée à supprimer les caractères spéciaux des nom des catégories
	function traiterChiffre( $texte='' ) {
		$texte = intval( $texte );
		   
		return $texte;
	}
	
	// Retourne la liste des catégories
	function getListe( $num_produit=0, $num_produit_associe=0 , $num_animal=0 ) {
		$produit_produit_associe = new produit_produit_associe();
		
		$requete = "SELECT * FROM produit_produit_associe";
		$requete .= " WHERE num_produit_associe > 0";
		if ( $num_produit > 0 ) $requete .= " AND num_produit = '" . $num_produit . "'";
		if ( $num_produit_associe > 0 ) $requete .= " AND num_produit_associe = '" . $num_produit_associe . "'";
		if ( $num_animal > 0 ) $requete .= " AND num_animal = '" . $num_animal . "'";
		$requete .= " ORDER BY num_produit ASC";
		//echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				//echo "ici : " . $data["num_produit"] . ", " . $data["num_produit_associe"] . ", " . $data["num_animal"] . "<br>";
				
				// Tentative de chargement du commande
				if ( $produit_produit_associe->load( $data["num_produit"], $data["num_produit_associe"], $data["num_animal"]  ) ) {
					$tableau[$i] = new produit_produit_associe();
					
					$tableau[$i]->num_produit = $produit_produit_associe->num_produit;
					$tableau[$i]->num_produit_associe = $produit_produit_associe->num_produit_associe;
					$tableau[$i]->num_animal = $produit_produit_associe->num_animal;
					
					$i++;
				}
			}
		}
		
		return $tableau;
	}
}
?>