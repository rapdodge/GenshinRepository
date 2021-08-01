<?php
header('Content-Type: application/json');
$curl = curl_init();

curl_setopt_array(
	$curl,
	array(
		CURLOPT_URL => "https://sdk-os-static.mihoyo.com/hk4e_global/mdk/launcher/api/resource?channel_id=1&key=gcStgarh&launcher_id=10&sub_channel_id=0",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	)
);

$ResponcURL = json_decode(curl_exec($curl), true);

curl_close($curl);

$CekAPI = array();

if ($ResponcURL['message'] != "OK") {
	$CekAPI['name'] = 'Genshin Impact Data Links';
	$CekAPI['site'] = 'genshin.mihoyo.com';
	$CekAPI['error'] = true;
	$CekAPI['message'] = 'Error fetching from API';
	print_r(json_encode($CekAPI));
} else {
	$CekAPI['name'] = 'Genshin Impact Data Links';
	$CekAPI['site'] = 'genshin.mihoyo.com';
	$CekAPI['error'] = false;
	$CekAPI['message'] = 'success';

	$DataTerbaru = array(
		'version' => $ResponcURL['data']['game']['latest']['version'],
		'path' => $ResponcURL['data']['game']['latest']['path'],
		'md5' => $ResponcURL['data']['game']['latest']['md5'],
	);

	$DataSuaraTerbaru = array();
	foreach ($ResponcURL['data']['game']['latest']['voice_packs'] as $k => $v) {
		$DataSuaraTerbaru['voice_packs'][$k]['language'] = $ResponcURL['data']['game']['latest']['voice_packs'][$k]['language'];
		$DataSuaraTerbaru['voice_packs'][$k]['name'] = $ResponcURL['data']['game']['latest']['voice_packs'][$k]['name'];
		$DataSuaraTerbaru['voice_packs'][$k]['path'] = $ResponcURL['data']['game']['latest']['voice_packs'][$k]['path'];
		$DataSuaraTerbaru['voice_packs'][$k]['md5'] = $ResponcURL['data']['game']['latest']['voice_packs'][$k]['md5'];
	}

	$DataTerbaruGabung = array(
		'latest' => array_merge($DataTerbaru, $DataSuaraTerbaru),
	);

	$DataPraUnduh = array();
	foreach ($ResponcURL['data']['game']['diffs'] as $k0 => $v0) {
		$DataPraUnduh[$k0]['version'] = $ResponcURL['data']['game']['diffs'][$k0]['version'];
		$DataPraUnduh[$k0]['name'] = $ResponcURL['data']['game']['diffs'][$k0]['name'];
		$DataPraUnduh[$k0]['path'] = $ResponcURL['data']['game']['diffs'][$k0]['path'];
		$DataPraUnduh[$k0]['md5'] = $ResponcURL['data']['game']['diffs'][$k0]['md5'];
		foreach ($ResponcURL['data']['game']['diffs'][$k0]['voice_packs'] as $k1 => $v1) {
			$DataPraUnduh[$k0]['voice_packs'][$k1]['language'] = $ResponcURL['data']['game']['diffs'][$k0]['voice_packs'][$k1]['language'];
			$DataPraUnduh[$k0]['voice_packs'][$k1]['name'] = $ResponcURL['data']['game']['diffs'][$k0]['voice_packs'][$k1]['name'];
			$DataPraUnduh[$k0]['voice_packs'][$k1]['path'] = $ResponcURL['data']['game']['diffs'][$k0]['voice_packs'][$k1]['path'];
			$DataPraUnduh[$k0]['voice_packs'][$k1]['md5'] = $ResponcURL['data']['game']['diffs'][$k0]['voice_packs'][$k1]['md5'];
		}
	}

	$DataPraUnduhGabung = array(
		'diffs' => $DataPraUnduh,
	);

	$Hasil = array_merge($CekApi, $DataTerbaruGabung, $DataPraUnduhGabung);
	print_r(json_encode($Hasil));
}
