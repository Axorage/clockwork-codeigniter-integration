<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* **********************************************************************
 *
 * Copyright (C) ® 2005 - 2019 Enrique Ortiz Ramón.
 * Todos los Derechos Reservados
 *
 * Este Software esta protegido por los derechos de autor, el uso no
 * apropiado y el uso no autorizado de este material sin el consentimiento
 * por escrito del propietario de estos derechos violará los derechos de
 * propiedad intelectual.
 * Prohibida su reproducción, distribución, almacenamiento, modificación,
 * comercialización, venta o arrendamiento, generación de obras derivadas
 * sin previa autorización por escrito del titular de los derechos de
 * propiedad intelectual. La violación a esta prohibición constituye un
 * delito y una infracción, sancionados conforme a los artículos 424
 * fracción III del código Penal para el D.F. en materio de fuero común y
 * para toda la República en materia de fuero federal; 231 fracción I de
 * la Ley Federal del Derecho de Autor.
 *
 * **********************************************************************
 *
 * CLASS: Clockwork Library
 *
 * Description:
 *
 *  A class to initialize clockwork debugger early in application
 *
 * Typical Usage:
 *
 * Required Dependency Classes:
 *
 * Latest Changes:
 * Enrique Ortiz - SSL Validation and Copyright Update
 * 
 * **********************************************************************/
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


/* End of file clockwork.php */
/* Location: ./application/libraries/clockwork.php */