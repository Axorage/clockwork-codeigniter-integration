<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**==================================================================================
 * ?                                ABOUT
 * @author         :  Axorage
 * @repo           :  https://github.com/Axorage/clockwork-codeigniter-integration
 * @createdOn      :  03/30/23
 * @version    	   :  1.0.0
 * @description    :  Clockwork library that ends the request from the clockwork instance
 *=================================================================================**/

class Clockwork {
	
	/**
	 * Construct main function
	 *
	 * @return void
	 */
	public function __construct(){

        /*------- Get CI instance -------*/
		$this->CI =& get_instance();
	}

    
    /**
     * End clockwork debugger request
     *
     * @return void
     */
    public function requestProcessed() {

        /*------- If Clockwork Debugger is being used -------*/
        if ( isset($this->CI->dbug->clockwork) ) {
            
            /*------- Get the data passed to views when loaded -------*/
            $cachedVars = $this->CI->load->_ci_cached_vars;
            // $this->CI->dbug->log('Loaded View',$cachedVars,'c'); // Debug
            
            /*------- Log the last view to the debugger -------*/
            $this->CI->dbug->clockwork->addView($cachedVars['view']);

            /*------- End log request -------*/
            $this->CI->dbug->clockwork->requestProcessed();
        }
        return;
    }
}

/* End of file Clockwork.php */
/* Location: application/libraries/Clockwork.php */