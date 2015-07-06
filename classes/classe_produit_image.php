<?
class produit_image {
	var $num_produit_image = 0;
	var $num_produit = 0;
	var $fic_image = '';
	
	// Charge une image
	function load($num_produit_image=0) {
		$num_produit_image = intval($num_produit_image);
		if ($num_produit_image <= 0) return false;
		
		$requete = "SELECT * FROM produit_image";
		$requete .= " WHERE num_produit_image = '" . $num_produit_image . "'";
		//echo $requete . "<br>";
		$result = mysql_query($requete);
		
		if (!$result) return false;
		
		$data = mysql_fetch_assoc($result);
		if (empty($data)) return false;
		
		$this->num_produit_image = $data["num_produit_image"];
		$this->num_produit = $data["num_produit"];
		$this->fic_image = $data["fic_image"];
		
		return true;
	}
	
	function traiter_texte( $texte ) {
		$texte = addslashes( $texte );
		return $texte;
	}
	
	function traiter_chiffre( $texte ) {
		$texte = intval( $texte );
		return $texte;
	}
	
	// Ajoute une image
	function ajouter() {
		$requete = "INSERT INTO produit_image(num_produit, fic_image) VALUES(";
		$requete .= $this->num_produit . ", '" . $this->traiter_texte( $this->fic_image ) . "')";
		//echo $requete . "<br><br>";
		mysql_query($requete);
		
		$num = mysql_insert_id();
		
		return $num;
	}
	
	// Modifie une image
	function modifier() {
		$requete = "UPDATE produit_image SET";
		$requete .= " num_produit = '" . $this->traiter_chiffre( $this->num_produit ) . "',";
		$requete .= " fic_image = '" . $this->traiter_texte( $this->fic_image ) . "'";
		$requete .= " WHERE num_produit_image = " . $this->num_produit_image;
		//echo $requete . "<br><br>";
		mysql_query($requete);
		
		return $this->num_produit_image;
	}
	
	// Supprime une image
	function supprimer() {
		
		// On supprime l'image
		if ( $this->fic_image != "" ) $this->supprimerImage();
		
		$requete = "DELETE FROM produit_image";
		$requete .= " WHERE num_produit_image = " . $this->num_produit_image;
		//echo $requete . "<br><br>";
		mysql_query($requete);
	}
	
	// Intermédiaire entre le formulaire et la base
	function gererDonnees( $post=array(), $file=array() ) {
		
		// Tentative de chargement
		$modification = $this->load( intval( $post["num_produit_image"] ) );
		
		// Traitement des fichiers reçus
		$this->uploaderFichier( $post, $file );
		
		$this->num_produit = $post["num_produit"];
		
		// C'est une modification
		return ( $modification ) ? $this->modifier() : $num = $this->ajouter();
	}
	
	// Traitement des fichiers reçus
	function uploaderFichier( $post=array(), $file=array() ) {
		
		// Tentative de chargement
		$modification = $this->load( intval( $post["num_produit_image"] ) );
		
		// Fichier image
		if( $file["fic_image"]["name"] != "" ) {
			//echo "Fichier image<br>";
			
			// On a actuellement une image --> On la supprime
			if ( $this->fic_image != "" ) $this->supprimerImage();
			
			$nom_fichier = $this->traiterImage( $post, $file["fic_image"] );
			if ( !is_null( $nom_fichier )  ) {
				$this->fic_image = $nom_fichier;
			}
		}
	}
	
