<?php

$transforms = [
	'ThF' => 'Al',
	'ThRnFAr' => 'Al',
	'BCa' => 'B',
	'TiB' => 'B',
	'TiRnFAr' => 'B',
	'CaCa' => 'Ca',
	'PB' => 'Ca',
	'PRnFAr' => 'Ca',
	'SiRnFYFAr' => 'Ca',
	'SiRnMgAr' => 'Ca',
	'SiTh' => 'Ca',
	'CaF' => 'F',
	'PMg' => 'F',
	'SiAl' => 'F',
	'CRnAlAr' => 'H',
	'CRnFYFYFAr' => 'H',
	'CRnFYMgAr' => 'H',
	'CRnMgYFAr' => 'H',
	'HCa' => 'H',
	'NRnFYFAr' => 'H',
	'NRnMgAr' => 'H',
	'NTh' => 'H',
	'OB' => 'H',
	'ORnFAr' => 'H',
	'BF' => 'Mg',
	'TiMg' => 'Mg',
	'CRnFAr' => 'N',
	'HSi' => 'N',
	'CRnFYFAr' => 'O',
	'CRnMgAr' => 'O',
	'HP' => 'O',
	'NRnFAr' => 'O',
	'OTi' => 'O',
	'CaP' => 'P',
	'PTi' => 'P',
	'SiRnFAr' => 'P',
	'CaSi' => 'Si',
	'ThCa' => 'Th',
	'BP' => 'Ti',
	'TiTi' => 'Ti',
	'HF' => 'e',
	'NAl' => 'e',
	'OMg' => 'e',
];

$molecule = 'CRnSiRnCaPTiMgYCaPTiRnFArSiThFArCaSiThSiThPBCaCaSiRnSiRnTiTiMgArPBCaPMgYPTiRnFArFArCaSiRnBPMgArPRnCaPTiRnFArCaSiThCaCaFArPBCaCaPTiTiRnFArCaSiRnSiAlYSiThRnFArArCaSiRnBFArCaCaSiRnSiThCaCaCaFYCaPTiBCaSiThCaSiThPMgArSiRnCaPBFYCaCaFArCaCaCaCaSiThCaSiRnPRnFArPBSiThPRnFArSiRnMgArCaFYFArCaSiRnSiAlArTiTiTiTiTiTiTiRnPMgArPTiTiTiBSiRnSiAlArTiTiRnPMgArCaFYBPBPTiRnSiRnMgArSiThCaFArCaSiThFArPRnFArCaSiRnTiBSiThSiRnSiAlYCaFArPRnFArSiThCaFArCaCaSiThCaCaCaSiRnPRnCaFArFYPMgArCaPBCaPBSiRnFYPBCaFArCaSiAl';

$variations = [];
$letters = array_filter(preg_split('/([A-Z]{1}[a-z]?)/', $molecule, null, PREG_SPLIT_DELIM_CAPTURE));

foreach($letters as $i => $letter) {
	foreach($transforms as $transform => $key) {
		$copy = $letters;
		if($copy[$i] === $key) {
			$copy[$i] = $transform;
			$variations[] = implode('', $copy);
		}
	}
}

echo 'MOLECULES: ', count(array_unique($variations, SORT_STRING)), PHP_EOL;