<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('dbtime2format'))
{
    function dbtime2format($str)
    {
        return strftime("%d-%B-%Y %I:%M %p", strtotime($str));
    }
}

if ( ! function_exists('dbdate2format'))
{
    function dbdate2format($str)
    {
        return strftime("%d-%B-%Y", strtotime($str));
    }
}


if ( ! function_exists('dbday2format'))
{
    function dbday2format($str)
    {
        return strftime("%d-%B", strtotime($str));
    }
}

if ( ! function_exists('custom_strip_tags')) {
	function custom_strip_tags($str)
	{
		 return strip_tags($str,'<td><tr><table><th><b><em><strong><p><a><i>');
	}
}

if ( ! function_exists('array_remap')) {
	function array_remap($array, $mapping) {
                
		if( ! is_array($array)) return $array;
		$buffer = array();
                foreach($mapping as $k=>$v) {
		    if(isset($array[$k])) {
                
 		        $buffer[$v] = $array[$k];
		    } else {
		        $buffer[$v] = "";
                
		    }
		}
		if(empty($buffer)) return $array;
		return $buffer;
	}                                
}

if ( ! function_exists('array_coupling')) {
	function array_coupling($array) {
		if( ! is_array($array)) return FALSE;
                $col1='';
                $col2='';
                foreach ($array as $key => $value) {
                    $i=1;
                    foreach($value as $key2=>$val)
                    {
                        if($i==1) $col1=$key2;
                        else $col2=$key2;
                        $i++;
                        if($i>2)break;
                    }
                    break;
                }
                //echo $col1.'-'.$col2;
		$coupled = array();
                foreach($array as $k => $v) {
                    $coupled[$v[$col1]] = $v[$col2];
		}
		if(empty($coupled)) return FALSE;
		return $coupled;
	}
}

// saya lupa buat apa, tp definitely kepake..  :-(
if ( ! function_exists('array_coupling_awaldobel')) {
	function array_coupling_awaldobel($array) {
		if( ! is_array($array)) return FALSE;
                $col1='';
                $col2='';
                foreach ($array as $key => $value) {
                    $i=1;
                    foreach($value as $key2=>$val)
                    {
                        if($i==1) $col1=$key2;
                        else $col2=$key2;
                        $i++;
                        if($i>2)break;
                    }
                    break;
                }
                //echo $col1.'-'.$col2;
		$coupled = array();
                foreach($array as $k => $v) {
                    $coupled[$v[$col1].'|'.$v[$col2]] = $v[$col2];
		}
		if(empty($coupled)) return FALSE;
		return $coupled;
	}
}

if ( ! function_exists('paginate_number'))
{
	function paginate_number($count, $start=0, $uri,$side=2,$perhal=5,$yr="")
	{
				$total=floor((($count+$perhal)/$perhal));
				$hal=floor(($start+$perhal)/$perhal);
				if($count%$perhal==0) $total--;
				if($hal==0)$hal=1;
			?>
			
			<a class="all"><?php lang('trans.page');?> <?php echo "$hal ".lang('trans.of')." ".($total); ?></a>
			<a href="<?php echo site_url($uri.'1'.$yr);?>">First</a>
			<?php
				if($total<=4)
				
				for($i=0;$i<$total;$i++)
				{
					if(($i*$perhal+1)==$start)
						echo '<a class="per" href="'.site_url($uri.(($i*$perhal)+1).$yr).'">'.($i+1).'</a>';
					else
						echo '<a href="'.site_url($uri.(($i*$perhal)+1).$yr).'">'.($i+1).'</a>';
				}
				else
				for($i=$hal-$side;$i<$total && $i<($hal+$side);$i++)
				{
					
					if($i<0)$i=0;	
					if(($i*$perhal+1)==$start)
						echo '<a class="per" href="'.site_url($uri.(($i*$perhal)+1).$yr).'">'.($i+1).'</a>';
					else
						echo '<a href="'.site_url($uri.(($i*$perhal)+1).$yr).'">'.($i+1).'</a>';
				}	
					
				
			?>
			<a href="<?php echo site_url($uri.((($total-1)*$perhal)+1));?>">Last</a>
			<?php
	}
}

