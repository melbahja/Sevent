<?php
/**
 * @package   Sevent
 * @author    Mohamed Elbahja <Mohamed@elbahja.me>
 * @copyright 2016 Dinital 
 * @version   1.1
 * @link http://www.dinital.com
 */

class Sevent
{

	/**
	 * server sent events default headers
	 * @var array
	 */
	protected $eventHeaders = array(
		'Content-Type' 	=> 'text/event-stream',
		'Cache-Control' 	=> 'no-cache'
	);

	/**
	 * default options
	 * @var array
	 */
	protected $defOptions;


	/**
	 * Construct
	 */
	public function __construct()
	{
		ob_start();	

		$this->defOptions = array(
			'retry'	=> 5000,
			'id'		=> uniqid(), 
		);
	}

	/**
	 * set response headers
	 * @param  array  $headers 
	 * @return void
	 */
	public function header(array $headers = array())
	{

		if (headers_sent($f, $l) === true) {

			exit("Error: headers already sent, file: {$f} - at line: {$l}");
		}

		$headers = array_merge($this->eventHeaders, $headers);

		foreach ($headers as $key => $val) {

			header("{$key}: {$val}");
		}
    
	}

	/**
	 * server response
	 * @param  callable $func
	 * @return void
	 */
	public function response($func)
	{
		
		if (is_callable($func) === false) {
			
			exit;
		}

  		$func();
  		
  		ob_flush();
	}

	/**
	 * __call method
	 * @param  string $event event name
	 * @param  array $args  
	 * @return string
	 */
	public function __call($event, $args)
	{

		$data		= (array_key_exists(0, $args) === true) ? $args[0] : NULL;
		$options = (array_key_exists(1, $args) === true && is_array($args[1]) === true) ?  $args[1] : array();
		$options = array_merge($this->defOptions, $options);

		echo 'event: ' . $event . PHP_EOL . 'id: ' . $options['id'] . PHP_EOL . 'retry: ' . $options['retry'] . PHP_EOL . 'data: ' . $data . PHP_EOL . PHP_EOL;
	}

}
