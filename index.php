<?php

include("CMS_Detector.class.php");
$content=file_get_contents($argv[1]);
$apps=CMS_Detector::process($content);
foreach($apps as $app)
{
	$url=CMS_Detector::appToURL($app);
	echo "$app".PHP_EOL;
}
