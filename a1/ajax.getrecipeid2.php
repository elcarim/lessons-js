<?
// ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

// include_once "config.inc.php";
// include_once "pdox/PdoxInterface.php";
// include_once "pdox/Pdox.php";

include "get-remote-data.php";

include "phpQuery/phpQuery.php";


// BEGIN DB SECTION
//DB
// $db = new \Buki\Pdox($dbconfig);

$postData = file_get_contents('php://input');
// $data = parse_str($postData);
$data = json_decode( $postData, true );
// echo json_encode($data['etap']);
// exit;

if ( $data['etap'] == 1 ) {
  $urlData = get_remote_data("https://recipe.org.ua");
  $doc = phpQuery::newDocument($urlData);
  preg_match( '|\/recipe\/(\d+)\/|i', $doc->find('.h3.text-danger.title-font')->attr('href'), $m ) ;

  print_r ( json_encode($m));
  // print_r($m);
  exit;
}
else if ( $data['etap'] == 2 )
{
  // $urlData = get_remote_data("https://recipe.org.ua/recipe/{$data['id']}/");
  $urlData = get_remote_data("https://cookyt.pro/recipe/ljogkij-salat-iz-svjokly-".(25049 - 6 + $data['id']));
  $doc = phpQuery::newDocument($urlData);

  echo json_encode(['id' => (25049 - 6 + $data['id']) . $doc->find('h1')->html()]);
  exit;
}
else
{
  // $postData = file_get_contents('php://input');
  // // $data = parse_str($postData);
  // $data = json_decode( $postData, true );
  echo json_encode($data);
  exit;
}

$i = $_GET['id'];

    $urlData = get_remote_data("https://cookyt.pro/recipe/ljogkij-salat-iz-svjokly-".$i);

  //  $urlData = get_remote_data("http://recipe.loc/grab/xxx.html");
    $data = [];
    $doc = phpQuery::newDocument($urlData);
    $data['youtubeurl'] = $doc->find('.video__link')->attr('href');
    $data['youtubeurl'] = str_replace ("https://youtu.be/", "", $data['youtubeurl']);
    // print_r($data['youtubeurl']);
    // echo "\n";

    $data['title'] = $doc->find('h1')->text();
    // print_r($data['title']);
    // echo "\n";

    $data['author'] = explode("<br>", $doc->find('[itemprop="author"]')->html());
    $data['author'] = trim($data['author'][0]);
    // print_r($data['author']);
    // echo "\n";

    $data['ingredients'] = trim(strip_tags($doc->find('div.desc')->html(), '<p><ul><li><br>'));
  //  print_r($data);
  //    echo "\n";

    $img = $doc->find('source:first')->attr('srcset');
    // print_r($img);

    // copy("https://cookyt.pro/".$img, $_SERVER['DOCUMENT_ROOT']."/grab/get-img-folder/".$i.".webp");

    


    if ($data['youtubeurl'])
    {
        // $data = [
//            'title' => trim($name[1]),
//            'ingredients' => trim($ingredients[1]),
//            'text' => trim($text[1]),
            // 'i' => $i,
//            'youtubeurl' => trim($yturl[1])
        // ];

        $data['i'] = $i;
        $db -> table('new_recipes')
            -> insert ( $data);
        $lastID = $db->insertId();
   	    $result = $yturl[1];

     $img = $doc->find('source:first')->attr('srcset');
    //  print_r($img);
 
     copy("https://cookyt.pro/".$img, "/www/recipe.org.ua/video-img/".$i.".webp");
//     copy("https://cookyt.pro/".$img, $_SERVER['DOCUMENT_ROOT']."/grab/get-img-folder/".$i.".webp");


     echo $lastID . " <> " .$data['youtubeurl'];

   }else
	   echo $result = "err";

exit;
      die(json_encode(array(
        'error' => 0, 
        'result' => $result,
        'id' => $i
      )));


