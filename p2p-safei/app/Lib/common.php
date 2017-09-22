<?php
// +----------------------------------------------------------------------
// | Yuemor 越陌p2p借贷系统
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.yuemor.com All rights reserved.
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------

//app项目用到的函数库

/**
 * 获取页面的标题，关键词与描述
 */
if(FANWE)die();

function get_site_info()
{
	$shop_info['SHOP_TITLE']	=	app_conf('SHOP_TITLE');
	$shop_info['SHOP_KEYWORD']	=	app_conf('SHOP_KEYWORD');
	$shop_info['SHOP_DESCRIPTION']	=	app_conf('SHOP_DESCRIPTION');
	return $shop_info;
}

/**
 * 获取导航菜单
 */
function format_nav_list($nav_list)
{ 
		foreach($nav_list as $k=>$v)
		{
			if(trim($v['url'])!='')
			{
				if(substr($v['url'],0,7)!="http://" && substr($v['url'],0,8)!="https://" )
				{		
					//开始分析url
					$nav_list[$k]['url'] = APP_ROOT."/".$v['url'];
				}
			}
			else
			{
				preg_match("/id=(\d+)/i",$v['u_param'],$matches);
				$id = intval($matches[1]);
				if($v['u_module']=='article'&&$id>0)
				{
					$article = get_article($id);
					if($article['type_id']==1)
					{
						$nav_list[$k]['u_module'] = "help";
					}
					elseif($article['type_id']==2)
					{
						$nav_list[$k]['u_module'] = "notice";
					}
					elseif($article['type_id']==3)
					{
						$nav_list[$k]['u_module'] = "sys";
					}
					else 
					{
						$nav_list[$k]['u_module'] = 'article';
					}
				}
			}
		}
		return $nav_list;
}
function get_nav_list()
{
	return load_auto_cache("cache_nav_list");
}

function init_nav_list($nav_list)
{
	$u_param = "";
	foreach($_GET as $k=>$v)
	{
		if(strtolower($k)!="ctl"&&strtolower($k)!="act"&&strtolower($k)!="city")
		{
			$u_param.=$k."=".$v."&";
		}
	}
	if(substr($u_param,-1,1)=='&')
	$u_param = substr($u_param,0,-1);
	foreach($nav_list as $k=>$v)
	{			
		if(trim($v['url'])=='')
		{
				$route = $v['u_module'];
				if($v['u_action']!='')
				$route.="#".$v['u_action'];
				
				$app_index = $v['app_index'];
				
				if($v['u_module']=='index')
				{
					$route="index";
					$v['u_module'] = "index";
				}
				
				if($v['u_action']=='')
					$v["u_action"] = "index";
				
				$str = "u:".$app_index."|".$route."|".$v['u_param'];
				$nav_list[$k]['url'] =  parse_url_tag($str);
				if(($v['u_module']=='deals' || $v['u_module']=='transfer' || $v['u_module']=='tool') && MODULE_NAME==$v['u_module']){
					$nav_list[$k]['current'] = 1;
				}
				elseif($v['u_module']=='borrow' && MODULE_NAME==$v['u_module']){
					$nav_list[$k]['current'] = 1;
				}
				elseif(ACTION_NAME==$v['u_action']&&MODULE_NAME==$v['u_module']&&$v['u_param']==$u_param)
				{					
					$nav_list[$k]['current'] = 1;										
				}	
		}
	}
	return $nav_list;
}

function get_help()
{
	return load_auto_cache("get_help_cache");
}



//获取所有子集的类
class ChildIds
{
	public function __construct($tb_name)
	{
		$this->tb_name = $tb_name;	
	}
	private $tb_name;
	private $childIds;
	private function _getChildIds($pid = '0', $pk_str='id' , $pid_str ='pid')
	{
		$childItem_arr = $GLOBALS['db']->getAll("select id from ".DB_PREFIX.$this->tb_name." where ".$pid_str."=".intval($pid));
		if($childItem_arr)
		{
			foreach($childItem_arr as $childItem)
			{
				$this->childIds[] = $childItem[$pk_str];
				$this->_getChildIds($childItem[$pk_str],$pk_str,$pid_str);
			}
		}
	}
	public function getChildIds($pid = '0', $pk_str='id' , $pid_str ='pid')
	{
		$this->childIds = array();
		$this->_getChildIds($pid,$pk_str,$pid_str);
		return $this->childIds;
	}
}

//显示错误
function showErr($msg,$ajax=0,$jump='',$stay=0,$from="")
{
	if($ajax==1)
	{
		$result['status'] = 0;
		$result['info'] = $msg;
		$result['jump'] = $jump;
		header("Content-Type:text/html; charset=utf-8");
        echo(json_encode($result));exit;
	}
	else
	{
		
		$GLOBALS['tmpl']->assign('page_title',$GLOBALS['lang']['ERROR_TITLE']." - ".$msg);
		$GLOBALS['tmpl']->assign('msg',$msg);
		if($jump=='')
		{
			$jump = $_SERVER['HTTP_REFERER'];
		}
		if(!$jump&&$jump=='')
			$jump = APP_ROOT."/";
		$GLOBALS['tmpl']->assign('jump',$jump);
		$GLOBALS['tmpl']->assign("stay",$stay);
		if($from == "debit")
		{
			$GLOBALS['tmpl']->display("debit/debit_error.html");
		}
		else
		{
			$GLOBALS['tmpl']->display("error.html");
		}
		exit;
	}
}

//显示成功
function showSuccess($msg,$ajax=0,$jump='',$stay=0,$from="")
{
	if($ajax==1)
	{
		$result['status'] = 1;
		$result['info'] = $msg;
		$result['jump'] = $jump;
		header("Content-Type:text/html; charset=utf-8");
        echo(json_encode($result));exit;
	}
	else
	{
		$GLOBALS['tmpl']->assign('page_title',$GLOBALS['lang']['SUCCESS_TITLE']." - ".$msg);
		$GLOBALS['tmpl']->assign('msg',$msg);
		if($jump=='')
		{
			$jump = $_SERVER['HTTP_REFERER'];
		}
		if(!$jump&&$jump=='')
		$jump = APP_ROOT."/";
		$GLOBALS['tmpl']->assign('jump',$jump);
		$GLOBALS['tmpl']->assign("stay",$stay);
		if($from == "debit")
		{
			$GLOBALS['tmpl']->display("debit/debit_success.html");
		}
		else
		{
			$GLOBALS['tmpl']->display("success.html");
		}
		exit;
	}
}


//显示IPS成功
function showSuccessIPS($msg,$ajax=0,$jump='',$stay=0,$from="")
{
	if($ajax==1)
	{
		$result['status'] = 1;
		$result['info'] = $msg;
		$result['jump'] = $jump;
		header("Content-Type:text/html; charset=utf-8");
        echo(json_encode($result));exit;
	}
	else
	{
		$GLOBALS['tmpl']->assign('page_title',$GLOBALS['lang']['SUCCESS_TITLE']." - ".$msg);
		$GLOBALS['tmpl']->assign('msg',$msg);
		if($jump=='')
		{
			$jump = $_SERVER['HTTP_REFERER'];
		}
		if(!$jump&&$jump=='')
		$jump = APP_ROOT."/";
		$GLOBALS['tmpl']->assign('jump',$jump);
		$GLOBALS['tmpl']->assign("stay",$stay);
		if($from == "debit")
		{
			$GLOBALS['tmpl']->display("debit/debit_success.html");
		}
		else
		{
			$GLOBALS['tmpl']->display("success_ips.html");
		}
		exit;
	}
}

