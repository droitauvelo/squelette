<?php
/**
 * Utilisations de pipelines par Vélos volés
 *
 * @plugin     Vélos volés
 * @copyright  2017
 * @author     Guillaume Wauquier
 * @licence    GNU/GPL
 * @package    SPIP\Adav_velovole\Pipelines
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}



/**
 * Ajout de contenu sur certaines pages,
 * notamment des formulaires de liaisons entre objets
 *
 * @pipeline affiche_milieu
 * @param  array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function adav_velovole_affiche_milieu($flux) {
	$texte = '';
	$e = trouver_objet_exec($flux['args']['exec']);

	// auteurs sur les velovoles
	if (!$e['edition'] and in_array($e['type'], array('velovole'))) {
		$texte .= recuperer_fond('prive/objets/editer/liens', array(
			'table_source' => 'auteurs',
			'objet' => $e['type'],
			'id_objet' => $flux['args'][$e['id_table_objet']]
		));
	}



	if ($texte) {
		if ($p = strpos($flux['data'], '<!--affiche_milieu-->')) {
			$flux['data'] = substr_replace($flux['data'], $texte, $p, 0);
		} else {
			$flux['data'] .= $texte;
		}
	}

	return $flux;
}




/**
 * Optimiser la base de données
 *
 * Supprime les objets à la poubelle.
 *
 * @pipeline optimiser_base_disparus
 * @param  array $flux Données du pipeline
 * @return array       Données du pipeline
 */
function adav_velovole_optimiser_base_disparus($flux) {

	sql_delete('spip_velovoles', "statut='poubelle' AND maj < " . $flux['args']['date']);

	return $flux;
}
