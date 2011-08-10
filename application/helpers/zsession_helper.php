<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();
if(!isset($_SESSION['perm_number']))  $_SESSION['perm_number']=1;

global $perm_map;	
$perm_map=array
	(
		'log_user' => 1,
		'logged' => 2,
		'post_comment' => 4,
		'edit_comment' => 4,
		'post_article' => 8,
		'edit_article' => 8,
		'delete_comment' => 16,		
		'delete_post' => 16,		
		'list_user' => 32,
		'delete_user' => 64,
		'add_category' => 128,
		'delete_category' => 128,
		'edit_category' => 128
	); 
	
function get_perm_list(){
	global $perm_map;
	return $perm_map;	
}
		
function cek_perm($str_action='')
{		
	global $perm_map;
	$perm_number=get_sess('perm_number');
	
	$data=array(128,64,32,16,8,4,2,1);
	$perm_action = $perm_map[$str_action];
	$highest_perm=127;
	$i=0;
	
	while($perm_number>=$perm_action && $i<(count($data)))
	{
		if($perm_number==$perm_action) return true;
		if($perm_number>$data[$i] && $data[$i]!=$perm_action)
		{
			$perm_number-=$data[$i];			
			if($perm_number==$perm_action) return true;
		}
		$i++; 
	}	
	return false;
}

function set_sess($var,$val)
{
	$_SESSION[$var]=$val;
}
function get_sess($var)
{
	if(isset($_SESSION[$var]))
		return $_SESSION[$var];
	else return FALSE;
}

function del_sess($var)
{
	unset($_SESSION[$var]);
}


/* End of file zsession_pi.php */
/* Location: ./system/plugins/zsession_pi.php */
