<?php
// developed by Red V!per
error_reporting(0);

include("CMS_Detector.class.php");

if (isset($argv)) {
    $url = $argv[1];
}

$opts = array('http' =>
    array(
        'method'  => 'GET',
        'timeout' => 10 
         )
);

$context=stream_context_create($opts);

$content=file_get_contents($url, false, $context);


//$content=file_get_contents($url);

$apps=CMS_Detector::process($content);
foreach($apps as $app)
{
	$url=CMS_Detector::appToURL($app);
	echo "<a href='$url'>$app</a>";
	echo "<br />";
}

?>
