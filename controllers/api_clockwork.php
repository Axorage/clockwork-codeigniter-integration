<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**==================================================================================
 * ?                                ABOUT
 * @author         :  Axorage
 * @repo           :  https://github.com/Axorage/clockwork-codeigniter-integration
 * @createdOn      :  03/30/23
 * @version    	   :  1.0.0
 * @description    :  Clockwork API Controller
 *=================================================================================**/

class Api_clockwork extends CI_Controller {
		
	/**
	 * Construct main class function
	 *
	 * @return void
	 */
	public function __construct()
	{
		/*------- Construct parent and get CI instance -------*/
        parent::__construct();
		$this->CI =& get_instance();
	}
	

	/**
	 * Index base class function
	 *
	 * @param  int 		$clockworkId 	The id from the X-CLOCKWORK-ID header
	 * @param  string 	$argument 		Used to load newer or older requests in the web interface
	 * @param  string 	$limit 			An optional limit. Required for the web UI.
	 * @return array 	The corresponding log of the id and arguments as a json
	 */
	public function index( $clockworkId, $argument = NULL, $limit = NULL )
	{
        $this->CI->debug->clockwork->returnMetadata( $clockworkId . '/' . $argument . '/' . $limit );
        return;
	}	
}

/* End of file api_clockwork.php */
/* Location: application/controllers/api_clockwork.php */