/**
 * 获取用户名
 */
if(!function_exists("get_user_name")){
	function get_user_name($id,$show_tag=true)
	{
		$key = md5("USER_NAME_LINK_".$id."_".$show_tag);
		if(isset($GLOBALS[$key]))
		{
			return $GLOBALS[$key];
		}
		else
		{
			$uname = load_dynamic_cache($key);
			if($uname===false)
			{
				$u = get_user_info("id,user_name","id = ".intval($id));
				if($show_tag)
					$uname = "<a href='".url("index","space",array("id"=>$id))."'  class='user_name'  onmouseover='userCard.load(this,".$u['id'].");' >".$u['user_name']."</a>";
				else
					$uname = $u['user_name'];
				set_dynamic_cache($key,$uname);
			}
			$GLOBALS[$key] = $uname; 
			return $GLOBALS[$key];
		}
	}
}

/**
 * 获取用户相应字段内容
 */
function get_user($extfield,$uid){
	$key = md5("USER_FILED_INFO_".$extfield.$uid);
	if(isset($GLOBALS[$key]))
	{
		return $GLOBALS[$key];
	}
	else
	{
		$user = load_dynamic_cache($key);
		if($user===false)
		{
			$user = get_user_info($extfield,"id = ".intval($uid));
			if($user){
				$user['point_level'] = $GLOBALS['db']->getOne("select name from ".DB_PREFIX."user_level where id = ".intval($user['level_id']));
				$user['url'] = url("index","space",array("id"=>$uid));
				if($user['city_id'])
					$user['region'] = $user['region_city'] = $GLOBALS['db']->getOne("select name from  ".DB_PREFIX."region_conf where id = ".intval($user['city_id']));
				
				if($user['province_id']){
					$user['region_province'] = $GLOBALS['db']->getOne("select name from  ".DB_PREFIX."region_conf where id = ".intval($user['province_id']));
					if(!$user['region'])
						$user['region'] = $user['region_province'];
				}
				if($user['id']){
					$user['workinfo'] = $GLOBALS['db']->getRow("select * from  ".DB_PREFIX."user_work where user_id = ".intval($user['id']));
					if($user['workinfo']){
						$user['workinfo']['region_province'] = $GLOBALS['db']->getOne("select name from  ".DB_PREFIX."region_conf where id = ".intval($user['workinfo']['province_id']));
						$user['workinfo']['region_city'] = $GLOBALS['db']->getOne("select name from  ".DB_PREFIX."region_conf where id = ".intval($user['workinfo']['city_id']));
					}
				}
					
			}
			set_dynamic_cache($key,$user);
		}
		$GLOBALS[$key] = $user; 
		return $GLOBALS[$key];
	}
}

/**
 * 获取用户所上传的认证材料
 */
function get_user_credit_file($uid,$user_info=false,$cache=true){
	$key = md5("USER_CREDIT_FILE_".$uid);
	if(isset($GLOBALS[$key]) && $cache==true)
	{
		return $GLOBALS[$key];
	}
	else
	{
		if($cache==true)
			$user_credit_file = load_dynamic_cache($key);
		else
			$user_credit_file = false;
		if($user_credit_file===false)
		{
			$field_array = array(
				"credit_identificationscanning"=>"idcardpassed",
				"credit_contact"=>"workpassed",
				"credit_credit"=>"creditpassed",
				"credit_incomeduty"=>"incomepassed",
				"credit_house"=>"housepassed",
				"credit_car"=>"carpassed",
				"credit_marriage"=>"marrypassed",
				"credit_titles"=>"skillpassed",
				"credit_videoauth"=>"videopassed",
				"credit_mobilereceipt"=>"mobiletruepassed",
				"credit_residence"=>"residencepassed",
				"credit_seal"=>"sealpassed",
			);
			
			if(!$user_info)
				$user_info =  get_user("*",$uid);
			
			$t_user_credit_file = $GLOBALS['db']->getAll("select uct.*,ucf.file,ucf.passed,ucf.passed_time,ucf.user_id from ".DB_PREFIX."user_credit_type uct LEFT JOIN ".DB_PREFIX."user_credit_file ucf  ON ucf.type=uct.type and ucf.user_id = ".intval($uid)." WHERE uct.is_effect =1  order by uct.sort ASC ");
			if($t_user_credit_file){
				foreach($t_user_credit_file as $k=>$v){
					unset($v['brief']);
					unset($v['description']);
		    		if($user_info[$field_array[$v['type']]]){
		    			if($user_info[$field_array[$v['type']]]>0){
		    				$v['status'] = 0;
		    			}
		    			$v['passed'] = $user_info[$field_array[$v['type']]];
		    			if($v['type']!="credit_seal")
		    				$v['passed_time'] = $user_info[$field_array[$v['type']]."_time"];
		    		}
		    		//认证是否过期
		    		$v['has_expire'] = 0;
		    		if($v['expire'] > 0 && $v['status'] == 1){
		    			if(TIME_UTC - $v['passed_time'] > $v['expire']*30*24*3600){
		    				$v['has_expire'] = 1;
		    			}
		    		}
		    		
		    		$user_credit_file[$v['type']] = $v;
		    	}
			}
	    	
			set_dynamic_cache($key,$user_credit_file);
		}
		$GLOBALS[$key] = $user_credit_file; 
		return $GLOBALS[$key];
	}
}

/**
 * 获取用户的信息绑定资料
 */

function get_user_msg_conf($id){
	$key = md5("USER_MSG_CONF_".$id);
	if(isset($GLOBALS[$key]))
	{
		return $GLOBALS[$key];
	}
	else
	{
		$conf = load_dynamic_cache($key);
		if($conf===false)
		{
			$conf = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."msg_conf where user_id = ".intval($id));
			set_dynamic_cache($key,$conf);
		}
		$GLOBALS[$key] = $conf; 
		return $GLOBALS[$key];
	}
}

function get_message_rel_data($message,$field='name')
{
	return $GLOBALS['db']->getOne("select ".$field." from ".DB_PREFIX.$message['rel_table']." where id = ".intval($message['rel_id']));
}

function get_order_item_list($order_id)
{
	$deal_order_item = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."deal_order_item where order_id = ".$order_id);
	$str = '';
	foreach($deal_order_item as $k=>$v)
	{
		$str .="<br /><span title='".$v['name']."'>".msubstr($v['name'])."</span>[".$v['number']."]";	
	}
	return $str;
}

//用于获取可同步登录的API
function get_api_login()
{
	if(trim($_REQUEST['act'])!='api_login')
	{
		$apis = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."api_login");
		$str = "<div class='blank'></div>";
		foreach($apis as $k=>$api)
		{
			$str .= $url."<span id='api_".$api['class_name']."_0'><script type='text/javascript'>load_api_url('".$api['class_name']."',0);</script></span>";
		}
		return $str;
	}
	else
	return '';
}

