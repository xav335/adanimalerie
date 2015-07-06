<?
class produit {
	var $num_produit = 0;
	var $num_produit_categorie = 0;
	var $nom = '';
	var $resume = '';
	var $texte = '';
	var $info = '';
	var $prix = '';
	var $prix_promo = 0;
	var $coup_de_coeur = '';
	
	// Charge une catégorie grâce à son num_produit
	function load($num_produit=0) {
		if ($num_produit == 0) return false;

		$requete = "SELECT * FROM produit";
		$requete .= " WHERE num_produit = '" . addslashes( $num_produit ) . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;

		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;

		$this->num_produit = $data["num_produit"];
		$this->num_produit_categorie = $data["num_produit_categorie"];
		$this->nom = $data["nom"];
		$this->resume = $data["resume"];
		$this->texte = $data["texte"];
		$this->info = $data["info"];
		$this->prix = $data["prix"];
		$this->prix_promo = $data["prix_promo"];
		$this->coup_de_coeur = $data["coup_de_coeur"];
		
		return true;
	}
	
	// Ajoute une catégorie d'images
	private function ajouter() {
		$requete = "INSERT INTO produit(num_produit_categorie, nom, resume, texte, info, prix, prix_promo, coup_de_coeur) VALUES(";
		$requete .= $this->num_produit_categorie . ", '" . $this->traiterNom( $this->nom ) . "', '" . $this->traiterNom( $this->resume ) . "', '" . $this->traiterNom( $this->texte ) . "', '" . $this->traiterNom( $this->info ) . "', ";
		$requete .= "'" . $this->traiterNom( $this->prix ) . "', '" . $this->traiterNom( $this->prix_promo ) . "', '" . $this->traiterNom( $this->coup_de_coeur ) . "')";
		//echo $requete . "<br><br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? mysql_insert_id() : false;
	}
	
	// Modifie une catégorie d'images
	private function modifier() {
		$requete = "UPDATE produit SET";
		$requete .= " num_produit_categorie = " . $this->num_produit_categorie . ",";
		$requete .= " nom = '" . $this->traiterNom( $this->nom ) . "',";
		$requete .= " resume = '" . $this->traiterNom( $this->resume ) . "',";
		$requete .= " texte = '" . $this->traiterNom( $this->texte ) . "',";
		$requete .= " info = '" . $this->traiterNom( $this->info ) . "',";
		$requete .= " prix = '" . $this->traiterNom( $this->prix ) . "',";
		$requete .= " prix_promo = '" . $this->traiterNom( $this->prix_promo ) . "',";
		$requete .= " coup_de_coeur = '" . $this->traiterNom( $this->coup_de_coeur ) . "'";
		$requete .= " WHERE num_produit = " . $this->num_produit;
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? $this->num_produit : false;
	}
	
	// Supprime une catégorie d'images
	function supprimer() {
		$produit_produit_associe = new produit_produit_associe();
		$produit_image = new produit_image();
		
		// Suppression des associations déjà existantes
		$produit_produit_associe->supprimer( $this->num_produit, 0 );
		
		// Suppression des images du produit
		$liste_image = $produit_image->getListe( $this->num_produit );
		if ( !empty( $liste_image ) ) {
			foreach( $liste_image as $_image ) {
				$temp = new produit_image();
				if ( $temp->load( $_image->num_produit_image ) ) $temp->supprimer();
			}
		}
		
		$requete = "DELETE FROM produit WHERE num_produit = " . $this->num_produit;
		//echo $requete . "<br>";
		mysql_query($requete);
	}
	
	// Interface entre le formulaire et la base
	function gererDonnee( $post=array(), $file=array() ) {
		
		// Tentative de chargement de la catégorie
		$this->load( intval( $post["num_produit"] ) );
		
		$this->num_produit_categorie = $post["num_produit_categorie"];
		$this->nom = utf8_decode( $post["nom"] );
		$this->resume = utf8_decode( $post["resume"] );
		$this->texte = utf8_decode( $post["texte"] );
		$this->info = utf8_decode( $post["info"] );
		$this->prix = utf8_decode( $post["prix"] );
		$this->prix_promo = utf8_decode( $post["prix_promo"] );
		$this->coup_de_coeur = $post["coup_de_coeur"];
		
		return ( intval($this->num_produit) == 0 ) ? $this->ajouter() : $retour = $this->modifier();
	}
	
	// Fonction destinée à supprimer les caractères spéciaux des nom des catégories
	function traiterNom( $texte='' ) {
		$texte = addslashes( $texte );
		   
		return $texte;
	}
	
	// Retourne la liste des catégories
	function getListe( $num_produit_categorie=0, $liste_categorie=0 ) {
		$categorie = new produit();
		
		$requete = "SELECT * FROM produit";
		$requete .= " WHERE num_produit > 0";
		if ( intval( $num_produit_categorie ) > 0 ) $requete .= " AND num_produit_categorie = " . intval( $num_produit_categorie );
		if ( $liste_categorie != "" ) $requete .= " AND num_produit_categorie IN ( " . $liste_categorie . " )";
		$requete .= " ORDER BY nom ASC";
		//echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				
				// Tentative de chargement du commande
				if ( $categorie->load( $data["num_produit"] ) ) {
					$tableau[$i] = new produit();
					
					$tableau[$i]->num_produit = $categorie->num_produit;
					$tableau[$i]->num_produit_categorie = $categorie->num_produit_categorie;
					$tableau[$i]->nom = $categorie->nom;
					$tableau[$i]->resume = $categorie->resume;
					$tableau[$i]->texte = $categorie->texte;
					$tableau[$i]->info = $categorie->info;
					$tableau[$i]->prix = $categorie->prix;
					$tableau[$i]->prix_promo = $categorie->prix_promo;
					$tableau[$i]->coup_de_coeur = $categorie->coup_de_coeur;
					
					$i++;
				}
			}
		}
		
		return $tableau;
	}
	
	// Retourne une image associée au produit en cours
	function getImage() {
		$produit_image = new produit_image();
		
		$liste = $produit_image->getListe( $this->num_produit );
		
		if ( !empty( $liste ) ) {
			return "/images/produit/" . $liste[0]->fic_image;
		}
	}
	
	// Retourne la liste des images cliquables
	function getListeImage() {
		$produit_image = new produit_image();
		$liste_lien = "";
		
		$liste = $produit_image->getListe( $this->num_produit );
		
		if ( !empty( $liste ) ) {
			foreach( $liste as $_image ) {
				//return "/images/produit/" . $liste[0]->fic_image;
				
				$liste_lien .= "<div style='float:left; margin-right:3px; margin-bottom:3px;'>";
				$liste_lien .= "<a href='/images/produit/" . $_image->fic_image . "' rel='groupe_image'><img src='/images/produit/" . $_image->fic_image . "' width='80'></a> ";
				$liste_lien .= "</div>";
			}
		}
		
		return $liste_lien;
	}
}
?>