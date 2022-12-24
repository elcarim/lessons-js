<?
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

include "get-remote-data.php";
include "phpQuery/phpQuery.php";

$urlData = get_remote_data("https://time.is/");

$data = [];
$doc = phpQuery::newDocument($urlData);
$data = $doc->find('#clock')->text();

print_r($data);

// die(json_encode(array(
//   'error' => 0, 
//   'result' => $result,
//   'id' => $i
// )));


