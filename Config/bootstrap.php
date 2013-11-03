<?php

Croogo::hookHelper('*', 'Noaa.Weather');
Croogo::hookComponent('*', 'Noaa.WeatherReport');

$cacheConfig = Cache::config('_cake_model_');
$cacheConfig = Hash::merge($cacheConfig['settings'], array(
	'prefix' => 'noaa_',
	'path' => CACHE . 'queries',
	'duration' => '+1 hour',
));
Cache::config('noaa', $cacheConfig);

$Localization = new L10n();


require 'admin_menu.php';
