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




function lunr_data()
{

    $rubriques = recuperer_fond('liste/lunr_rubrique');

    $res= sql_query('SELECT id_rubrique,titre,GROUP_CONCAT(id_mot SEPARATOR \':\') as id_mots FROM spip_rubriques r LEFT JOIN spip_mots_liens m on  m.objet=\'rubrique\' and id_objet=id_rubrique where r.id_rubrique IN('.$rubriques.') group by id_rubrique, titre');

    $tab_mots_sql = sql_allfetsel('id_mot, titre', 'spip_mots');
    $tab_mots = array();
    foreach ($tab_mots_sql as $mots) {
        $tab_mots[$mots['id_mot']] = $mots['titre'];
    }

    while ($d = sql_fetch($res)) {
        $tab_id_mot = explode(':', $d['id_mots']);
        foreach ($tab_id_mot as $id_mot) {
            $d['mots'][] = $tab_mots[$id_mot];
        }
        $d['mots'] = implode(', ', $d['mots']);
        $d['titre'] = supprimer_numero($d['titre']);
        $d['nature'] = 'rubrique';
        $d['id'] = $d['id_rubrique'];
        unset($d['id_rubrique']);
        unset($d['id_mots']);
        $data[] = $d;

    }


    $tab_mots_sql = sql_allfetsel('id_mot, titre', 'spip_mots');
    $tab_mots = array();
    foreach ($tab_mots_sql as $mots) {
        $tab_mots[$mots['id_mot']] = $mots['titre'];
    }

    $res= sql_query('SELECT id_article,titre,GROUP_CONCAT(id_mot SEPARATOR \':\') as id_mots FROM spip_articles r LEFT JOIN spip_mots_liens m on  m.objet=\'article\' and id_objet=id_article where r.id_rubrique =1 and date > DATE_SUB(NOW(),INTERVAL 200 DAY) group by id_article, titre');


    while ($d = sql_fetch($res)) {
        $tab_id_mot = explode(':', $d['id_mots']);
        foreach ($tab_id_mot as $id_mot) {
            $d['mots'][] = $tab_mots[$id_mot];
        }
        $d['mots'] = implode(', ', $d['mots']);
        $d['titre'] = supprimer_numero($d['titre']);
        $d['nature'] = 'actu';
        $d['id'] = $d['id_article'];
        unset($d['id_article']);
        unset($d['id_mots']);
        $data[] = $d;

    }

    $res= sql_query('SELECT id_article,titre,GROUP_CONCAT(id_mot SEPARATOR \':\') as id_mots FROM spip_articles r LEFT JOIN spip_mots_liens m on  m.objet=\'article\' and id_objet=id_article where r.id_rubrique =45 and date > DATE_SUB(NOW(),INTERVAL 100 DAY)  group by id_article, titre');

    while ($d = sql_fetch($res)) {
        $tab_id_mot = explode(':', $d['id_mots']);
        foreach ($tab_id_mot as $id_mot) {
            $d['mots'][] = $tab_mots[$id_mot];
        }
        $d['mots'] = implode(', ', $d['mots']);
        $d['titre'] = supprimer_numero($d['titre']);
        $d['nature'] = 'Revue de presse';
        $d['id'] = $d['id_article'];
        unset($d['id_article']);
        unset($d['id_mots']);
        $data[] = $d;

    }



    $res= sql_query('SELECT id_article,titre,GROUP_CONCAT(id_mot SEPARATOR \':\') as id_mots FROM spip_articles r LEFT JOIN spip_mots_liens m on  m.objet=\'article\' and id_objet=id_article where r.id_rubrique=142  group by id_article, titre');

    while ($d = sql_fetch($res)) {
        $tab_id_mot = explode(':', $d['id_mots']);
        foreach ($tab_id_mot as $id_mot) {
            $d['mots'][] = $tab_mots[$id_mot];
        }
        $d['mots'] = implode(', ', $d['mots']);
        $d['titre'] = supprimer_numero($d['titre']);
        $d['nature'] = 'Antenne';
        $d['id'] = $d['id_article'];
        unset($d['id_article']);
        unset($d['id_mots']);
        $data[] = $d;

    }




    $articles = trim(recuperer_fond('liste/lunr_article'));
    if(!empty($articles)){
        $res= sql_query('SELECT id_article,titre,GROUP_CONCAT(id_mot SEPARATOR \':\') as id_mots FROM spip_articles r LEFT JOIN spip_mots_liens m on  m.objet=\'article\' and id_objet=id_article where r.id_article IN('.$articles.')  group by id_article, titre');

    while ($d = sql_fetch($res)) {
        $tab_id_mot = explode(':', $d['id_mots']);
        foreach ($tab_id_mot as $id_mot) {
            $d['mots'][] = $tab_mots[$id_mot];
        }
        $d['mots'] = implode(', ', $d['mots']);
        $d['titre'] = supprimer_numero($d['titre']);
        $d['nature'] = 'Article';
        $d['id'] = $d['id_article'];
        unset($d['id_article']);
        unset($d['id_mots']);
        $data[] = $d;

    }
    }



    $res= sql_query('SELECT id_article,titre,GROUP_CONCAT(id_mot SEPARATOR \':\') as id_mots FROM spip_evenements r LEFT JOIN spip_mots_liens m on  m.objet=\'evenement\' and id_objet=id_article where date_fin > DATE_SUB(NOW(),INTERVAL 10 DAY)  group by id_article, titre');

    while ($d = sql_fetch($res)) {
        $tab_id_mot = explode(':', $d['id_mots']);
        foreach ($tab_id_mot as $id_mot) {
            $d['mots'][] = $tab_mots[$id_mot];
        }
        $d['mots'] = implode(', ', $d['mots']);
        $d['titre'] = supprimer_numero($d['titre']);
        $d['nature'] = 'agenda';
        $d['id'] = $d['id_article'];
        unset($d['id_article']);
        unset($d['id_mots']);
        $data[] = $d;

    }






    return $data;
}

function  balise_LUNR_DATA($p)
{
    $p->code = "lunr_data()";
    return $p;
}






function  balise_RANGE($p)
{

    $min = interprete_argument_balise (1, $p);
    $max = interprete_argument_balise (2, $p);
    $pas = interprete_argument_balise (3, $p);
    if(!$pas) $pas=1;

    $p->code = "range($min,$max,$pas)";
    return $p;
}