//获取已过时间
function pass_date($time)
{
		$time_span = TIME_UTC - $time;
		if($time_span>3600*24*365)
		{
			//一年以前
//			$time_span_lang = round($time_span/(3600*24*365)).$GLOBALS['lang']['SUPPLIER_YEAR'];
			//$time_span_lang = to_date($time,"Y".$GLOBALS['lang']['SUPPLIER_YEAR']."m".$GLOBALS['lang']['SUPPLIER_MON']."d".$GLOBALS['lang']['SUPPLIER_DAY']);
			$time_span_lang = to_date($time,"Y-m-d");
		}
		elseif($time_span>3600*24*30)
		{
			//一月
//			$time_span_lang = round($time_span/(3600*24*30)).$GLOBALS['lang']['SUPPLIER_MON'];
			//$time_span_lang = to_date($time,"Y".$GLOBALS['lang']['SUPPLIER_YEAR']."m".$GLOBALS['lang']['SUPPLIER_MON']."d".$GLOBALS['lang']['SUPPLIER_DAY']);
			$time_span_lang = to_date($time,"Y-m-d");
		}
		elseif($time_span>3600*24)
		{
			//一天
			//$time_span_lang = round($time_span/(3600*24)).$GLOBALS['lang']['SUPPLIER_DAY'];
			$time_span_lang = to_date($time,"Y-m-d");
		}
		elseif($time_span>3600)
		{
			//一小时
			$time_span_lang = round($time_span/(3600)).$GLOBALS['lang']['SUPPLIER_HOUR'];
		}
	    elseif($time_span>60)
		{
			//一分
			$time_span_lang = round($time_span/(60)).$GLOBALS['lang']['SUPPLIER_MIN'];
		}
		else
		{
			//一秒
			$time_span_lang = $time_span.$GLOBALS['lang']['SUPPLIER_SEC'];
		}
		return $time_span_lang;
}



//获取用户的可用额度
function get_can_use_quota($uid){
	//用户的总额度
	if($uid!=$GLOBALS['user_info']['id'] && $uid > 0){
		$quota = get_user_info("quota","id = ".$uid,"ONE");
	}
	elseif($uid==$GLOBALS['user_info']['id'] && $uid > 0){
		$quota = $GLOBALS['user_info']['quota'];
	}
	//获取用户借款用去的额度
	$borrow_quota = $GLOBALS['db']->getOne("select sum(borrow_amount) from ".DB_PREFIX."deal where is_delete=0 AND publish_wait=0 AND deal_status in(0,1,2,4) AND type_id not in(select id FROM  ".DB_PREFIX."deal_loan_type WHERE is_quota=0) AND user_id = ".$uid);
	return ($quota-$borrow_quota);
}

// $type = middle,big,small

function show_avatar($u_id,$type="middle")
{
	$key = md5("AVATAR_".$u_id.$type);
	if(isset($GLOBALS[$key]))
	{
		return $GLOBALS[$key];
	}
	else
	{
		$avatar_key = md5("USER_AVATAR_".$u_id); 
		$avatar_data = $GLOBALS['dynamic_avatar_cache'][$avatar_key];// 当前用户所有头像的动态缓存			
		if(!isset($avatar_data)||!isset($avatar_data[$key]))
		{
			$avatar_file = get_user_avatar($u_id,$type);	
			$avatar_str = "<a href='".url("index","space",array("id"=>$u_id))."' style='text-align:center; display:inline-block;'  onmouseover='userCard.load(this,".$u_id.");'>".
				   "<img src='".$avatar_file."'  />".
				   "</a>"; 			
			$avatar_data[$key] = $avatar_str;
			if(count($GLOBALS['dynamic_avatar_cache'])<500) //保存500个用户头像缓存
			{
				$GLOBALS['dynamic_avatar_cache'][$avatar_key] = $avatar_data;
			}			
		}
		else
		{
			$avatar_str = $avatar_data[$key];
		}
		$GLOBALS[$key]= $avatar_str;
		return $GLOBALS[$key];
	}
}

function update_avatar($u_id)
{
	$avatar_key = md5("AVATAR_".$u_id."middle"); 
	unset($GLOBALS['dynamic_avatar_cache'][$avatar_key]);
	$avatar_key = md5("AVATAR_".$u_id."big"); 
	unset($GLOBALS['dynamic_avatar_cache'][$avatar_key]);
	$avatar_key = md5("AVATAR_".$u_id."small"); 
	unset($GLOBALS['dynamic_avatar_cache'][$avatar_key]);
	$GLOBALS['cache']->set_dir(APP_ROOT_PATH."public/runtime/data/avatar_cache/");
	$GLOBALS['cache']->set("AVATAR_DYNAMIC_CACHE",$GLOBALS['dynamic_avatar_cache']); //头像的动态缓存
}


//获取用户头像的文件名
function get_user_avatar($id,$type)
{
	$uid = sprintf("%09d", $id);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);
	$path = $dir1.'/'.$dir2.'/'.$dir3;
				
	$id = str_pad($id, 2, "0", STR_PAD_LEFT); 
	$id = substr($id,-2);
	$avatar_file = APP_ROOT."/public/avatar/".$path."/".$id."virtual_avatar_".$type.".jpg";
	$avatar_check_file = APP_ROOT_PATH."public/avatar/".$path."/".$id."virtual_avatar_".$type.".jpg";
	if(file_exists($avatar_check_file))	
		return $avatar_file;
	else
		return  APP_ROOT."/public/avatar/noavatar_".$type.".gif";
}



function check_user_avatar($id,$type)
{
	$uid = sprintf("%09d", $id);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);
	$path = $dir1.'/'.$dir2.'/'.$dir3;
				
	$id = str_pad($id, 2, "0", STR_PAD_LEFT); 
	$id = substr($id,-2);
	$avatar_file = APP_ROOT."/public/avatar/".$path."/".$id."virtual_avatar_".$type.".jpg";
	$avatar_check_file = APP_ROOT_PATH."public/avatar/".$path."/".$id."virtual_avatar_".$type.".jpg";
	if(file_exists($avatar_check_file))	
		return $avatar_file;
	else
		return false;
}

//添加一则日志
/**
 * @param $type			转发的类型标识    见下代码中的范围 
 * @param $relay_id		转发的主题ID
 * @param $fav_id		喜欢主题的ID
 */
function insert_topic($type='', $fav_id = 0,$user_id = 0,$user_name = '',$l_user_id = 0)
{
	//定义类型的范围
	$type_array = array(
		"focus", //分享
		"transfer_message", //留言
		"deal_message", //留言
		"message", //留言
		"deal_message_reply", //回复
		"transfer_message_reply", //回复
		"message_reply",//回复
		"deal_collect",//关注FAV
	);
	if(!in_array($type,$type_array))
		return ;
	
	if($GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."topic WHERE `type`='$type' AND fav_id='$fav_id' AND user_id='$user_id' AND l_user_id='$l_user_id' ")==0){
		//添加
		$data['type'] = $type;
		$data['fav_id'] = $fav_id;
		$data['user_id'] = $user_id;
		$data['user_name'] = $user_name;
		$data['l_user_id'] = $l_user_id;
		$data['is_effect'] = 1;
		$data['create_time'] = TIME_UTC;
		$GLOBALS['db']->autoExecute(DB_PREFIX."topic",$data,"INSERT");
	}
}

