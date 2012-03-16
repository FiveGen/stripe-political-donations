<?php

/* How to use this Class from /www
 * 
 * require_once(dirname(dirname(__FILE__))."/libraries/Loggly.php");
 * 
 * $logg = new Loggly('fc1642f5-700c-4a01-8bcf-134ee8e750d5');
 * $log_item = array("something"=>"value", "another_key"=>"value", "some_other_key"=>"value");
 * $logg->ly($log_item, 'json');
 * 
 * OR
 *
 * $logg = new Loggly('fc1642f5-700c-4a01-8bcf-134ee8e750d5');
 * $log_item = "A string log entry goes here.";
 * $logg->ly($log_item);
 * 
 */


require_once('php-httpclient/HttpClient.class.php');

class Loggly {
	protected $loggly_api = 'logs.loggly.com';
	protected $uuid;
	
	function __construct($uuid) {
		$this->client = new HttpClient($this->loggly_api);
		$this->uuid = $uuid;
	}
	
	function ly($log_item, $type='plain') {
		switch($type) {
			case 'json':
				$content_type = array('Content-Type'=>'application/json');
				$payload = json_encode($log_item);
				break;
			case 'plain':
			default:
				$content_type = array('Content-Type'=>'text/plain');
				$payload = (string) $log_item;
				break;
		}
		$response = $this->client->post('/inputs/'.$this->uuid, $payload, $content_type);
		if($this->client->getStatus() == 200) {
			// It's all good
		} else {
			trigger_error('Logging action failed!', E_USER_ERROR);
		}
	}
	
	public function pr($v, $prefix='') {
		if(gettype($v)=='boolean'){
			echo '<pre>'. $prefix;
			echo ($v) ? 'true' : 'false';
			echo '</pre>'."\n";
		} else {
			echo '<pre>'. $prefix . print_r($v, true) .'</pre>'."\n";
		}
	}
}

