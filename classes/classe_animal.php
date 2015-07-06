<?
class animal {
	var $num_animal = 0;
	var $num_animal_categorie = 0;
	var $nom = '';
	var $resume = '';
	var $texte = '';
	
	// Charge une catégorie grâce à son num_animal
	function load($num_animal=0) {
		if ($num_animal == 0) return false;

		$requete = "SELECT * FROM animal";
		$requete .= " WHERE num_animal = '" . addslashes( $num_animal ) . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;

		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;

		$this->num_animal = $data["num_animal"];
		$this->num_animal_categorie = $data["num_animal_categorie"];
		$this->nom = $data["nom"];
		$this->resume = $data["resume"];
		$this->texte = $data["texte"];
		
		return true;
	}
	
	// Ajoute une catégorie d'images
	private function ajouter() {
		$requete = "INSERT INTO animal(num_animal_categorie, nom, resume, texte) VALUES(";
		$requete .= $this->num_animal_categorie . ", '" . $this->traiterNom( $this->nom ) . "', ";
		$requete .= "'" . $this->traiterNom( $this->resume ) . "', '" . $this->traiterNom( $this->texte ) . "')";
		//echo $requete . "<br><br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? mysql_insert_id() : false;
	}
	
	// Modifie une catégorie d'images
	private function modifier() {
		$requete = "UPDATE animal SET";
		$requete .= " num_animal_categorie = " . $this->num_animal_categorie . ",";
		$requete .= " nom = '" . $this->traiterNom( $this->nom ) . "',";
		$requete .= " resume = '" . $this->traiterNom( $this->resume ) . "',";
		$requete .= " texte = '" . $this->traiterNom( $this->texte ) . "'";
		$requete .= " WHERE num_animal = " . $this->num_animal;
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		return ( $result ) ? $this->num_animal : false;
	}
	
	// Supprime une catégorie d'images
	function supprimer() {
		$requete = "DELETE FROM animal WHERE num_animal = " . $this->num_animal;
		//echo $requete . "<br>";
		mysql_query($requete);
	}
	
	// Interface entre le formulaire et la base
	function gererDonnee( $post=array(), $file=array() ) {
		
		// Tentative de chargement de la catégorie
		$this->load( intval( $post["num_animal"] ) );
		
		$this->num_animal_categorie = $post["num_animal_categorie"];
		$this->nom = utf8_decode( $post["nom"] );
		$this->resume = utf8_decode( $post["resume"] );
		$this->texte = utf8_decode( $post["texte"] );
		
		return ( intval($this->num_animal) == 0 ) ? $this->ajouter() : $retour = $this->modifier();
	}
	
	// Fonction destinée à supprimer les caractères spéciaux des nom des catégories
	function traiterNom( $texte='' ) {
		$texte = addslashes( $texte );
		   
		return $texte;
	}
	
	// Retourne la liste des catégories
	function getListe( $num_animal_categorie=0 ) {
		$categorie = new animal();
		
		$requete = "SELECT * FROM animal";
		$requete .= " WHERE num_animal > 0";
		if ( intval( $num_animal_categorie ) > 0 ) $requete .= " AND num_animal_categorie = " . intval( $num_animal_categorie );
		$requete .= " ORDER BY nom ASC";
		//echo $requete . "<br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				
				// Tentative de chargement du commande
				if ( $categorie->load( $data["num_animal"] ) ) {
					$tableau[$i] = new animal();
					
					$tableau[$i]->num_animal = $categorie->num_animal;
					$tableau[$i]->num_animal_categorie = $categorie->num_animal_categorie;
					$tableau[$i]->nom = $categorie->nom;
					$tableau[$i]->resume = $categorie->resume;
					$tableau[$i]->texte = $categorie->texte;
					
					$i++;
				}
			}
		}
		
		return $tableau;
	}
	
	// Retourne une image associée à l'animal en cours
	function getImage() {
		$animal_image = new animal_image();
		
		$liste = $animal_image->getListe( $this->num_animal );
		
		if ( !empty( $liste ) ) {
			return "/images/animal/" . $liste[0]->fic_image;
		}
	}
	
	// Retourne la liste des images cliquables
	function getListeImage() {
		$animal_image = new animal_image();
		$liste_lien = "";
		
		$liste = $animal_image->getListe( $this->num_animal );
		
		if ( !empty( $liste ) ) {
			foreach( $liste as $_image ) {
				//return "/images/animal/" . $liste[0]->fic_image;
				
				$liste_lien .= "<div style='float:left; margin-right:3px; margin-bottom:3px;'>";
				$liste_lien .= "<a href='/images/animal/" . $_image->fic_image . "' rel='groupe_image'><img src='/images/animal/" . $_image->fic_image . "' width='80'></a> ";
				$liste_lien .= "</div>";
			}
		}
		
		return $liste_lien;
	}
}
?>