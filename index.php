<?php
ini_set('memory_limit','2048M');
// simple clean session
// $_SESSION = []; die;
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require 'vendor/autoload.php';

function loadWords(){
	// $_SESSION = [];
	if(empty($_SESSION['words'])){
		echo "First load\n";
		// Open dict's info, index and data.
		$start = time();
		
		$info = new skoro\stardict\Info('dict/en_vi.ifo');
		$index = new skoro\stardict\Index($info);
		$dict = new skoro\stardict\Dict($index);
		
		$gap = time() - $start;
		echo "{$gap}\n";

		$words = $dict->getIndex()->words;
		$_SESSION['words'] = $words;

		return $words;
	}

	$words = $_SESSION['words'];
	
	return $words;
};

function lookup($word){
	echo "FUCK";
	$words = loadWords();
	echo "words loaded";
    if (substr($word, -1) === '*') {
        $word = substr($word, 0, -1);
        $ln = mb_strlen($word);
        $matched = [];
        foreach ($words as $w => $data) {
            if (strncmp($word, $w, $ln) === 0) {
                $matched[$w] = $data;
            }
        }
        return $matched ? $matched : false;
    }
    else if (isset($words[$word])) {
        return [
            $word => $words[$word],
        ];
    }
    return false;
}

$search_term = isset($_GET['search_term']) ?  $_GET['search_term'] : 'hello';
$result = lookup($search_term);
var_dump($result);

if(!$result)
	echo "Can not find your search term: {$search_term}"; die;

var_dump($result); die;
