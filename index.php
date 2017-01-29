<?php
ini_set('memory_limit','2048M');
// simple clean session
// $_SESSION = []; die;
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require 'vendor/autoload.php';

function loadDict(){
	// $_SESSION = [];
	if(empty($_SESSION['dict'])){
		echo "First load\n";
		// Open dict's info, index and data.
		$start = time();
		
		$info = new skoro\stardict\Info('dict/en_vi.ifo');
		$index = new skoro\stardict\Index($info);
		$dict = new skoro\stardict\Dict($index);
		
		$gap = time() - $start;
		echo "{$gap}\n";

		// $_SESSION['dict'] = $dict;
		$_SESSION['dict'] = json_encode($dict);
	}
	
	$dict = json_decode($_SESSION['dict']);

	return $dict;
};

$search_term = isset($_GET['search_term']) ?  $_GET['search_term'] : 'hello';

$dict = loadDict();
var_dump((object)$dict->lookup($search_term));

die;