function get_topic_list($limit,$condition='',$orderby='create_time desc',$keywords_array=array())
{
	if($orderby=='')$orderby='create_time desc';
	if($condition!='')
	$condition = " and ".$condition;
	$total = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."topic where is_effect = 1  ".$condition);
	$list = array();
	if($total > 0){
		$list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."topic where is_effect = 1 ".$condition." order by ".$orderby." limit ".$limit);
		
		foreach($list as $k=>$v){
			if($v['type']=="deal_message" || $v['type']=="message" || $v['type']=="deal_message_reply" || $v['type']=="message_reply" || $v['type']=="deal_collect" || $v['type']=="deal_bad"){
				require_once(APP_ROOT_PATH."/app/Lib/deal.php");
				$list[$k]['deal'] = get_deal($v['fav_id']);
			}
			elseif($v['type']=="transfer_message" || $v['type']=="transfer_message_reply" ){
				require_once(APP_ROOT_PATH."/app/Lib/deal.php");
				$condition = ' AND dlt.id='.$v['fav_id'].' AND d.deal_status >= 4 and d.is_effect=1 and d.is_delete=0  and d.repay_time_type =1 and  d.publish_wait=0 ';
				$union_sql = " LEFT JOIN ".DB_PREFIX."deal_load_transfer dlt ON dlt.deal_id = dl.deal_id ";
				$list[$k]['transfer'] = get_transfer($union_sql,$condition);
			}
		}
	}
	
	return array('list'=>$list,'total'=>$total);
}


//获取相应规格的图片地址
//gen=0:保持比例缩放，不剪裁,如高为0，则保证宽度按比例缩放  gen=1：保证长宽，剪裁
function get_spec_image($img_path,$width=0,$height=0,$gen=0,$is_preview=true)
{
	//关于ALIOSS的生成
	if($GLOBALS['distribution_cfg']['OSS_TYPE']&&$GLOBALS['distribution_cfg']['OSS_TYPE']=="ALI_OSS")
	{
		$pathinfo = pathinfo($img_path);
		$file = $pathinfo['basename'];
		$dir = $pathinfo['dirname'];
		$dir = str_replace("./public/", "/public/", $dir);

		if($width==0)
		{
			$file_name = $GLOBALS['distribution_cfg']['OSS_DOMAIN'].$dir."/".$file;
		}
		else if($height==0)
		{
			$file_name = $GLOBALS['distribution_cfg']['OSS_DOMAIN'].$dir."/".$file."@".$width."w_1l_1x.jpg";
		}
		else if($gen==0)
			$file_name = $GLOBALS['distribution_cfg']['OSS_DOMAIN'].$dir."/".$file."@".$width."w_".$height."h_0c_1e_1x.jpg"; //以短边缩放 1e 不剪裁
		else
			$file_name = $GLOBALS['distribution_cfg']['OSS_DOMAIN'].$dir."/".$file."@".$width."w_".$height."h_1c_1e_1x.jpg"; //以短边缩放 1e 剪裁
		return $file_name;
	}

	if($width==0||substr($img_path, 0,2)!="./")
		$new_path = $img_path;
	else
	{
		//$img_name = substr($img_path,0,-4);
		//$img_ext = substr($img_path,-3);
		$fileinfo = pathinfo($img_path);
		$img_ext = $fileinfo['extension'];
		$len = strlen($img_ext) + 1;
		$img_name =substr($img_path,0,-$len);

		if($is_preview)
			$new_path = $img_name."_".$width."x".$height.".jpg";
		else
			$new_path = $img_name."o_".$width."x".$height.".jpg";
		if(!file_exists(APP_ROOT_PATH.$new_path))
		{
			require_once APP_ROOT_PATH."system/utils/es_imagecls.php";
			$imagec = new es_imagecls();
			$thumb = $imagec->thumb(APP_ROOT_PATH.$img_path,$width,$height,$gen,true,"",$is_preview);

			if($GLOBALS['distribution_cfg']['OSS_TYPE']&&$GLOBALS['distribution_cfg']['OSS_TYPE']=="ES_FILE")
			{
				$paths = pathinfo($new_path);
				$path = str_replace("./","",$paths['dirname']);
				$filename = $paths['basename'];
				$pathwithoupublic = str_replace("public/","",$path);

				$file_array['path'] = $pathwithoupublic;
				$file_array['file'] = get_domain().APP_ROOT."/".$path."/".$filename;
				$file_array['name'] = $filename;
				$GLOBALS['curl_param']['images'][] = $file_array;
			}

		}
	}
	//return APP_ROOT."/test.php?path=".$new_path."&rand=".rand(1000000,9999999);
	return $new_path;
}

function get_spec_gif_anmation($url,$width,$height)
{
	require_once APP_ROOT_PATH."system/utils/gif_encoder.php";
	require_once APP_ROOT_PATH."system/utils/gif_reader.php";
	require_once APP_ROOT_PATH."system/utils/es_imagecls.php";
	$gif = new GIFReader();
	$gif->load($url);
	$imagec = new es_imagecls();
	foreach($gif->IMGS['frames'] as $k=>$img)
	{
		$im = imagecreatefromstring($gif->getgif($k));		
		$im = $imagec->make_thumb($im,$img['FrameWidth'],$img['FrameHeight'],"gif",$width,$height,$gen=1);
		ob_start();
		imagegif($im);
		$content = ob_get_contents();
        ob_end_clean();
		$frames [ ] = $content;
   		$framed [ ] = $img['frameDelay'];
	}
		
	$gif_maker = new GIFEncoder (
	       $frames,
	       $framed,
	       0,
	       2,
	       0, 0, 0,
	       "bin"   //bin为二进制   url为地址
	  );
	return $gif_maker->GetAnimation ( );
}

function load_comment_list()
{
	return $GLOBALS['tmpl']->fetch("inc/comment_list.html");
}
function load_message_list()
{
	return $GLOBALS['tmpl']->fetch("inc/message_list.html");
}
function load_reply_list()
{
	return $GLOBALS['tmpl']->fetch("inc/topic_page_reply_list.html");
}



//编译生成css文件
function parse_css($urls)
{
	
	$url = md5(implode(',',$urls));
	$css_url = 'public/runtime/statics/'.$url.'.css';
	$url_path = APP_ROOT_PATH.$css_url;
	if(!file_exists($url_path)||IS_DEBUG)
	{
		if(!file_exists(APP_ROOT_PATH.'public/runtime/statics/')){
			mkdir(APP_ROOT_PATH.'public/runtime/statics/');
			@chmod(APP_ROOT_PATH.'public/runtime/statics/', 0777);
		}
	
		$tmpl_path = $GLOBALS['tmpl']->_var['TMPL'];	
	
		$css_content = '';
		foreach($urls as $url)
		{
			$css_content .= @file_get_contents($url);
		}
		$css_content = preg_replace("/[\r\n]/",'',$css_content);
		$css_content = str_replace("../images/",$tmpl_path."/images/",$css_content);
//		@file_put_contents($url_path, unicode_encode($css_content));
		@file_put_contents($url_path, $css_content);
	}
	return SITE_DOMAIN.APP_ROOT."/".$css_url;
}

/**
 * 
 * @param $urls 载入的脚本
 * @param $encode_url 需加密的脚本
 */
function parse_script($urls,$encode_url=array())
{	
	$url = md5(implode(',',$urls));
	$js_url = 'public/runtime/statics/'.$url.'.js';
	$url_path = APP_ROOT_PATH.$js_url;
	if(!file_exists($url_path)||IS_DEBUG)
	{
		if(!file_exists(APP_ROOT_PATH.'public/runtime/statics/')){
			mkdir(APP_ROOT_PATH.'public/runtime/statics/');
			@chmod(APP_ROOT_PATH.'public/runtime/statics/', 0777);
		}
	
		if(count($encode_url)>0)
		{
			require_once APP_ROOT_PATH."system/libs/javascriptpacker.php";
		}
		
		$js_content = '';
		foreach($urls as $url)
		{
			$append_content = @file_get_contents($url)."\r\n";
			if(in_array($url,$encode_url))
			{
				$packer = new JavaScriptPacker($append_content);
				$append_content = $packer->pack();
			}			
			$js_content .= $append_content;
		}		
//		require_once APP_ROOT_PATH."system/libs/javascriptpacker.php";
//	    $packer = new JavaScriptPacker($js_content);
//		$js_content = $packer->pack();
		@file_put_contents($url_path,$js_content);
	}
	return SITE_DOMAIN.APP_ROOT."/".$js_url;
}