if ( ! function_exists('paginate_year'))
{
	function paginate_year($yeardata, $start=0, $uri,$side=3)
	{
				$yearnow=date("Y");
				$total = count($yeardata);
				$i=0;
				$hal = $start;
				
				$i=0;
				foreach($yeardata as $val)
				{
					$i++;
					if($val['tahun']==$start)
					{
						$hal=$i;
						break;
					}
				}
			?>
			
			<!--<a class="all">Page <?php echo "$hal of ".($total); ?></a>-->
			<!--<a href="<?php echo site_url($uri.$yearnow);?>">First</a>-->
			<?php
				$last;
				foreach($yeardata as $val)
				{
					if($val==$start)
					{
						echo '<a class="per" href="'.site_url($uri.$val['tahun']).'">'.$val['tahun'].'</a>';
					}
					else
					{
						echo '<a href="'.site_url($uri.$val['tahun']).'">'.$val['tahun'].'</a>';
					}
					$last=$val['tahun'];
				}
	}
}

if ( ! function_exists('parse_tag_p'))
{
	function parse_tag_p($str)
	{
		//$pattern='"<p>[^(<\/p>)]*</p>"';
		$pattern='"<p>.*</p>"';
		$match=array();
		//echo $pattern;
		preg_match ( $pattern , $str , $match);
		
		//preg_grep ( $pattern , $str , $match);
		if(!empty($match[0]))
		{
			//echo $match[0];
			return $match[0];
		
		}return "";

	}
}



if ( ! function_exists('string_strip'))
{
	function string_strip($str)
	{
		$rx = '/\s+/';
		$str = trim($str);
		$str = preg_replace($rx,' ',$str);
		$str = strtolower($str);
		$str = str_replace(" ","-",$str);
		$pattern = '/[^\w-]/';
		$replacement = '';
		$str = preg_replace($pattern, $replacement, $str);
		if(strlen($str)>0)
		if($str[strlen($str)-1] == "-")
			return substr($str,0,strlen($str)-1);
		return $str;
	}
}

if ( ! function_exists('ascii_encode'))
{
	function ascii_encode($str){
		$encoded="";
		for ($i=0; $i < strlen($str); $i++){
			$encoded .= '&#'.ord(substr($str,$i)).';';
		}
		return $encoded;
	}
}

if ( ! function_exists('generate_emailimg'))
{
	function generate_emailimg($str,$id,$path){
		$len = strlen($str)*9;
		$im = imagecreatetruecolor($len,20);
		$text_color = imagecolorallocate($im, 0, 0, 0);
		imagefilledrectangle($im, 0, 0, $len, 20, imagecolorallocate($im, 255, 255, 255));
		$font = './font/trebuc.ttf';
		imagettftext($im, 9.5, 0, 5, 15, $text_color, $font, $str);
		
		imagejpeg($im,$path.$id.'.jpeg');
		imagedestroy($im);		
	}
}

if( ! function_exists('potong_paragraf'))
{
	function potong_paragraf($str,$len=170)
	{
		$order   = array("\r\n", "\n", "\r");
		$str= trim(str_replace($order,' ',$str));
		
		
		if(strlen(trim($str))<=$len)
		{			
			if(strlen($str)==$len) $str.='...';			
		}
		else
		{
			$pattern="/(.){0,$len}[ ]{1}/";
			preg_match($pattern,$str,$match);
			if(!empty($match)) 
			{
				$str=trim($match[0]);
				//if(strlen(trim($match[0]))>=140) 
				$str.='...';
				
			}
		}
		return $str;
	}
}

/* End of file url_helper.php */
/* Location: ./system/helpers/url_helper.php */