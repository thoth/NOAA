<?php
class Weather extends NoaaAppModel {

	var $useTable = false;
	public $name = 'Weather';
	var $cacheFolder = '';
	

	function getCacheFile($filename){
		$filename = TMP.$this->cacheFolder.$filename.'.txt';
		if( !file_exists($filename) ){
			$handle = fopen($filename, "w+");
			fwrite($handle,'empty');
			fclose($handle);
			$last_modified = strtotime('10000 hours ago');
		} else {
			$last_modified = filemtime($filename);
					
		}
		if($last_modified > strtotime(Configure::read('NOAA.refresh_interval').' hours ago')){
			$handle = fopen($filename, "r");
			$contents = fread($handle, filesize($filename));
			fclose($handle);
		} else {
			$contents = $this->getWeather();
			$this->saveCacheFile($contents, $filename);			
		}

		$xml = Xml::toArray(Xml::build($contents));
		return $xml;
	}
	
	private function saveCacheFile($data,$filename){
		touch($filename);
		$fp = fopen($filename, 'w');
		fwrite($fp, $data);
		fclose($fp);
	}

	private function getWeather(){
		CakeLog::write('debug', 'New file: '.Configure::read('NOAA.noaa_weather_feed'));
		return $this->send_request(Configure::read('NOAA.noaa_weather_feed'));	
	}
	
	private function send_request($url, $xml=''){
		App::uses('HttpSocket', 'Network/Http');
		
		$HttpSocket = new HttpSocket();
		
		$request = $HttpSocket->get($url);	
		
		return $request;
	} 
	
	function getTemperature() {
		$now = time();
		
		$filename = TMP.'weather_conditions_'.date('YmdH',$now).'00.txt';
		
		if (!file_exists($filename)) {
			$latest = $this->getSnotel();
		
			if (!empty($latest)) {
				foreach (glob(TMP.'weather_conditions_*') as $oldfile) {
					unlink($oldfile);
				}
				
				$conditions = $latest;
				
				$log = fopen($filename,'w+');
				fwrite($log,implode(',', $conditions));
				fclose($log);
			}
		}
		
		if (empty($conditions)) {
			$conditions = explode(',', file_get_contents($filename));
		}
		return $conditions;
	}
	
	private function getSnotel() {
		$url = Configure::read('NOAA.snotel_feed');
		$report = stream_get_contents(fopen($url,'r'));
		$report = str_replace("\n",'',$report);
		
		$date = $this->get_pattern(1, $report);
		
		$hour = $this->get_pattern(2, $report);
		$time = substr($hour,0,2).":00:00";
		
		$tmp = $this->get_pattern(6, $report);
		
		$real_date = strtotime("$date $time PST");
		
		$date = date('Y-m-d H:i:s T', $real_date);
		
		return array($date, $tmp);
	}
	
	private function get_pattern($pos, $report) {
		$pattern = '!<tr>(<td align=(center|right)*>([\d\.-]*)</td>){'.$pos.'}!';
		preg_match_all($pattern, $report, $out);
		return array_pop(array_pop($out));
	}	 
}
?>
