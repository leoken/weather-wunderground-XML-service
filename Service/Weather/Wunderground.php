<?php
require_once 'Service/Abstract.php';

class Service_Weather_Wunderground extends Service_Abstract
{
	public $city, $state, $temperature;
	
	private $xml;
	
	/**
	 * wunderground url for xml retrieval
	 * @var string
	 */
	const WEATHER_SERVICE_URL = 'http://api.wunderground.com/auto/wui/geo/ForecastXML/index.xml?query=%s';
	
	/**
	 * Check if city and state is entered	 * 
	 * @param string $city
	 * @param string $state
	 */
	function __construct($city = null, $state = null)
	{
		if(empty($city) || empty($state)) {
			trigger_error("| City and State can't be null | ", E_USER_ERROR);
		}
		
		$this->city = $city;
		$this->state = $state;
	} 	
	
	/**
     * set if european or american standard
     */		    
	public function setTemperature($temperature)
	{		
		$this->temperature = $temperature;		
	}
	
	/**
     * show the output
     */	
	public function parse()
	{   
		$this->_host = self::WEATHER_SERVICE_URL;
		
		$this->xml = $this->makeXMLRequest(array($this->city, $this->state));
			
		$output = '';
		foreach($this->xml->simpleforecast as $fc) {			
			
			$output = '';
			for($i=0; $i<3; $i++) {
				
				$temperature = ($this->temperature == 'F') ? fahrenheit : celsius;
				
				$output .= '	
					<ul>
						<li>' . $fc->forecastday[$i]->date->month . '/' . $fc->forecastday[$i]->date->day . '/' . $fc->forecastday[$i]->date->year . '</li>
						<li>High: ' . $fc->forecastday[$i]->high->$temperature . ' degrees ' . $this->temperature . '</li>
						<li>Low: ' . $fc->forecastday[$i]->low->$temperature . ' degrees ' . $this->temperature . '</li>
					</ul>
				';			
				
				$totalHigh += $fc->forecastday[$i]->high->$temperature;
				$totalLow += $fc->forecastday[$i]->low->$temperature;					
			}						
		}		
		
		$data = array('city'		=> $this->city,
					  'state'       => $this->state,
					  'avarageHigh' => number_format($totalHigh / 3, 0),
					  'avarageLow'  => number_format($totalLow / 3, 0),
				);
		
		echo '
			<p>
				<strong>' . $data['city'] . ', ' . $data['state'] . '</strong><br />
				Average High for next three days: ' . $data['avarageHigh'] . ' degrees ' . $this->temperature . '<br />
				Average Low for next three days: ' . $data['avarageLow'] . ' degrees ' . $this->temperature . '
			</p>
			
			' . $output . ' 
		';		
	}
}