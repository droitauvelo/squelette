<?php

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip(socialtags_fonctions.php);

function socialtags_json($cfg) {
	if (!is_array($cfg))
		return '[]';

	$json = array();
	
	include_spip('socialtags_fonctions');

	foreach (socialtags_liste() as $service)
	if (in_array($a = $service['lesauteurs'], $cfg)) {
		$t = _q($service['titre']);
		$u = _q($service['url']);
		$d = isset($service['descriptif']) ? _q($service['descriptif']) : $t;
		$u_site = _q($GLOBALS['meta']['adresse_site']);
		$json[] = "{ a: '{$a}', n: {$t},  u: {$u}, u_site: {$u_site}}";
	}

	return "[\n" . join(",\n", $json) . "\n]";
}