//获取商城公告
function get_notice($limit=0)
{
	if($limit == 0)
	$limit = app_conf("INDEX_NOTICE_COUNT");
	if($limit>0)
	{
		$limit_str = "limit ".$limit;
	}
	else
	{
		$limit_str = "";
	}
	$list = $GLOBALS['db']->getAll("select a.*,ac.type_id from ".DB_PREFIX."article as a left join ".DB_PREFIX."article_cate as ac on a.cate_id = ac.id where ac.type_id = 2 and ac.is_effect = 1 and ac.is_delete = 0 and a.is_effect = 1 and a.is_delete = 0 order by a.sort desc ".$limit_str);
	
	foreach($list as $k=>$v)
	{
			if($v['type_id']==1)
			{
				$module = "help";
			}
			elseif($v['type_id']==2)
			{
				$module = "notice";
			}
			elseif($v['type_id']==3)
			{
				$module = "sys";
			}
			else 
			{
				$module = 'article';
			}
		
			if($v['uname']!='')
			$aurl = url("index",$module,array("id"=>$v['uname']));
			else
			$aurl = url("index",$module,array("id"=>$v['id']));
			$list[$k]['url'] = $aurl;
	}
	return $list;
}

//获取指定的分类列表
function get_cate_tree($pid = 0,$is_all = 0)
{
	return load_auto_cache("cache_shop_cate_tree",array("pid"=>$pid,"is_all"=>$is_all));
}

//获取指定的文章分类列表
function get_acate_tree($pid = 0)
{
	return load_auto_cache("cache_shop_acate_tree",array("pid"=>$pid));
}

/**
 * 获取文章列表
 */
function get_article_list($limit, $cate_id=0, $where='',$orderby = '',$cached = true)
{		
		$key = md5("ARTICLE".$limit.$cate_id.$where.$orderby);	
		if($cached)
		{				
			$res = $GLOBALS['cache']->get($key);
		}
		else
		{
			$res = false;
		}
		if($res===false)
		{
				
			$count_sql = "select count(*) from ".DB_PREFIX."article as a left join ".DB_PREFIX."article_cate as ac on a.cate_id = ac.id where a.is_effect = 1 and a.is_delete = 0 and ac.is_delete = 0 and ac.is_effect = 1 ";
			$sql = "select a.*,ac.type_id from ".DB_PREFIX."article as a left join ".DB_PREFIX."article_cate as ac on a.cate_id = ac.id where a.is_effect = 1 and a.is_delete = 0 and ac.is_delete = 0 and ac.is_effect = 1 ";
			
			if($cate_id>0)
			{
				$ids = load_auto_cache("deal_shop_acate_belone_ids",array("cate_id"=>$cate_id));
				$sql .= " and a.cate_id in (".implode(",",$ids).")";
				$count_sql .= " and a.cate_id in (".implode(",",$ids).")";
			}
				
			
			if($where != '')
			{
				$sql.=" and ".$where;
				$count_sql.=" and ".$where;
			}
			
			if($orderby=='')
			$sql.=" order by a.sort desc limit ".$limit;
			else
			$sql.=" order by ".$orderby." limit ".$limit;
			
			$articles_count = $GLOBALS['db']->getOne($count_sql);
			$articles = array();
			if($articles_count > 0){
				$articles = $GLOBALS['db']->getAll($sql);	
				foreach($articles as $k=>$v)
				{
					if($v['type_id']==1)
					{
						$module = "help";
					}
					elseif($v['type_id']==2)
					{
						$module = "notice";
					}
					elseif($v['type_id']==3)
					{
						$module = "sys";
					}
					else 
					{
						$module = 'article';
					}
					
					if($v['uname']!='')
					$aurl = url("index",$module,array("id"=>$v['uname']));
					else
					$aurl = url("index",$module,array("id"=>$v['id']));
						
					$articles[$k]['url'] = $aurl;
				}
			}
				
			
	 		
			$res = array('list'=>$articles,'count'=>$articles_count);	
			$GLOBALS['cache']->set($key,$res);
		}			
		return $res;
}

function load_page_png($img)
{
	return load_auto_cache("page_image",array("img"=>$img));
}

function get_article($id)
{
	return $GLOBALS['db']->getRow("select a.*,ac.type_id from ".DB_PREFIX."article as a left join ".DB_PREFIX."article_cate as ac on a.cate_id = ac.id where a.id = ".intval($id)." and a.is_effect = 1 and a.is_delete = 0");
}
function get_article_buy_uname($uname)
{
	return $GLOBALS['db']->getRow("select a.*,ac.type_id from ".DB_PREFIX."article as a left join ".DB_PREFIX."article_cate as ac on a.cate_id = ac.id where a.uname = '".addslashes($uname)."' and a.is_effect = 1 and a.is_delete = 0");
}



function show_ke_image($id,$cnt="")
{
	if($cnt)
	{
		$image_path = $cnt;
		$is_show="display:inline-block;";
	}
	else{
		$image_path =APP_ROOT."/admin/Tpl/default/Common/images/no_pic.gif";
		$is_show="display:none;";
	}
	
	$parseStr= "<span>
        <div style='float:left; height:35px; padding-top:1px;'>
			<input type='hidden' value='".(empty($cnt) ? "" : $image_path)."' name='$id' id='keimg_h_$id' />
			<div class='buttonActive' style='margin-right:5px;'>
				<div class='buttonContent'>
					<button type='button' class='keimg ke-icon-upload_image' rel='$id'>选择图片</button>
				</div>
			</div>
		</div>
		 <a href='$image_path' target='_blank' id='keimg_a_$id' ><img src='$image_path' id='keimg_m_$id' width=35 height=35 style='float:left; border:#ccc solid 1px; margin-left:5px;' /></a>
		 <div style='float:left; height:35px; padding-top:1px;margin-right:10px'>
			 <div class='buttonActive'>
				<div class='buttonContent'>
					<img src='".APP_ROOT."/admin/Tpl/default/Common/images/del.gif' style='$is_show; margin-left:10px; float:left; border:#ccc solid 1px; width:35px; height:35px; cursor:pointer;' class='keimg_d' rel='$id' title='删除'>
				</div>
			</div>
		</div>
		</span>";
	return $parseStr;				
}

function show_ke_textarea($id,$width=630,$height=350,$cnt="")
{	
	return "<div  style='margin-bottom:5px; '><textarea id='".$id."' name='".$id."' class='ketext' style='width:".$width."px; height:".$height."px;' >".$cnt."</textarea> </div>";
}

function replace_public($content)
{
	 $domain = app_conf("PUBLIC_DOMAIN_ROOT")==''?SITE_DOMAIN.APP_ROOT:app_conf("PUBLIC_DOMAIN_ROOT");
	 $domain_origin = SITE_DOMAIN.APP_ROOT;
	 $content = str_replace($domain."/public/","./public/",$content);	
	 $content = str_replace($domain_origin."/public/","./public/",$content);		 
	 return $content;
}

