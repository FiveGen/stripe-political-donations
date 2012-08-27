<?php

require_once('./postmark/Postmark.php');

class EmailReceipt {
	
	private $meta;
	private $firstname;
	private $lastname;
	private $template = 'receipt';
	private $template_html;
	private $template_plain;
	
	public function __construct($meta) {
		global $postmarkKey, $postmarkFromAddress, $postmarkFromName, $postmarkSubject;
		
		// see if default exists
			// if it does, load and assign to $this->template_html
		// else, silent error and Logg.ly
		
		// see if default plaintext exists
			// if it does, load and assign to $this->template_html
		// else, silent error and Logg.ly
		
		$this->meta = $meta;
		
		if($this->meta['name']) $this->parse_name();
		
		// Postmark App receipt send
		$this->run_replacements();
		
		// Initiate Postmark
		define('POSTMARKAPP_API_KEY', $postmarkKey);
		define('POSTMARKAPP_MAIL_FROM_ADDRESS', $postmarkFromAddress);
		define('POSTMARKAPP_MAIL_FROM_NAME', $postmarkFromName);
		
		// Send
		Mail_Postmark::compose()
			->addTo($this->mate['email'], $this->meta['name'])
			->subject('Subject')
			->messagePlain($this->template_plain)
			->messageHtml($this->template_html)
			->send();
	}
	
	private function parse_name() {
		$names = explode(' ', $this->meta['name']);
		$this->meta['firstname'] = $names[0];
		if(strlen($this->meta['firstname'])==1 && count($names)==3) { $this->meta['firstname'] = $names[1]; }
		$this->meta['lastname'] = $names[(count($names)-1)];
	}
	
	private function run_replacements() {
		foreach($this->meta as $key -> $val) {
			$this->template_html = str_ireplace('%'.$key.'%', $val, $this->template_html);
		}
	}
}