	function traiterImage( $post, $file ) {
		$extension_autorise = array("image/jpeg", "image/pjpeg", "image/bmp", "image/gif", "image/png");
		$chemin = "../../images/produit";
		
		// Le type de fichier est bien une image
		if (in_array($file["type"], $extension_autorise)) {
			$name = $file["name"];
			$ext = substr($name, strrpos($name, ".") + 1); 
			$nom_fichier = basename($name, "." . $ext);
			//$nom_fichier = $file["name"];
			
			// Pour éviter d'écraser l'ancien en cas de doublon
			$n = "";
			while(file_exists($chemin . "/" . $nom_fichier . $n . "." . $ext)) 
				$n++;
			
			$nom_fichier = $nom_fichier . $n . "." . $ext;
			
			//echo "nom fichier : " . $nom_fichier . "<br>";
			//echo "Lieu : " . $chemin . "/" . $nom_fichier . "<br>";
			
			$resultat = move_uploaded_file($file["tmp_name"], $chemin . "/" . $nom_fichier);
			if ($resultat == true) {
				
				// ----- Dimensions de l'image ----- //
				// Changement du répertoire de destination
				$rep_destination = $chemin . "/";
				$largeur_maxi = 800;
				$hauteur_maxi = 600;
				//echo $rep_destination . $nom_fichier . "<br>";
				
				$fichier_a_retailler = $rep_destination . $nom_fichier;
				$size = GetImageSize($fichier_a_retailler); 
				$largeur = $size[0];
				$hauteur = $size[1];
				
				//echo "0 largeur : " . $largeur . "<br>";
				//echo "0 hauteur : " . $hauteur . "<br>";
				$fichier_a_retailler = $rep_destination . $nom_fichier;
				
				// Redimensionnement de l'image ET création d'une vignette
				if ( $erreur == 0 && ($largeur > $largeur_maxi)) {
					
					//echo "fichier a retailler : " . $fichier_a_retailler . "<br>";
					$i = new ImageManipulator($fichier_a_retailler);
					
					$nouvelle_largeur  = $largeur_maxi;
					$nouvelle_hauteur = ($nouvelle_largeur * $hauteur) / $largeur ; // hauteur proportionnelle
					
					$i->resample($largeur_maxi, $nouvelle_hauteur);
					$filename = $rep_destination . $nom_fichier;
					//echo "--> " . $filename . "<br>";
					$i->save_jpeg($filename);
					$i->end();
					
					//$autre_chemin = "../../cartfile/im/produit";
					//copy($rep_destination . $nom_fichier, $autre_chemin . "/" . $nom_fichier);
					
					$size = GetImageSize($filename); 
					//echo "TEST sur " . $filename . "<br>";
					$largeur = $size[0];
					$hauteur = $size[1];
					
					if ($hauteur > $hauteur_maxi) {
						//echo " Il faut retailler !!!<br>";
						$fichier_a_retailler = $filename;
					}
					
					//echo "1 largeur : " . $largeur . "<br>";
					//echo "1 hauteur : " . $hauteur . "<br>";
				}
				
				// Redimensionnement de l'image ET création d'une vignette
				if ( $erreur == 0 && ($hauteur > $hauteur_maxi)) {
					
					//echo "fichier a retailler : " . $fichier_a_retailler . "<br>";
					$i = new ImageManipulator($fichier_a_retailler);
					
					$nouvelle_hauteur  = $hauteur_maxi;
					$nouvelle_largeur = round(($nouvelle_hauteur * $largeur) / $hauteur) ;
					
					$i->resample($nouvelle_largeur, $nouvelle_hauteur);
					$filename2 = $rep_destination . $nom_fichier;
					//echo "--> " . $filename . "<br>";
					$i->save_jpeg($filename2);
					$i->end();
					
					//$autre_chemin = "../../cartfile/im/produit";
					//copy($rep_destination . $nom_fichier, $autre_chemin . "/" . $nom_fichier);
					
					$size = GetImageSize($filename2);
					//echo "TEST sur " . $filename . "<br>";
					$largeur = $size[0];
					$hauteur = $size[1];
					
					//echo "2 largeur : " . $largeur . "<br>";
					//echo "2 hauteur : " . $hauteur . "<br>";
				}
				
				// On retourne le nom du fichier
				return $nom_fichier;
			}
			else {
				$GLOBALS["erreur"] = "Impossible de copier le fichier : " . $resultat;
				return false;
			}
		}
		else {
			$GLOBALS["erreur"] = "Le type du fichier choisi est incorrect.";
			return false;
		}
	}
	
	function supprimerImage() {
		$fichier_a_supprimer = "../../images/produit/" . $this->fic_image;
		$this->fic_image = "";
		//echo "Suppression de " . $fichier_a_supprimer . "<br>";
		
		if ( file_exists($fichier_a_supprimer) )
			unlink( $fichier_a_supprimer );
	}
	
	// Retourne la liste des images
	function getListe( $num_produit='' ) {
		$image = new produit_image();
		
		//echo "--> num_produit : " . $num_produit . "<br>";
		
		$requete = "SELECT * FROM produit_image";
		$requete .= " WHERE num_produit_image > 0";
		if ( $num_produit != '' ) $requete .= " AND num_produit = '" . intval( $num_produit ) . "'";
		$requete .= " ORDER BY num_produit_image";
		//echo $requete . "<br><br>";
		$liste = mysql_query($requete);
		
		// Retourne un tableau d'image
		$tableau = array();
		
		if (mysql_num_rows($liste) != 0) {
			$i = 0;
			while($data = mysql_fetch_assoc($liste)) {
				
				// Tentative de chargement du commande
				if ( $image->load( $data["num_produit_image"] ) ) {
					$tableau[$i] = new produit_image();
					
					$tableau[$i]->num_produit_image = $image->num_produit_image;
					$tableau[$i]->num_produit = $image->num_produit;
					$tableau[$i]->fic_image = $image->fic_image;
					
					$i++;
				}
			}
		}
		
		return $tableau;
	}
}
?>