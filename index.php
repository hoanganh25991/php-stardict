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
	if(empty($_SESSION['words'])){
		echo "First load\n";
		// Open dict's info, index and data.
		$info = new skoro\stardict\Info('dict/en_vi.ifo');
		$index = new skoro\stardict\Index($info);
		$dict = new skoro\stardict\Dict($index);
		// Get out words
		$words = $dict->getIndex()->words;
		// Store to session
		$_SESSION['words'] = $words;

		return $dict;
	}else{
		// session has words, get out
		$words = $_SESSION['words'];
		
		$info = new skoro\stardict\Info('dict/en_vi.ifo');
		$index = new skoro\stardict\Index($info, $words);
		$dict = new skoro\stardict\Dict($index);

		return $dict;
	}
};

$search_term = isset($_GET['search_term']) ?  $_GET['search_term'] : 'hello';
$dict = loadDict();

$result = $dict->lookup($search_term);

if(!$result){
	echo "Can not find your search term: {$search_term}"; die;
}

// echo "<p>{$result[$search_term]}</p>";
echo 
"<style>textarea#styled {
	/*width: 100%;*/
	height: 300px;
    outline: none;
    resize: none;
    overflow: auto;
    white-space: normal;
	width: 600px;
}</style>";
echo "<textarea id='styled'>{$result[$search_term]}</textarea>";
die;