function check_user_auth($m_name,$a_name,$rel_id)
{
	$rs = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."user_auth where m_name = '".$m_name."' and a_name = '".$a_name."' and user_id = ".intval($GLOBALS['user_info']['id']));
	foreach($rs as $row)
	{
		if($row['rel_id']==0||$row['rel_id']==$rel_id)
		{
			return true;
		}
	}
	return false;
}

function get_user_auth()
{
	$user_auth = array();
	//定义用户权限
	$user_auth_rs = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."user_auth where user_id = ".intval($GLOBALS['user_info']['id']));
	foreach($user_auth_rs as $k=>$row)
	{
		$user_auth[$row['m_name']][$row['a_name']][$row['rel_id']] = true;
	}
	return $user_auth;
}


function get_op_change_show($m_name,$a_name)
{
	if($a_name=="replydel"||$a_name=='del')
	{
		//删除
		$money = doubleval(app_conf("USER_DELETE_MONEY"));
		$money_f = "-".format_price(0-$money);
		$score = intval(app_conf("USER_DELETE_SCORE"));
		$score_f = "-".format_score(0-$score);
		$point = intval(app_conf("USER_DELETE_POINT"));
		$point_f = "-".(0-$point)."经验";
	}
	else
	{
		//增加
		$money = doubleval(app_conf("USER_ADD_MONEY"));
		$money_f = "+".format_price($money);
		$score = intval(app_conf("USER_ADD_SCORE"));
		$score_f = "+".format_score($score);
		$point = intval(app_conf("USER_ADD_POINT"));
		$point_f = "+".$point."经验";
	}
	$str = "";
	if($money!=0)$str .= $money_f;
	if($score!=0)$str .= $score_f;
	if($point!=0)$str .= $point_f;
	return $str;
	
}

function get_op_change($m_name,$a_name)
{
	if($a_name=="replydel"||$a_name=='del')
	{
		//删除
		$money = doubleval(app_conf("USER_DELETE_MONEY"));
		
		$score = intval(app_conf("USER_DELETE_SCORE"));
		
		$point = intval(app_conf("USER_DELETE_POINT"));
		
	}
	else
	{
		//增加
		$money = doubleval(app_conf("USER_ADD_MONEY"));
		
		$score = intval(app_conf("USER_ADD_SCORE"));
		
		$point = intval(app_conf("USER_ADD_POINT"));
		
	}
	return array("money"=>$money,"score"=>$score,"point"=>$point);
	
}

function show_topic_form($text_name,$width="300px",$height="80px",$is_img = false,$is_topic = false,$is_event = false,$id="topic_form_textarea",$show_btn=false,$show_tag=false)
{
	
	$GLOBALS['tmpl']->caching = true;
	$cache_id  = md5("show_topic_form".$text_name.$width.$height.$is_img.$is_topic.$is_event.$id.$show_btn);		
	if (!$GLOBALS['tmpl']->is_cached('inc/topic_form.html', $cache_id))
	{
		$GLOBALS['tmpl']->assign("text_name",$text_name);
		//输出表情数据html
		$result = $GLOBALS['db']->getAll("select `type`,`title`,`emotion`,`filename` from ".DB_PREFIX."expression order by type");
		$expression = array();
		foreach($result as $k=>$v)
		{
			$v['filename'] = "./public/expression/".$v['type']."/".$v['filename'];
			$v['emotion'] = str_replace(array('[',']'),array('',''),$v['emotion']);
			$expression[$v['type']][] = $v;
		}
		
		$tag_list =$GLOBALS['db']->getAll("select name from ".DB_PREFIX."topic_tag where is_preset = 1 order by count desc limit 5");
		
		$GLOBALS['tmpl']->assign("tag_list",$tag_list);
		$GLOBALS['tmpl']->assign("expression",$expression);
		$GLOBALS['tmpl']->assign("is_img",$is_img);
		$GLOBALS['tmpl']->assign("width",$width);
		$GLOBALS['tmpl']->assign("height",$height);
		$GLOBALS['tmpl']->assign("is_event",$is_event);
		if($is_event)
		{
			$fetch_list = $GLOBALS['db']->getAll("select * from ".DB_PREFIX."fetch_topic where is_effect = 1 order by sort desc");
			$GLOBALS['tmpl']->assign("fetch_list",$fetch_list);
		}		
		$GLOBALS['tmpl']->assign("is_topic",$is_topic);
		$GLOBALS['tmpl']->assign("box_id",$id);
		$GLOBALS['tmpl']->assign("show_btn",$show_btn);
		$GLOBALS['tmpl']->assign("show_tag",$show_tag);
	}	
	return $GLOBALS['tmpl']->fetch("inc/topic_form.html",$cache_id);
}

function get_gopreview()
{
		$gopreview = es_session::get("gopreview");
		if(!isset($gopreview)||$gopreview=="")
		{
			$gopreview = es_session::get('before_login')?es_session::get('before_login'):url("index");				
		}	
		es_session::delete("before_login");	
		es_session::delete("gopreview");	
		return $gopreview;
}

function set_gopreview()
{
	$url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?");   
    $parse = parse_url($url);
    if(isset($parse['query'])) {
            parse_str($parse['query'],$params);
            $url   =  $parse['path'].'?'.http_build_query($params);
    }
    if(app_conf("URL_MODEL")==1)$url = $GLOBALS['current_url'];
	es_session::set("gopreview",$url); 
}	

function app_recirect_preview()
{
	app_redirect(get_gopreview());
}


/**
 * 剩余时间
 */
function remain_time($remain_time){
	$d = intval($remain_time/86400);
	$h = intval(($remain_time%86400)/3600);
	$m = intval(($remain_time%3600)/60);
	return $d.$GLOBALS['lang']['DAY'].$h.$GLOBALS['lang']['HOUR'].$m.$GLOBALS['lang']['MIN'];
}


/**
 * 技术两个日期差几个月
 */
function how_much_month($start_time,$end_time){
	if($start_time=="" || $end_time=="")
	{
		return "";
	}
	$time1 = to_date($start_time,"Y")*12 + to_date($start_time,"m");
	$time2 = to_date($end_time,"Y")*12 + to_date($end_time,"m");
	return $time2 - $time1;
}

function gen_qrcode($str,$size = 5,$img=false)
{
	require_once APP_ROOT_PATH."system/phpqrcode/qrlib.php";

	if($img)
	{
		QRcode::png($str, false, 'Q', $size, 2); 
		return;
	}
	
	$root_dir = APP_ROOT_PATH."public/images/qrcode/";
 	if (!is_dir($root_dir)) {
            @mkdir($root_dir);               
            @chmod($root_dir, 0777);
     }
     
     $filename = md5($str."|".$size);
     $hash_dir = $root_dir. '/c' . substr(md5($filename), 0, 1)."/";
     if (!is_dir($hash_dir))
     {
        @mkdir($hash_dir);
        @chmod($hash_dir, 0777);
     }   
	
	$filesave = $hash_dir.$filename.'.png';

	$fileurl =  "./public/images/qrcode/c". substr(md5($filename), 0, 1)."/".$filename.".png";
	if(!file_exists($filesave))
	{
		QRcode::png($str, $filesave, 'Q', $size, 2); 
		$QR =  APP_ROOT_PATH.$fileurl;   
		$logo = app_conf("QRCODE_LOGO");  
	 
	    if($logo !== "")  
	    {  
	   		$logo = APP_ROOT_PATH.$logo;
	        $QR = imagecreatefromstring(file_get_contents($QR));  
	        $logo = imagecreatefromstring(file_get_contents($logo));  
	        $QR_width = imagesx($QR);  
	        $QR_height = imagesy($QR);  
	        $logo_width = imagesx($logo);  
	        $logo_height = imagesy($logo);  
	        $logo_qr_width = $QR_width / 5;  
	        $scale = $logo_width / $logo_qr_width;  
	        $logo_qr_height = $logo_height / $scale;  
	        $from_width = ($QR_width - $logo_qr_width) / 2;  
	        imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);  
	   		imagepng($QR,APP_ROOT_PATH.$fileurl); 
	    }
		
		if($GLOBALS['distribution_cfg']['OSS_TYPE']&&$GLOBALS['distribution_cfg']['OSS_TYPE']!="NONE")
		syn_to_remote_image_server($fileurl);
	}	
	return $fileurl;  
}


