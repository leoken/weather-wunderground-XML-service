<?php 
require_once 'Service/Weather/Wunderground.php';

// wu API settings
$settings['wunderground'] = array (
	'city'  	  => 'New York',
	'state' 	  => 'NY',
	'temperature' => 'C' // F or C
);

$weatherU = new Service_Weather_Wunderground($settings['wunderground']['city'], $settings['wunderground']['state']);
$weatherU->setTemperature($settings['wunderground']['temperature']);
$weatherU->parse();
