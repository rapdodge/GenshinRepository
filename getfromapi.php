<?php
header('Content-Type: application/json');
$curl = curl_init();

curl_setopt_array(
	$curl,
	array(
		CURLOPT_URL => "https://sdk-os-static.mihoyo.com/hk4e_global/mdk/launcher/api/resource?channel_id=1&key=gcStgarh&launcher_id=10&sub_channel_id=0",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
	)
);

$ResponcURL = json_decode(curl_exec($curl), true);

curl_close($curl);

// PEMBATAS

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

	// PEMBATAS

	$DataGameTerbaru = array(
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
	};

	$GabungGameSuaraTerbaru = array(
		'latest' => array_merge($DataGameTerbaru, $DataSuaraTerbaru),
	);

	$DataUpgradeTerbaru = array();
	foreach ($ResponcURL['data']['game']['diffs'] as $k0 => $v0) {
		$DataUpgradeTerbaru[$k0]['version'] = $ResponcURL['data']['game']['diffs'][$k0]['version'];
		$DataUpgradeTerbaru[$k0]['name'] = $ResponcURL['data']['game']['diffs'][$k0]['name'];
		$DataUpgradeTerbaru[$k0]['path'] = $ResponcURL['data']['game']['diffs'][$k0]['path'];
		$DataUpgradeTerbaru[$k0]['md5'] = $ResponcURL['data']['game']['diffs'][$k0]['md5'];
		foreach ($ResponcURL['data']['game']['diffs'][$k0]['voice_packs'] as $k1 => $v1) {
			$DataUpgradeTerbaru[$k0]['voice_packs'][$k1]['language'] = $ResponcURL['data']['game']['diffs'][$k0]['voice_packs'][$k1]['language'];
			$DataUpgradeTerbaru[$k0]['voice_packs'][$k1]['name'] = $ResponcURL['data']['game']['diffs'][$k0]['voice_packs'][$k1]['name'];
			$DataUpgradeTerbaru[$k0]['voice_packs'][$k1]['path'] = $ResponcURL['data']['game']['diffs'][$k0]['voice_packs'][$k1]['path'];
			$DataUpgradeTerbaru[$k0]['voice_packs'][$k1]['md5'] = $ResponcURL['data']['game']['diffs'][$k0]['voice_packs'][$k1]['md5'];
		}
	}

	$GabungDataUpgradeTerbaru = array(
		'diffs' => array_merge($DataUpgradeTerbaru),
	);

	$GabungDataUpgradeTerbaru = array(
		'game' => array_merge($GabungGameSuaraTerbaru, $GabungDataUpgradeTerbaru)
	);

	// PEMBATAS

	$DataPlugin = array();
	foreach ($ResponcURL['data']['plugin']['plugins'] as $k => $v) {
		$DataPlugin['plugins'][$k]['name'] = $ResponcURL['data']['plugin']['plugins'][$k]['name'];
		$DataPlugin['plugins'][$k]['path'] = $ResponcURL['data']['plugin']['plugins'][$k]['path'];
		$DataPlugin['plugins'][$k]['md5'] = $ResponcURL['data']['plugin']['plugins'][$k]['md5'];
	}

	$GabungPlugin = array(
		'plugin' => $DataPlugin
	);

	// PEMBATAS

	$DataGamePraUnduh = array(
		'version' => $ResponcURL['data']['pre_download_game']['latest']['version'],
		'path' => $ResponcURL['data']['pre_download_game']['latest']['path'],
		'md5' => $ResponcURL['data']['pre_download_game']['latest']['md5'],
	);

	$DataSuaraPraUnduh = array();
	foreach ($ResponcURL['data']['pre_download_game']['latest']['voice_packs'] as $k => $v) {
		$DataSuaraPraUnduh['voice_packs'][$k]['language'] = $ResponcURL['data']['pre_download_game']['latest']['voice_packs'][$k]['language'];
		$DataSuaraPraUnduh['voice_packs'][$k]['name'] = $ResponcURL['data']['pre_download_game']['latest']['voice_packs'][$k]['name'];
		$DataSuaraPraUnduh['voice_packs'][$k]['path'] = $ResponcURL['data']['pre_download_game']['latest']['voice_packs'][$k]['path'];
		$DataSuaraPraUnduh['voice_packs'][$k]['md5'] = $ResponcURL['data']['pre_download_game']['latest']['voice_packs'][$k]['md5'];
	};

	$DataPraUnduh = array();
	foreach ($ResponcURL['data']['pre_download_game']['diffs'] as $k0 => $v0) {
		$DataPraUnduh[$k0]['version'] = $ResponcURL['data']['pre_download_game']['diffs'][$k0]['version'];
		$DataPraUnduh[$k0]['name'] = $ResponcURL['data']['pre_download_game']['diffs'][$k0]['name'];
		$DataPraUnduh[$k0]['path'] = $ResponcURL['data']['pre_download_game']['diffs'][$k0]['path'];
		$DataPraUnduh[$k0]['md5'] = $ResponcURL['data']['pre_download_game']['diffs'][$k0]['md5'];
		foreach ($ResponcURL['data']['pre_download_game']['diffs'][$k0]['voice_packs'] as $k1 => $v1) {
			$DataPraUnduh[$k0]['voice_packs'][$k1]['language'] = $ResponcURL['data']['pre_download_game']['diffs'][$k0]['voice_packs'][$k1]['language'];
			$DataPraUnduh[$k0]['voice_packs'][$k1]['name'] = $ResponcURL['data']['pre_download_game']['diffs'][$k0]['voice_packs'][$k1]['name'];
			$DataPraUnduh[$k0]['voice_packs'][$k1]['path'] = $ResponcURL['data']['pre_download_game']['diffs'][$k0]['voice_packs'][$k1]['path'];
			$DataPraUnduh[$k0]['voice_packs'][$k1]['md5'] = $ResponcURL['data']['pre_download_game']['diffs'][$k0]['voice_packs'][$k1]['md5'];
		}
	}

	$GabungDataPraUnduh = array(
		'diffs' => array_merge($DataPraUnduh),
	);

	$GabungGameSuaraPraUnduh = array(
		'pre_download_game' => array_merge($DataGamePraUnduh, $DataSuaraPraUnduh, $GabungDataPraUnduh),
	);

	// PEMBATAS

	$GabungSemua = array(
		'data' => array_merge($GabungDataUpgradeTerbaru, $GabungPlugin, $GabungGameSuaraPraUnduh),
	);

	// PEMBATAS

	$Hasil = array_merge($GabungSemua);
	print_r(json_encode($Hasil));
}