//显示成功
function showIpsInfo($msg,$jump='')
{		
	$GLOBALS['tmpl']->assign('msg',$msg);
	$GLOBALS['tmpl']->assign('jump',$jump);
	$GLOBALS['tmpl']->display("ips_show.html");
	exit;
}


/**
 * 商户端获取银行列表查询(WS)
 * @return
 * 		  pErrCode 4 返回状态 否 0000成功； 9999失败；
 * 		  pErrMsg 100 返回信息 否 状态0000：成功 除此乊外：反馈实际原因
 * 		  pBankList 银行名称|银行卡别名|银行卡编号#银行名称|银行卡别名|银行卡编号
 * 		  BankList[] = array('name'=>银行名称,'sub_name'=>银行卡别名,'id'=>银行卡编号);
 */
function GetIpsBankList(){

	$result = $GLOBALS['cache']->get("IPS_BANK_LIST");
	if($result===false){
		$class_name = getCollName();
		$ips_file = APP_ROOT_PATH."system/collocation/".$class_name."_collocation.php";
		require_once $ips_file;
		$collocation_class = $class_name."_collocation";
		$collocation_object = new $collocation_class();
		$result = $collocation_object->GetBankList();
		if(count($result['BankList']) > 0)
			$GLOBALS['cache']->set("IPS_BANK_LIST",$result);
	}
	//print_r($result);

	return $result;
}

/**
 * 获得用户余额
 * @param int $user_id
 * @param int $user_type
 * @return 
 * 	 * 			pMerCode 6 “平台”账号 否 由IPS颁发的商户号
				pErrCode 4 返回状态 否 0000成功； 9999失败；
				pErrMsg 100 返回信息 否 状态0000：成功 除此乊外：反馈实际原因
				pIpsAcctNo 30 IPS账户号 否 查询时提交
				pBalance 10 可用余额 否 带正负符号，带小数点，最多保留两位小数
				pLock 10 冻结余额 否 带正负符号，带小数点，最多保留两位小数
				pNeedstl 10 未结算余额 否 带正负符号，带小数点，最多保留两位小数
 */
function GetIpsUserMoney($user_id,$user_type = 0){
	if(intval(app_conf("OPEN_IPS")) > 0){
		$class_name = getCollName();
		require_once APP_ROOT_PATH."system/collocation/".$class_name."_collocation.php";
		$collocation_class = $class_name."_collocation";
		$collocation_object = new $collocation_class();
		$result = $collocation_object->QueryForAccBalance($user_id,$user_type);
	
		return $result;
	}
	else{
		return false;
	}
}



//更改过期流标状态
function change_deal_status(){
	//$sql = "select id from ".DB_PREFIX."deal where is_effect = 1 and deal_status = 1 and is_delete = 0 AND load_money/borrow_amount < 1 AND (start_time + enddate*24*3600 - ".TIME_UTC.") <=0  ";
	/*$sql = "select id from ".DB_PREFIX."deal where is_effect = 1 and deal_status = 1 and is_delete = 0 AND load_money/borrow_amount <= 1 ";
	 $deal_ids = $GLOBALS['db']->getAll($sql);

	foreach($deal_ids as $k=>$v)
	{
	syn_deal_status($v['id']);
	}*/
	syn_dealing();
}

/**
 * 获得提现手续费
 * @param float $money  提现金额
 * @param user $user_info 用户信息
 * @return float 提现手续费
 */
function getCarryFee($money,$user_info){
	$fee = 0;
	$feel_type = 0;
	//获取手续费配置表
	$vip_id = 0;
	if($user_info['vip_id'] > 0 && $user_info['vip_state'] == 1){
		$vip_id = $user_info['vip_id'];
	}
		
	//手续费
	$fee_config = load_auto_cache("user_carry_config",array("vip_id"=>$vip_id));
	//如果手续费大于最大的配置那么取这个手续费
	if($money >=$fee_config[count($fee_config)-1]['max_price']){
		$fee = $fee_config[count($fee_config)-1]['fee'];
		$feel_type = $fee_config[count($fee_config)-1]['fee_type'];
	}
	else{
		foreach($fee_config as $k=>$v){
			if($money >= $v['min_price'] && $money <= $v['max_price']){
				$fee =  floatval($v['fee']);
				$feel_type = $v['fee_type'];
			}
		}
	}
		
	if($feel_type == 1){
		$fee = $money * $fee * 0.01;
	}
	
	return $fee;
}

/**
 * 获取VIP等级名称
 */
function get_vip_name($vip_id){
	if($vip_id==0)
		return "";
	$vip = load_auto_cache("vip_list",array("id"=>$vip_id));
	return $vip[$vip_id]['vip_grade'];
}

/**
 * 获取网站统计
 */
function site_statics(){
	
	$stats = $GLOBALS['cache']->get("site_statics");
	if($stats==false){
	
		//累计投资金额
		$load_rs = $GLOBALS['db']->getRow("SELECT sum(money) as total_load,count(*) as load_count FROM ".DB_PREFIX."deal_load where is_repay= 0 ");
		$stats['total_load'] = $load_rs['total_load'] + floatval(trim(app_conf("VIRTUAL_MONEY_1")));
		$stats['load_count'] = $load_rs['load_count'];
		$stats['total_load_format'] = format_conf_count(number_format($stats['total_load'],2));
		//成交笔数
		$stats['deal_total_count'] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."deal where  deal_status >=4 ");
		
		
		//累计创造收益
		$stats['total_rate'] = $GLOBALS['db']->getOne("SELECT sum(true_interest_money + impose_money + true_reward_money - true_manage_money - true_manage_interest_money) FROM ".DB_PREFIX."deal_load_repay where  has_repay = 1 ");
		$stats['total_rate'] += $GLOBALS['db']->getOne("SELECT sum(rebate_money) FROM ".DB_PREFIX."deal_load where  is_has_loans = 1 ");//加上返利
		$stats['total_rate'] -= $GLOBALS['db']->getOne("SELECT sum(fee_amount) FROM ".DB_PREFIX."payment_notice WHERE  is_paid =1  "); //减去充值手续费
		$stats['total_rate'] -= $GLOBALS['db']->getOne("SELECT sum(fee) FROM ".DB_PREFIX."user_carry WHERE status =1  "); //减去提现手续费
		$stats['total_rate'] += $GLOBALS['db']->getOne("SELECT sum(money) FROM ".DB_PREFIX."referrals WHERE pay_time >0  "); //加上邀请返利
		$stats['total_rate'] += floatval(trim(app_conf("VIRTUAL_MONEY_2")));
		$stats['total_rate_format'] = format_conf_count(number_format($stats['total_rate'],2));
		//本息保证金（元）
		$stats['total_bzh'] = $GLOBALS['db']->getOne("SELECT sum(guarantor_real_freezen_amt+real_freezen_amt) FROM ".DB_PREFIX."deal where deal_status= 4 ");
		$stats['total_bzh'] += floatval(trim(app_conf("VIRTUAL_MONEY_3")));
		$stats['total_bzh_format'] = format_conf_count(number_format($stats['total_bzh'],2));
		//待收资金（元）
		$stats['total_repay'] = $GLOBALS['db']->getOne("SELECT sum(repay_money) FROM ".DB_PREFIX."deal_load_repay where has_repay = 1 ");
		$stats['total_repay_format'] = format_conf_count(number_format($stats['total_repay'],2));
		//待投资金（元）
		$statsU = $GLOBALS['db']->getRow("SELECT sum(AES_DECRYPT(money_encrypt,'".AES_DECRYPT_KEY."')) as total_usermoney ,count(*) total_user FROM ".DB_PREFIX."user where is_effect = 1 and is_delete=0 ");
		$stats['total_usermoney'] = $statsU['total_usermoney'];
		$stats['total_usermoney_format'] = format_conf_count(number_format($stats['total_usermoney'],2));
		$stats['total_user'] = $statsU['total_user'];
		
		//注册人数
		$stats['user_count'] = $GLOBALS['db']->getOne("SELECT count(*) FROM ".DB_PREFIX."user where is_effect = 1 and user_type in(0,1)");
		
		//回款金额
        $stats['total_repay_money'] =  $GLOBALS['db']->getOne("SELECT sum(true_repay_money) FROM ".DB_PREFIX."deal_repay where has_repay = 1 ");
        $stats['total_repay_money_format'] = format_conf_count($stats['total_repay_money']);
		
		$GLOBALS['cache']->set("site_statics",$stats);
	}
	
	return $stats;
}

