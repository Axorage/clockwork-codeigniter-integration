<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**==================================================================================
 * ?                                ABOUT
 * @author         :  Axorage
 * @repo           :  https://github.com/Axorage/clockwork-codeigniter-integration
 * @createdOn      :  03/30/23
 * @version    	   :  1.0.0
 * @description    :  Clockwork Web UI Controller
 *=================================================================================**/

class Clockworkweb extends CI_Controller
{	
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
	 * @return array The web interface of the debugger
	 */
	public function index()
	{
        $this->CI->debug->clockwork->returnWeb();
        return;
	}
}

/* End of file clockworkweb.php */
/* Location: application/controllers/clockworkweb.php */