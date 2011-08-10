<?php
class General_model extends CI_Model {
	function General_model()
	{
		parent::__construct();
		$this->load->library('image_lib');
	}
	
	
	function add_photo($photo_name)
	{
		$folder='images/photos/';
		$y=date('Y/');
		if(!is_dir($folder.$y)) mkdir($folder.$y);
		$m=date('m/');
		if(!is_dir($folder.$y.$m)) mkdir($folder.$y.$m);
		$d=date('d/');
		if(!is_dir($folder.$y.$m.$d)) mkdir($folder.$y.$m.$d);
		$folder='images/photos/'.$y.$m.$d;
	}
	
	function remove_photo($photo_id='',$photo_date='',$photo_path='')
	{
		if(empty($photo_id)) return false;
                if(empty($photo_date) || empty($photo_path))
                {
                    $res = $this->db->where(array('photo_id' => $photo_id))->get('photo')->first_row();
                    $path=$res->photo_path;
                    if(empty($photo_date))
                    {
			$tgl = $this->db->where('photo_id='.$photo_id)->get('photo')->first_row();
                        $photo_date = $tgl->photo_date;
                    }
                }
		
		
		$folder='images/photos/'.date("Y/m/d/",strtotime($photo_date));
		
		@unlink($folder.$photo_path);
		$path2=pathinfo($photo_path);
		@unlink($folder.$path2['filename'].'-120x120.'.$path2['extension']);
		@unlink($folder.$path2['filename'].'-360x360.'.$path2['extension']);
		@unlink($folder.$path2['filename'].'-720x720.'.$path2['extension']);

                $user_comment_list = $this->db->query("SELECT user_id,user_fbuid FROM user WHERE user_id IN (SELECT user_id FROM comment WHERE pointphoto_id='$photo_id' AND comment_type=0)")->result();

		$this->db->query("DELETE FROM user_comment_rate WHERE comment_id IN (SELECT comment_id FROM comment WHERE pointphoto_id='$photo_id' AND comment_type=0)");
                $this->db->where(array('photo_id' => $photo_id))->delete(array('photo','user_photo'));
                $this->db->where(array('pointphoto_id' => $photo_id,'comment_type' => 0))->delete(array('comment'));                

                foreach ($user_comment_list as $key => $val) {
                    //echo $val->user_fbuid.'-'.$val->user_id;
                    $this->update_user_point($val->user_id,$val->user_fbuid);
                }

	}


        function save_photo($point_id='')
        {
            
            if(empty($point_id))return false;
            $i=0;
            
            
            while(@$_FILES['photos_'.$i]['error']===0) {
                if(empty($_POST['photos_name_'.$i])) {$i++; continue;}
               // echo $_FILES['photos_'.$i]['name'];
                // echo $point_id;
                //buat folder jika tidak ada
                $folder='images/photos/';
                $y=date('Y/');
                if(!is_dir($folder.$y)) mkdir($folder.$y);
                $m=date('m/');
                if(!is_dir($folder.$y.$m)) mkdir($folder.$y.$m);
                $d=date('d/');
                if(!is_dir($folder.$y.$m.$d)) mkdir($folder.$y.$m.$d);
                $folder='images/photos/'.date('Y/m/d/');

                //selesai buat folder
                $dbin=array(
                    'photo_path' =>$_FILES['photos_'.$i]['name'],
                    'photo_date' => date('Y-m-d H:i:s'),
                    'user_id' => get_sess('uid'),
                    'point_id' => $point_id,
                    'photo_name' => $_POST['photos_name_'.$i]
                );
                $this->db->insert('photo',$dbin);

                $id='';
                //jika sudah ada, tambahkan dengan id dan update photo_path di db
				
				$name=pathinfo($_FILES['photos_'.$i]['name']);
                if(is_file($folder.$name['filename'].'-120x120.'.$name['extension']))
                {
                    // echo "dah ada ";
                    $id= $this->db->insert_id();
                    //echo $id;
                    $dbin = array(
                        'photo_path' => $id.$_FILES['photos_'.$i]['name']
                    );
                    //var_dump($dbin);
                    $this->db->where(array('photo_id' =>$id))->update('photo', $dbin);
                    //echo $this->db->last_query();
                }

                $path =  $folder;
                $flname = $id.$_FILES['photos_'.$i]['name'];
                move_uploaded_file($_FILES['photos_'.$i]['tmp_name'],$path.$flname);
                $this->resize_gambar($path,$flname,120,120,'-120x120');
                $this->resize_gambar($path,$flname,240,320,'-360x360');
                $this->resize_gambar($path,$flname,720,720,'-720x720');
                // unlink($dest);
				unlink($path.$flname);
                $i++;
            }
            
            return true;

        }


        function save_photo_single($point_id)
        {
             if(empty($point_id))return false;


             if($_FILES['photo']['error']===0) {
               
                //buat folder jika tidak ada
                $folder='images/photos/';
                $y=date('Y/');
                if(!is_dir($folder.$y)) mkdir($folder.$y);
                $m=date('m/');
                if(!is_dir($folder.$y.$m)) mkdir($folder.$y.$m);
                $d=date('d/');
                if(!is_dir($folder.$y.$m.$d)) mkdir($folder.$y.$m.$d);
                $folder='images/photos/'.date('Y/m/d/');

                //selesai buat folder
                $dbin=array(
                    'photo_path' =>$_FILES['photo']['name'],
                    'photo_date' => date('Y-m-d H:i:s'),
                    'user_id' => get_sess('uid'),
                    'point_id' => $point_id,
                    'photo_name' => $_POST['photo_name']
                );
                $this->db->insert('photo',$dbin);
                $insert_id = $this->db->insert_id();
                $id='';
                //jika sudah ada, tambahkan dengan id dan update photo_path di db
                $name=pathinfo($_FILES['photo']['name']);
                if(is_file($folder.$name['filename'].'-120x120.'.$name['extension']))
                {
                    // echo "dah ada ";
                    $id= $insert_id;
                    //echo $id;
                    $dbin = array(
                        'photo_path' => $id.$_FILES['photo']['name']
                    );
                    //var_dump($dbin);
                    $this->db->where(array('photo_id' =>$id))->update('photo', $dbin);
                    //echo $this->db->last_query();
                }

                $path =  $folder;
                $flname = $id.$_FILES['photo']['name'];
                move_uploaded_file($_FILES['photo']['tmp_name'],$path.$flname);
                $this->resize_gambar($path,$flname,120,120,'-120x120');
                $this->resize_gambar($path,$flname,240,320,'-360x360');
                $this->resize_gambar($path,$flname,720,720,'-720x720');
                // unlink($dest);
                unlink($path.$flname);
                return $insert_id;
            }
            return false;
        }



    function resize_gambar($path='',$flname='',$w,$h,$postfix='')
    {
        
        $flname=pathinfo($flname);
        $config['source_image'] = $path.$flname['basename'];
        $config['new_image'] = $path.$flname['filename'].$postfix.'.'.$flname['extension'];
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $w;
        $config['height'] = $h;
        $this->image_lib->initialize($config);
        $this->image_lib->resize();
    }

}