/**
 * 获取最近的投资列表
 */
function  get_near_deal_loads($limit="0,10"){
	$list = $GLOBALS['db']->getAll("SELECT dl.*,d.name,d.rate FROM ".DB_PREFIX."deal_load dl LEFT JOIN ".DB_PREFIX."deal d ON d.id = dl.deal_id  order by id DESC LIMIT ".$limit);
	return $list;
}

/**
 * 签到奖励
 */
function signin($user_id){
	$t_begin_time = to_timespan(to_date(TIME_UTC,"Y-m-d"));  //今天开始
	$t_end_time = to_timespan(to_date(TIME_UTC,"Y-m-d"))+ (24*3600 - 1);  //今天结束
	$y_begin_time = $t_begin_time - (24*3600); //昨天开始
	$y_end_time = $t_end_time - (24*3600);  //昨天结束
	
	$t_sign_data = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user_sign_log where user_id = ".$user_id." and sign_date between ".$t_begin_time." and ".$t_end_time);
	if($t_sign_data)
	{
		$result['status'] = 1;
		$result['info'] = "您已经签到过了";
	}
	else
	{
		$y_sign_data = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."user_sign_log where user_id = ".$user_id." and sign_date between ".$y_begin_time." and ".$y_end_time);
		$total_signcount = $GLOBALS['db']->getOne("select count(*) from ".DB_PREFIX."user_sign_log where user_id = ".$user_id);
		if($y_sign_data&&$total_signcount>=3)
		{
			$point = intval(app_conf("USER_LOGIN_KEEP_POINT"));
			$score = intval(app_conf("USER_LOGIN_KEEP_SCORE"));
			$nmc_money = intval(app_conf("USER_LOGIN_KEEP_NMC_MONEY"));
			
			if(app_conf("USER_LOGIN_KEEP_MONEY_TYPE") == 0)
				$money = floatval(app_conf("USER_LOGIN_KEEP_MONEY"));
			else{
				$money = 0;
				$money_list = unserialize(app_conf("USER_LOGIN_KEEP_MONEY"));
				foreach($money_list as $kk=>$vv){
					if($GLOBALS['user_info']['money'] >=$vv['minprice']){
						if($GLOBALS['user_info']['money'] <=$vv['maxprice'])
						{
							if($vv['type']==0)
								$money = floatval($vv['money']);
							else
								$money = $GLOBALS['user_info']['money']*0.01*floatval($vv['money']);
								
						}
						elseif($GLOBALS['user_info']['money'] > $vv['maxprice']){
							if($vv['type']==0)
								$money = floatval($vv['money']);
							else
								$money = $GLOBALS['user_info']['money']*0.01*floatval($vv['money']);
							
						}
					}
				}
			}
		}
		else
		{
			$point = intval(app_conf("USER_LOGIN_POINT"));
			$score = intval(app_conf("USER_LOGIN_SCORE"));
			$nmc_money = intval(app_conf("USER_LOGIN_NMC_MONEY"));
			if(app_conf("USER_LOGIN_MONEY_TYPE") == 0)
				$money = floatval(app_conf("USER_LOGIN_MONEY"));
			else{
				$money = 0;
				$money_list = unserialize(app_conf("USER_LOGIN_MONEY"));
				foreach($money_list as $kk=>$vv){
					if($GLOBALS['user_info']['money'] >=$vv['minprice']){
						if($GLOBALS['user_info']['money'] <=$vv['maxprice'])
						{
							if($vv['type']==0)
								$money = floatval($vv['money']);
							else
								$money = $GLOBALS['user_info']['money']*0.01*floatval($vv['money']);
								
						}
						elseif($GLOBALS['user_info']['money'] > $vv['maxprice']){
							if($vv['type']==0)
								$money = floatval($vv['money']);
							else
								$money = $GLOBALS['user_info']['money']*0.01*floatval($vv['money']);
								
								
						}
					}
				}
			}
		}
		if($point>0||$score>0||$money>0||$nmc_money>0)
		{
			require_once APP_ROOT_PATH."system/libs/user.php";
			if($money>0)
				$data["money"]=$money;
			if($score>0)
				$data["score"]=$score;
			if($point>0)
				$data["point"]=$point;
			
			if($nmc_money == 0)
				modify_account($data,$user_id,"您在".to_date(TIME_UTC)."签到成功",25);
			else{
				modify_account($data,$user_id,"您在".to_date(TIME_UTC)."签到成功",25);
				$data = "";
				$data["money"]=$nmc_money;
				$data["nmc_amount"]=$nmc_money;
				modify_account($data,$user_id,"您在".to_date(TIME_UTC)."签到成功",25);
			}
				
			
			
			$sign_log['user_id'] = $user_id;
			$sign_log['sign_date'] = TIME_UTC;
			$GLOBALS['db']->autoExecute(DB_PREFIX."user_sign_log",$sign_log);					
		}
		
		
		
		$result['status'] = 1;
		$result['info'] = "签到成功";
	}
	
	return $result;
}

/**
 * 按宽度格式化html内容中的图片
 * @param unknown_type $content
 * @param unknown_type $width
 * @param unknown_type $height
 */
function format_html_content_image($content,$width,$height=0)
{
    $res = preg_match_all("/<img.*?src=[\"|\']([^\"|\']*)[\"|\'][^>]*>/i", $content, $matches);
    
    if($res)
    {
        foreach($matches[0] as $k=>$match)
        {
            $old_path = $matches[1][$k];
            $s_old_path = str_replace(SITE_DOMAIN,".",$old_path);
            if(preg_match("/\.\/public\//i", $s_old_path))
            {
                $new_path = get_spec_image($s_old_path,$width,$height,0);
                $content = str_replace($match, "<img src='".$new_path."' />", $content);
            }
        }
    }

    return $content;
}
?>