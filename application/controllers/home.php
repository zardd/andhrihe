<?php

class Home extends MY_Controller {

	function Home()
	{
		parent::MY_Controller();	
	}
	function _remap($method,$params = array()){
		if (method_exists($this, $method))
		{
			call_user_func_array(array($this, $method), $params);
		}
		else if(empty($method))
		{
			call_user_func_array(array($this, 'index'), $params);
		}
		else
		{
			//redirection selain nama method yang ada dan index
			show_404();
		}
	}
	function index($param='',$p='')
	{
		$this->load->view('home_view',$this->data);
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */