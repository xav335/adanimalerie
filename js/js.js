		var container_R = "";
		
		function MM_swapImgRestore() { //v3.0
			var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
		}
		
		function MM_preloadImages() { //v3.0
			var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
			var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
			if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
		}
		
		function MM_findObj(n, d) { //v4.01
			var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
			d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
			if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
			for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
			if(!x && d.getElementById) x=d.getElementById(n); return x;
		}
		
		function MM_swapImage() { //v3.0
			var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
			if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
		}
		
		function trim(sString) {
			while (sString.substring(0,1) == ' ') {
				sString = sString.substring(1, sString.length);
			}
			while (sString.substring(sString.length-1, sString.length) == ' '){
				sString = sString.substring(0,sString.length-1);
			}
			return sString;
		}
		
		function find(obj) {
			//alert("Objet recherché : " + obj);
			return document.getElementById(obj)!= null ? document.getElementById(obj) : null ;
		}
		
		function getOffset(obj, coord) {
			var val = obj["offset"+coord] ;
			while ((obj = obj.offsetParent )!=null) {
				val += obj["offset"+coord];
			}
			return val;
		}
		
		/////////////////////////////////////////////////////////////////////
		// affichage des messages d'erreur sur les controles de formulaires //
		var TimeOut = 0
		function erreur(el,message) {
			//alert("Elément à chercher : " + el);
			clearTimeout(TimeOut);
			find(el).focus();
			find('erreurdiv').innerHTML = message;
			find('erreurdiv').style.display = "block";
			if(find(el).tagName == "TEXTAREA") {
				var yTo = getOffset(find(el),"Top") +find(el).offsetHeight;
			} else {
				var yTo = getOffset(find(el),"Top") +find(el).offsetHeight;
			}
			var xTo = getOffset(find(el),"Left");
			//alert("X : " + xTo);
			//alert("Y : " + yTo);
			find('erreurdiv').style.top = yTo;
			find('erreurdiv').style.left = xTo;
			TimeOut = setTimeout("find('erreurdiv').style.display = 'none'",4000);
		}
		
		function setImageHover(el) {
			if(document.getElementById(el)!=null) {
				var oldSrc = find(el).getAttribute("src");
				find(el).style.cursor = "pointer";
				find(el).onmouseover = function() {
					this.src = this.getAttribute("hover");
				}
				find(el).onmouseout = function() {
					this.src = oldSrc;
				}
			}
		}
		
		function createObject() {
			try {
				return new XMLHttpRequest();
			} 
			catch(e) {	
				try {
					var aObj = new ActiveXObject("Msxml2.XMLHTTP");
				} 
				catch (e) {
					try {
						var aObj = new ActiveXObject("Microsoft.XMLHTTP");
					} 
					catch(e) {
						return false;
					}
				}
			}
			return aObj;
		}
		
		function _getContent() {
		    var args = _getContent.arguments;
		    container_R = args[0];
		    
		    if(args.length > 1) {
		    	//http = createObject();
		    	var http_ajax = createObject();
			    http_ajax.open('GET', args[1], true);
			    http_ajax.setRequestHeader("Cache-Control","no-cache");
			    http_ajax.send(null);
			    
			    http_ajax.onreadystatechange = function() {
					if (http_ajax.readyState == 4) {
						find("div_travail").style.visibility = "hidden";
						document.getElementById(container_R).innerHTML = http_ajax.responseText;
					} 
					else {
						// Positionnement de la fenetre au centre de la page
						var largeur = window.innerWidth;
						var hauteur = window.innerHeight;
						//alert(largeur + " x " + hauteur);
						
						//var yTo = find(container_R).offsetHeight/10;
						var xTo = (largeur - 16)/2;
						var yTo = (hauteur - 16)/2;
						
						find("div_travail").style.top = yTo;
						find("div_travail").style.left = xTo;
						find("div_travail").innerHTML = '<center><img src="../images/activity.gif" border="0"></center>';
						find("div_travail").style.visibility = "visible";
					}
				}
			} 
			else {
				find(args[0]).innerHTML = '';
			}
		}
		
		function verifier_champ(champ, valeur) {
			try {
				var formulaire_ajax = createObject();
				
				// Traitement de l'image
				var page = "../verification.php";
				page += "?type_champ=" + champ;
				page += "&valeur_champ=" + valeur;
				page += "&ms=" + new Date().getTime();
				//alert(page);
				
				formulaire_ajax.open("GET", page, false);
				formulaire_ajax.setRequestHeader("Cache-Control","no-cache");
				formulaire_ajax.send(null);
				
				// Il y a une erreur
				if (formulaire_ajax.responseText == "erreur") {
					valeur_retour = "erreur";
				}
				
				// Il n'y a pas d'erreur --> On passe à la suite
				else {
					valeur_retour = "";
				}
				
				return valeur_retour;
			}
			catch(e) {
				alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest..." + e.message);
				return "erreur";
			}
		}