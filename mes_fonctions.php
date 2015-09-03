<?php


function adav_bloc_en_chiffre($barres)
{

    $barre = &$barres['edition'];
    $barre->ajouterApres('grpCaracteres', array(
            "id" => "sepadav",
            "separator" => "---------------",
            "display"   => true,
    ));
    $barre->ajouterApres('sepadav', array(
            // groupe code et bouton <code>
            "id"          => 'adav_bloc_en_chiffre',
            "name"        => _T('outil_inserer_bloc_en_chiffre'),
            "className"   => 'outils_bloc_en_chiffre',
            "openWith" => "<bloc_en_chiffres>",
            "closeWith" => "</bloc_en_chiffres>",              
            "display"     => true,
    ));
    return $barres;
}

function adav_porte_plume_lien_classe_vers_icone($flux){

	return array_merge($flux, array(       
			'outils_bloc_en_chiffre' => 'en_chiffres.png',
	));
    }


?>
