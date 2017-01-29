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
		$_SESSION['dict'] = serialize($dict);

		return $dict;
	}
	
	$data = preg_replace_callback(
			    '/(?<=^|\{|;)s:(\d+):\"(.*?)\";(?=[asbdiO]\:\d|N;|\}|$)/s',
			    function($m){
			        return 's:' . mb_strlen($m[2]) . ':"' . $m[2] . '";';
			    },
			    $_SESSION['dict']
			);

	$dict = @unserialize($data);

	return $dict;
};

$search_term = isset($_GET['search_term']) ?  $_GET['search_term'] : 'hello';

$dict = loadDict();
var_dump((object)$dict->lookup($search_term));

die;