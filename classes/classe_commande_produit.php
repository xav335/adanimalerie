<?
class commande_produit {
	var $num_commande = 0;
	var $num_produit = 0;
	var $nom = 0;
	var $quantite = 0;
	var $prix_unitaire = 0;
	
	// Charge une catégorie
	function load( $num_commande=0, $num_produit=0 ) {
		$requete = "SELECT * FROM commande_produit";
		$requete .= " WHERE num_commande = '" . addslashes( $num_commande ) . "'";
		$requete .= " AND num_produit = '" . addslashes( $num_produit ) . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;

		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;

		$this->num_commande = $data["num_commande"];
		$this->num_produit = $data["num_produit"];
		$this->nom = $data["nom"];
		$this->quantite = $data["quantite"];
		$this->prix_unitaire = $data["prix_unitaire"];
		
		return true;
	}
	
	// Ajoute une catégorie d'images
	private function ajouter() {
		$requete = "INSERT INTO commande_produit(num_commande, num_produit, nom, quantite, prix_unitaire) VALUES(";
		$requete .= "'" . $this->traiterChiffre( $this->num_commande ) . "', '" . $this->traiterChiffre( $this->num_produit ) . "', '" . $this->traiterNom( $this->nom ) . "', ";
		$requete .= "'" . $this->traiterChiffre( $this->quantite ) . "', '" . $this->prix_unitaire . "')";
		//echo $requete . "<br><br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? $this->num_commande : false;
	}
	
	// Supprime le détail d'une commande
	function supprimer( $num_commande=0, $num_produit=0 ) {
		$num_commande = intval( $num_commande );
		$num_produit = intval( $num_produit );
		
		if ( ($num_commande == 0) && ($num_produit == 0) ) return false;
		
		$requete = "DELETE FROM commande_produit";
		if ( $num_commande > 0) $requete .= " WHERE num_commande = " . $num_commande;
		else $requete .= " WHERE num_produit = " . $num_produit;
		//echo $requete . "<br>";
		mysql_query($requete);
	}
	
	// Interface entre le formulaire et la base
	function gererDonnees( $post=array() ) {
		$this->num_commande = intval( $post["num_commande"] );
		$this->num_produit = intval( $post["num_produit"] );
		$this->nom =  $post["nom"];
		$this->quantite = intval( $post["quantite"] );
		$this->prix_unitaire = $post["prix_unitaire"];
		$this->ajouter();
	}
	
	// Fonction destinée à supprimer les caractères spéciaux des nom des catégories
	function traiterNom( $texte='' ) {
		$texte = addslashes( $texte );
		   
		return $texte;
	}
	
	// Fonction destinée à supprimer les caractères spéciaux des nom des catégories
	function traiterChiffre( $texte='' ) {
		$texte = intval( $texte );
		   
		return $texte;
	}
	
	// Retourne la liste des catégories
	function getListe( $num_commande=0, $num_produit=0 ) {
		$commande_produit = new commande_produit();
		
		$requete = "SELECT * FROM commande_produit";
		$requete .= " WHERE num_produit > 0";
		if ( $num_commande > 0 ) $requete .= " AND num_commande = '" . $num_commande . "'";
		if ( $num_produit > 0 ) $requete .= " AND num_produit = '" . $num_produit . "'";
		$requete .= " ORDER BY num_commande ASC";
		//echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				//echo "ici : " . $data["num_commande"] . ", " . $data["num_produit"] . "<br>";
				
				// Tentative de chargement du commande
				if ( $commande_produit->load( $data["num_commande"], $data["num_produit"] ) ) {
					$tableau[$i] = new commande_produit();
					
					$tableau[$i]->num_commande = $commande_produit->num_commande;
					$tableau[$i]->num_produit = $commande_produit->num_produit;
					$tableau[$i]->nom = $commande_produit->nom;
					$tableau[$i]->quantite = $commande_produit->quantite;
					$tableau[$i]->prix_unitaire = $commande_produit->prix_unitaire;
					
					$i++;
				}
			}
		}
		
		return $tableau;
	}
}
?>