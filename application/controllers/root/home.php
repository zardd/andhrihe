<?php

class Home extends MY_Controller {

	function Home()
	{
		parent::MY_Controller();	

	}
	function remap(){
		
	}
	function index()
	{
		//parent::index();
		$this->load->view(ADMINF.'home_view');

	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */