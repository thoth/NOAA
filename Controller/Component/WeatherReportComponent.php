<?php
App::uses('Component', 'Controller');
class WeatherReportComponent extends Component {

  var $Controller;

  function initialize(Controller $controller) {
    	$this->Controller = $controller;
		//$this->Controller->loadModel('Noaa.Weather');
		//App::Import('Model', 'Noaa.Weather');
		//$weather_data = new Weather();
//debug($weather_data); exit();		
/*
		if($this->Controller->name == 'Weather'){
			$weather_data = $this->Controller->Weather->getCacheFile('weather');
			$controller->set(compact('weather_data'));
		}
*/

		App::Import('Model', 'Noaa.Weather');
		$weatherModel = new Weather();
	//debug($weather_data); exit();		
		$weather_data = $weatherModel->getCacheFile('weather');
		$temperature_data = $weatherModel->getTemperature();
	//debug($temperature_data); exit();	
		$controller->set(compact('weather_data', 'temperature_data'));


  }
  
  function getData(){
	  
  }
  
}