<?php
error_reporting(0);

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
$steps = 0;
uksort($transforms, function($a, $b) {
	return strlen($a) < strlen($b);
});
while($molecule != 'e') {
	foreach($transforms as $search => $replace) {
		$position = 0;
		while(($position = strpos($molecule, $search, $position)) !== false) {
			$molecule = substr_replace($molecule, $replace, $position, strlen($search));
			$position += strlen($search);
			$steps++;
		}	
	}
}

echo 'STEPS: ', $steps, PHP_EOL;