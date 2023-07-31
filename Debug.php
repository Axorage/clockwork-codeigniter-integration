<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**==================================================================================
 * ?                                ABOUT
 * @author         :  Axorage
 * @repo           :  https://github.com/Axorage/clockwork-codeigniter-integration
 * @createdOn      :  03/30/23
 * @version    	   :  1.0.0
 * @description    :  Debug library that acts as an intermediate between the 
 * 					  application logs and the library used to interpret these logs
 *=================================================================================**/

class Debug {
		
	/**
	 * Construct main class function
	 *
	 * @return object The Debug class instance
	 */
	public function __construct(){
		
        /*------- Codeigniter Instance -------*/
		$this->CI =& get_instance();

		/*------- Set the config type to Clockwork Debugger -------*/
		$this->_config['type'] = "clk";

		/*------- Make clockwork instance only once -------*/
		if ( !isset($this->clockwork) ) {

			/*------- Make array from url segments -------*/
			$baseUrl = explode("/", if_secure_base_url());

			/*------- Remove the protocol prefix and domain from the array -------*/
			$baseUrlSegments = array_slice($baseUrl, 3);

			/*------- Make base url array to string and append __clockwork for the api  -------*/
			$finalBaseUrl = implode("/", $baseUrlSegments);
			$clockworkApiUrl = $finalBaseUrl . '__clockwork/';

			/*------- Create logs path -------*/
			$clockworkLogsPath = '../clockworklogs/';

			/*------- If the clockwork logs folder doesn't exist -------*/
			if( !is_dir($clockworkLogsPath) ){

				/*------- Create it -------*/
				mkdir($clockworkLogsPath, 0755, TRUE);
			}

			/*------- Init the clockwork library  -------*/
			$this->clockwork = Clockwork\Support\Vanilla\Clockwork::init([
				'enable' =>  true, // Enable clockwork library
				'api' => $clockworkApiUrl, // Api Url (Returns a json with the clockwork logs)
				'storage_files_path' => $clockworkLogsPath, // Set the logs path
				'web' => [ // The Web UI
					'enable' => true, // Enable web user interface
					'path' => './clockworkweb', // Path where to install the Web UI assets, should be publicly accessible
					'uri' => '../clockworkweb' // Public URI where the installed Web UI assets will be accessible
				]
			]);
		}
	}


	/**
	 * Print a log message on the debugger
     *
	 * @param string $message The message to show as a description
	 * @param mixed $value The value to show on the log
     * @param string $level The level of the log, options: v - view, c - controller, m - model, l - library, h - helper, f - framework, a - application, p - permissions
	 * @param string $type The type of the log, options: emergency, alert, critical, error, warning, notice, info, debug
	 * @return void
	 */
	public function log( string $message, $value, $level = 'c', $type = 'info' ){
		
		/*------- Get the backtrace from the log -------*/
		$logTrace = debug_backtrace();
		
		/*------- If the class from the log is empty -------*/
		if ( empty($logTrace[1]['class']) ) {

			/*------- Set the class as the name of the php file from where it comes from -------*/
			$logTrace[1]['class'] = basename( $logTrace[0]['file'], ".php" );
		}

		/*------- Switch the config type -------*/
		switch ( $this->_config['type'] ) {

			/*------- Clockwork Debugger -------*/
			case 'clk':

				/*------- If the log comes from a model -------*/
				if ( $level == "m" )  {

					/*------- Log to clockwork a database query -------*/
					$this->clockwork->addDatabaseQuery( $message . "\n" . print_r($value, true), [], NULL, [
						'file'       => $logTrace[0]["file"],
						'line'       => $logTrace[0]["line"],
						'trace'      => (array) $logTrace[1],
						'model'      => $logTrace[1]["class"],
					]);

				/*------- If the log doesn't come from a model -------*/
				} else {

					/*------- Get the type of variable from value -------*/
					switch (gettype($value)){

						case 'object':

							/*------- Log the message with the object in a new line -------*/
							$this->clockwork->log($type, $message . "\n" . json_encode($value, JSON_PRETTY_PRINT));

						break;

						case 'array':

							/*------- Log the array with the message -------*/
							$this->clockwork->log($type, $message, $value);

						break;

						default:

							/*------- Append the value to the message in a new line -------*/
							$this->clockwork->log($type, $message . "\n" . $value);

						break;
					}
				}
			break;
		}
	}
		
	
    /**
     * Log an event into the timeline of the debugger
     *
     * @param  string $label A description of the event (Only used with action start)
     * @param  string $name The name of the event, has to be the same on both actions (Used for start and end of the event)
     * @param  string $action Whether to start or end the event, options: start, end
     * @param  string $level The level of the log, options: v - view, c - controller, m - model, l - library, h - helper, f - framework, a - application, p - permissions
     * @param  string $color The color of the timeline, options: blue, red, green, purple, grey
     * @return void
     */
    public function event( string $label, string $name, string $action, string $level = 'c', string $color = 'blue' ) {

		/*------- Switch the debug type -------*/
		switch( $this->_config['type'] ){

			/*------- Clockwork Debugger -------*/
			case 'clk':

				/*------- If action is start -------*/
				if ( $action == 'start' ){

					/*------- Log the start of the event -------*/
					$this->clockwork->event($label)->color($color)->name($name)->start();

					/*------- If action is end -------*/
				} elseif ( $action == 'end' ) {

					/*------- Log the end of the event -------*/
					$this->clockwork->event($name)->end();
				}
			break;
		}
    }
}


/* End of file Debug.php */
/* Location: application/libraries/Debug.php */