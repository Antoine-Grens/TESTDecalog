<?php

require __DIR__ . '/vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
$loader = new FilesystemLoader(__DIR__ . '/templates');
$twig = new Environment($loader);


$url = 'https://www.maisonapart.com/article.json';

$contentJSON = file_get_contents($url);

$content = json_decode($contentJSON, 1);

$docs = $content['response']['docs'];

$myDocs = array();

$stop = 1;
$i = 0;
foreach($docs as $doc){

	$date = $doc['timestamp'];
	$exploded = explode('T', $date);
	$dateFinal = date('d/m/Y', strtotime($exploded[0]));

	$myDoc = array(
		'title' => $doc['label'],
		'rubrique' => strtoupper(trim($doc['sm_theme'][0])),
		'teaser' => $doc['teaser'],
		'image_url' => $doc['sm_image_url'][0],
		'date' => $dateFinal,
		'url' => $doc['path']
	);

	$myDocs[] = $myDoc;

}


echo $twig->render('header.html.twig', array());
echo $twig->render('articles.html.twig', array('docs' => $myDocs));
echo $twig->render('footer.html.twig', array());

