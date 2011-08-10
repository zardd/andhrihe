<?php
class MY_Controller extends CI_Controller {

    function MY_Controller()
    {
        parent::__construct();
		$this->data['page_title'] = 'Zardd';
    }
	
	function load_post_data()
    {
        foreach($_POST as $k => $v)
        {
            $this->data[$k]=$_POST[$k];
        }
        
    }
}