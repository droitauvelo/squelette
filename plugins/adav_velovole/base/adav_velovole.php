<?php
/**
 * Déclarations relatives à la base de données
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
 * Déclaration des alias de tables et filtres automatiques de champs
 *
 * @pipeline declarer_tables_interfaces
 * @param array $interfaces
 *     Déclarations d'interface pour le compilateur
 * @return array
 *     Déclarations d'interface pour le compilateur
 */
function adav_velovole_declarer_tables_interfaces($interfaces) {

	$interfaces['table_des_tables']['velovoles'] = 'velovoles';

	return $interfaces;
}


/**
 * Déclaration des objets éditoriaux
 *
 * @pipeline declarer_tables_objets_sql
 * @param array $tables
 *     Description des tables
 * @return array
 *     Description complétée des tables
 */
function adav_velovole_declarer_tables_objets_sql($tables) {

	$tables['spip_velovoles'] = array(
		'type' => 'velovole',
		'principale' => 'oui',
		'field'=> array(
			'id_velovole'        => 'bigint(21) NOT NULL',
			'titre'              => 'VARCHAR(250)',
			'description'        => 'TEXT NOT NULL',
			'date_vol'           => 'datetime NOT NULL DEFAULT "0000-00-00 00:00:00"',
			'lieu'               => 'TEXT NOT NULL',
			'x'                  => 'FLOAT NULL',
			'y'                  => 'FLOAT NULL',
			'date_enregistrement' => 'datetime NOT NULL DEFAULT "0000-00-00 00:00:00"',
			'code_bycycode'      => 'VARCHAR(25)',
			'date_enregistrement' => 'datetime NOT NULL DEFAULT "0000-00-00 00:00:00"',
			'statut'             => 'varchar(20)  DEFAULT "0" NOT NULL',
			'maj'                => 'TIMESTAMP'
		),
		'key' => array(
			'PRIMARY KEY'        => 'id_velovole',
			'KEY statut'         => 'statut',
		),
		'titre' => 'titre AS titre, "" AS lang',
		'date' => 'date_enregistrement',
		'champs_editables'  => array('titre', 'description', 'date_vol', 'lieu', 'x', 'y', 'code_bycycode'),
		'champs_versionnes' => array('titre', 'description', 'date_vol', 'lieu', 'code_bycycode'),
		'rechercher_champs' => array(),
		'tables_jointures'  => array(),
		'statut_textes_instituer' => array(
			'prepa'    => 'texte_statut_en_cours_redaction',
			'prop'     => 'texte_statut_propose_evaluation',
			'publie'   => 'texte_statut_publie',
			'refuse'   => 'texte_statut_refuse',
			'poubelle' => 'texte_statut_poubelle',
		),
		'statut'=> array(
			array(
				'champ'     => 'statut',
				'publie'    => 'publie',
				'previsu'   => 'publie,prop,prepa',
				'post_date' => 'date',
				'exception' => array('statut','tout')
			)
		),
		'texte_changer_statut' => 'velovole:texte_changer_statut_velovole',


	);

	return $tables;
}
