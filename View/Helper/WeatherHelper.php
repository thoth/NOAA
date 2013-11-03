<?php 

class WeatherHelper extends AppHelper {
/**
 * name property
 *
 * @var string 'Tree'
 * @access public
 */
	var $name = 'Weather';
/**
 * settings property
 *
 * @var array
 * @access private
 */
	var $__settings = array();
/**
 * helpers variable
 *
 * @var array
 * @access public
 */
	var $helpers = array ('Html');
	var $cache = false;
	var $weather = null;
	var $view = null;
/**
 * constructor
 */

	function __construct(View $view, $settings = array()){
		parent::__construct($view, $settings);

		if(array_key_exists('weather_data', $this->_View->viewVars)){
			$this->cache = $this->_View->viewVars['weather_data'];
			
		} else {
			$this->cache = false;
			
		}
	}

	function current_temp(){
			
		//convert return to xml object
		if(array_key_exists('temperature_data', $this->_View->viewVars)){
			$cache = $this->_View->viewVars['temperature_data'];
		} else {
			$cache = false;
		}
		if($cache){
			return($cache[1]);
			exit();				
		}
		
	}

	function current_conditions_date(){		
		//convert return to xml object
		if($this->cache){
		
			foreach($this->cache['dwml']['data'] as $v){
				if($v['@type'] == 'forecast'){

					return(date('Y-m-d H:i', strtotime(date('Y-m-d').' 06:00')));
					exit();				
				}
			}		
		}
	}
	function current_conditions_abbreviated(){		
		//convert return to xml object
		if($this->cache){
			foreach($this->cache['dwml']['data'] as $v){
				if($v['@type'] == 'forecast'){
					return($v['parameters']['weather']['weather-conditions'][0]['@weather-summary']);
					exit();				
				}
			}		
		}
	}
	function current_conditions_full(){
		
		//convert return to xml object
		if($this->cache){
			foreach($this->cache['dwml']['data'] as $v){
				if($v['@type'] == 'forecast'){
					return($v['parameters']['wordedForecast']['text'][0]);
					exit();				
				}
			}		
		}
	}
	function weather_icon($which = 1){
		
		//convert return to xml object
		if($this->cache){
		
			foreach($this->cache['dwml']['data'] as $v){
				if($v['@type'] == 'forecast'){
					return($v['parameters']['conditions-icon']['icon-link'][$which - 1]);
					exit();				
				}
			}		
		}
	}
  
	function conditions_full($which = 1){
		
		//convert return to xml object
		if($this->cache){
			foreach($this->cache['dwml']['data'] as $v){
				if($v['@type'] == 'forecast'){
					return($v['parameters']['wordedForecast']['text'][$which - 1]);
					exit();				
				}
			}		
		}
	}
  
	function visibility_current($which = 1){
		
		//convert return to xml object
		if($this->cache){
			foreach($this->cache['dwml']['data'] as $v){
				if($v['@type'] == 'current observations'){
					foreach($v['parameters']['temperature'] as $t){
						if($t['@type'] == 'apparent'){
							return($t['value']);
							exit();				
						}
					}
				}
			}		
		}
	} 
  
	function wind_speed_current($which = 1){
		
		//convert return to xml object
		if($this->cache){
			foreach($this->cache['dwml']['data'] as $v){
				if($v['@type'] == 'current observations'){
					foreach($v['parameters']['wind-speed'] as $t){
						if($t['@type'] == 'sustained'){
							return($t['value'].' '.$t['@units']);
							exit();				
						}
					}
				}
			}		
		}
	} 
  
	function wind_direction_current($which = 1){
		
		//convert return to xml object
		if($this->cache){
			foreach($this->cache['dwml']['data'] as $v){
				if($v['@type'] == 'current observations'){
					if($v['parameters']['direction']['@type'] == 'wind'){
					
						$compass =array("N","NNE","NE","NEE","E","SEE","SE","SSE","S","SSW","SW","SWW","W","NWW","NW","NNW");

						$compcount = round($v['parameters']['direction']['value'] / 22.5);
						$compdir = $compass[$compcount];
					
						return($compdir);
						exit();				
					}
				}
			}		
		}
	} 
  
	function temperature_current($which = 1){
		
		//convert return to xml object
		if($this->cache){
			foreach($this->cache['dwml']['data'] as $v){
				if($v['@type'] == 'current observations'){
					foreach($v['parameters']['temperature'] as $t){
						if($t['@type'] == 'apparent'){
							return($t['value']);
							exit();				
						}
					}
				}
			}		
		}
	} 
  
	function temperature_minimum($which = 1){
		
		//convert return to xml object
		if($this->cache){
			foreach($this->cache['dwml']['data'] as $v){
				if($v['@type'] == 'forecast'){
					foreach($v['parameters']['temperature'] as $t){
						if($t['@type'] == 'minimum'){
							return($t['value'][$which - 1]);
							exit();				
						}
					}
				}
			}		
		}
	} 
	
	function temperature_maximum($which = 1){
		
		//convert return to xml object
		if($this->cache){
			foreach($this->cache['dwml']['data'] as $v){
				if($v['@type'] == 'forecast'){
					foreach($v['parameters']['temperature'] as $t){
						if($t['@type'] == 'maximum'){
							return($t['value'][$which - 1]);
							exit();				
						}
					}
				}
			}		
		}
	}

}