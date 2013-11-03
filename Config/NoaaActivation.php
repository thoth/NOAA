<?php
/**
 * NoaaActivation
 *
 * Activation class for Noaa plugin.
  *
 * @package  Croogo
 * @author   Tom Rader <tom.rader@claritymediasolutions.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://www.claritymediasolutions.com
 */		
class NoaaActivation {
	public function beforeActivation(&$controller) {
		return true;
	}

	public function onActivation(&$controller) {
        // ACL: set ACOs with permissions
        $controller->Croogo->addAco('Noaa'); // NOAAController
        $controller->Croogo->addAco('Noaa/Weathers/index', array('registered', 'public')); // NOAAController::index()

		$controller->Setting->write('NOAA.refresh_interval','1',array('description' => 'Refresh Interval (hours)','editable' => 1));
		$controller->Setting->write('NOAA.noaa_weather_feed','http://weather.gov/someplace',array('editable' => 1));
		$controller->Setting->write('NOAA.snotel_feed','http://',array('editable' => 1));


	}

	public function beforeDeactivation(&$controller) {
		return true;
	}

	public function onDeactivation(&$controller) {
        $controller->Croogo->removeAco('Noaa'); 
	}

}