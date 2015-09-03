<?php
//Données pour la connexion à la base de données
//$nom_du_serveur ="ovh.net";
//$nom_de_la_base ="droitauvadh";
//$nom_utilisateur ="adhesion";
//$passe ="5N2sarzA";
$host = "mysql5-39.90";
$user = "droitauvadh";
$bdd = "droitauvadh";
$passwd = "5N2sarzA";
//Connexion à la base de données
mysql_connect($host, $user,$passwd) ;
mysql_select_db($bdd)  OR die( "ERREUR de connexion : " . mysql_error () );



$nommaj= strtoupper($nom );
$prenommaj= ucwords($prenom);
$prenommaj2= strtoupper($prenom);

//Requête pour insérer des données dans la TABLE ADHÉSION
$sql = mysql_query("INSERT INTO `adhesion`
(`nom` ,`prenom` ,`mail`,`type`,`enfants`,`adresse`,`cplt_adresse`,`titre`,`cp`,`ville`,`telephone`,`pays`,`naissance`,`profession`,`premiereadhesion`,`commentaires`,`don`,`investir`,`titre2`,`nom2`,`prenom2`)
 VALUES 
('$nom','$prenom','$mail','$type','$enfants','$adresse','$cplt_adresse','$titre','$cp','$ville','$telephone','$pays','$naissance','$profession','$premiereadhesion','$commentaires','$don','$investir','$titre2','$nom2','$prenom2');");

//ajout 7 nov

//$sql = mysql_query("UPDATE `adhesion` SET `montants`=(SELECT `tarif` FROM `prix_adhesion` AS p WHERE `type_adhesion` = `type`ORDER BY `enregistrement` DESC LIMIT 0,1)+`enfants`;");
$sql = mysql_query("UPDATE `adhesion` SET `montants`=(SELECT `tarif` FROM `prix_adhesion` AS p WHERE `type_adhesion` = `type`ORDER BY `enregistrement` DESC LIMIT 0,1)+`enfants`+`don`;");
$sql=mysql_query("UPDATE `adhesion` SET `type_libelle`=(SELECT `libelle_type` FROM `prix_adhesion`  WHERE `type_adhesion` = `type`ORDER BY `enregistrement` DESC LIMIT 0,1);");




$extraction = mysql_query("SELECT  *  FROM  `adhesion` ORDER BY `enregistrement` DESC LIMIT 0,1") or die (mysql_error());

while ( $donnees = mysql_fetch_array($extraction)){
{
$enregistrement  = $donnees['enregistrement'];
$montant=$donnees['montants'];
$libelle=$donnees['type_libelle'];
};
//fin ajout 7 nov

//Si il y a une erreur: ^^
if (!$sql)
{
die ( 'Erreur de requête : ' . mysql_error() );
}
//Si tout va bien
else
{

echo "Merci $titre $nommaj $prenommaj.<br />";
echo "Le montant total est de $montant euros (";
echo $libelle;
//nbre d'enfants
switch($enfants){case 0;echo "";break; case 1;echo " + 1 enfant";break; default;echo " + $enfants enfants";break; }

//fin nombre d'enfants
//don

switch($don){case 0;echo "";break;  default;echo " et don de $don euros";break; }
echo ").<br />";
//fin don


echo "Votre numéro d'enregistrement est: ";
echo $enregistrement;
echo " (n° à conserver).<br />";
echo "<br />Pour confirmer votre adhésion, vous allez maintenant procéder au paiement sécurisé en ligne.<br />";
echo "<br /> Cliquez sur le bouton SOUSCRIRE ci-dessous <br />";
}


//$type euros et  $enfants enfants
/////voici la version Mine 
$headers = "MIME-Version: 1.0\r\n"; 
$date = date("d-m-Y");
$heure2 = date("H:i");
//////ici on détermine le mail en format text 
$headers .= "Content-type: text/plain; charset=iso-8859-15\r\n"; 

////ici on détermine l'expediteur et l'adresse de réponse 
$headers .= "From: adhesion en ligne <$mail>\r\n"; 


$subject="NOUVELLE ADHESION EN LIGNE "; 
$destinataire="adhesion@droitauvelo.org"; //changer pour la personne qui gère à l'ADAV
$body="$titre $nommaj $prenommaj a rempli le formulaire le $date à $heure2. \r\n 
\r\n 
n° enregistrement : $enregistrement 
mail : $mail\r\n 
adresse 1 : $adresse\r\n 
adresse 2 : $cplt_adresse\r\n 
cp: $cp \r\n 
ville: $ville \r\n 
pays: $pays \r\n 
\r\n 
téléphone: $telephone \r\n 
\r\n 
profession: $profession \r\n 
date de naissance: $naissance \r\n 
catégorie adhésion: $premiereadhesion \r\n 
Commentaires: $commentaires \r\n 
Investissement personnel: $investir \r\n 
nombre d'enfants: $enfants \r\n
type d'adhésion: $libelle \r\n
conjoint: $titre2 $nom2 $prenom2 \r\n
montant du don: $don euros \r\n
\r\n 
\r\n 
Un mail de paypal confirmant un paiement de $montant euros doit vous parvenir .\r\n  "; 
if (mail($destinataire,$subject,$body,$headers)) { 
echo " <br>"; 
} else { 
echo "Problème d'envoi du mail"; 
} 
//fin ajout pour envoi de mail à l'ADAV
//
//
//
//
//ajout pour envoi de mail à l'adhérent

/////version Mine 
$headers4 = "MIME-Version: 1.0\r\n"; 
$date4 = date("d-m-Y");
$heure4 = date("H:i");
//////ici on détermine le mail en format text 
$headers4 .= "Content-type: text/plain; charset=iso-8859-15\r\n"; 
$headers4 .= "From: <adhesion@droitauvelo.org>\r\n"; 


////ici on détermine l'expediteur et l'adresse de réponse 
$subject4="ADHESION ASSOCIATION DROIT AU VELO ADAV "; 
 
$body4="$titre $nommaj $prenommaj2, \r\n 
Nous avons bien reçu les données liées à votre adhésion n° $enregistrement. \r\n 
\r\n 
Dès réception de la confirmation de votre paiement d'un montant de $montant euros, nous vous enverrons votre carte d'adhérent .\r\n 
Pour toute question, n'hésitez pas à contacter l'Association Droit Au Vélo :\r\n 
Droit au vélo (ADAV)\r\n 
23 rue Gosselet 59000 LILLE\r\n 
Tél. 03 20 86 17 25\r\n 
info@droitauvelo.org .\r\n 
Permanence tous les mercredis de 14 h à 18h.\r\n 
 "; 
if (mail($mail,$subject4,$body4,$headers4)) { 
echo " <br>"; 
} else { 
echo "Une erreur s'est produite"; 
} 



//fin ajout pour envoi de mail à l'adhérent
}
//Déconnexion
mysql_close();
?>

<?php 
//ENVOI VERS PAYPAL 
//$definition= ($type<9)? "chomeur/étudiant + $enfants enfant(s)" : (($type<15)? "individuelle + $enfants enfant(s)":"couple + $enfants enfant(s)" ); 
//$libelle2 = ($don<1)? "$libelle ":($don>0)? "$libelle + don de $don euros" ;
?>

<form method="post" action="https://www.paypal.com/cgi-bin/webscr" target="paypal">
<input type="hidden" value="_xclick" name="cmd"/>
<input type="hidden" value="adhesion@droitauvelo.org" name="business"/>
<input type="hidden" value="FR" name="lc"/>
<input type="hidden" value="adhésion ADAV" name="item_name"/>
<input type="hidden" value="products" name="button_subtype"/>
<input type="hidden" value="0" name="no_note"/>
<input type="hidden" value="EUR" name="currency_code"/>
<input type="hidden" value="1" name="add"/>
<input type="hidden" value="PP-ShopCartBF:btn_cart_LG.gif:NonHostedGuest" name="bn"/>
<input type="hidden" value="http://www.droitauvelo.org/spip.php?article493" name="return"/>
<input type="hidden" value="http://www.droitauvelo.org" name="cancel_return"/>

<input type="hidden" name="item_number" value="<?php echo $enregistrement;?>">
<input type="hidden" name="amount" value="<?php echo $montant;?>">
<input type="hidden" name="city" value="<?php echo $ville;?>">
<input type="hidden" name="zip" value="<?php echo $cp;?>">
<input type="hidden" name="email" value="<?php echo $mail;?>">
<input type="hidden" name="first_name" value="<?php echo $prenommaj;?>">
<input type="hidden" name="last_name" value="<?php echo $nommaj;?>">
<input type="hidden" name="address1" value="<?php echo $adresse;?>">
<input type="hidden" name="address2" value="<?php echo $cplt_adresse;?>">
<input type="hidden" name="item_name" value="<?php echo "$libelle " ;?>">
<input type="hidden" name="shopping_url" value="http://www.droitauvelo.org";?>
<input type="hidden" value="EUR" name="currency_code"/>


<input type="hidden" value="0" name="option_index"/>
<input type="image" border="0" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !" name="submit" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_subscribeCC_LG.gif"/>
<img width="1" height="1" border="0" style="height: 1px; width: 1px;" src="local/cache-vignettes/L1xH1/pixelgif-3a13a12-08765.gif" alt=""/>
</form>

