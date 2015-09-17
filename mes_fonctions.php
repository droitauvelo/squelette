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



function tri_docart($tab,$key_tri='date',$sens=''){
    $tab_tri=array();
    foreach ($tab as $key => $row) {
        $tab_tri[$key]  = strtolower(wd_remove_accents($row[$key_tri]));
    }
    array_multisort($tab_tri, SORT_STRING, $tab);
    if($sens!='')$tab=array_reverse($tab);
    return $tab;
}

function wd_remove_accents($str, $charset='utf-8')
{
    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

    return $str;
}