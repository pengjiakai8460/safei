<?php  if (!defined('THINK_PATH')) exit(); filter_request($_REQUEST); filter_request($_GET); filter_request($_POST); define("AUTH_NOT_LOGIN", 1); define("AUTH_NOT_AUTH", 2); function conf($name,$value = false) { if($value === false) { return C($name); } else { if(M("Conf")->where("is_effect=1 and name='".$name."'")->count()>0) { if(in_array($name,array('EXPIRED_TIME','SUBMIT_DELAY','SEND_SPAN','WATER_ALPHA','MAX_IMAGE_SIZE','INDEX_LEFT_STORE','INDEX_LEFT_TUAN','INDEX_LEFT_YOUHUI','INDEX_LEFT_DAIJIN','INDEX_LEFT_EVENT','INDEX_RIGHT_STORE','INDEX_RIGHT_TUAN','INDEX_RIGHT_YOUHUI','INDEX_RIGHT_DAIJIN','INDEX_RIGHT_EVENT','SIDE_DEAL_COUNT','DEAL_PAGE_SIZE','PAGE_SIZE','BATCH_PAGE_SIZE','HELP_CATE_LIMIT','HELP_ITEM_LIMIT','REC_HOT_LIMIT','REC_NEW_LIMIT','REC_BEST_LIMIT','REC_CATE_GOODS_LIMIT','SALE_LIST','INDEX_NOTICE_COUNT','RELATE_GOODS_LIMIT'))) { $value = intval($value); } M("Conf")->where("is_effect=1 and name='".$name."'")->setField("value",$value); } C($name,$value); } } function write_timezone($zone='') { if($zone=='') $zone = conf('TIME_ZONE'); $var = array( '0' => 'UTC', '8' => 'PRC', ); $timezone_config_str = "<?php\r\n"; $timezone_config_str .= "return array(\r\n"; $timezone_config_str.="'DEFAULT_TIMEZONE'=>'".$var[$zone]."',\r\n"; $timezone_config_str.=");\r\n"; $timezone_config_str.="?>"; @file_put_contents(get_real_path()."public/timezone_config.php",$timezone_config_str); } function save_log($msg,$status) { if(conf("ADMIN_LOG")==1) { $adm_session = es_session::get(md5(conf("AUTH_KEY"))); $log_data['log_info'] = $msg; $log_data['log_time'] = TIME_UTC; $log_data['log_admin'] = intval($adm_session['adm_id']); $log_data['log_ip'] = CLIENT_IP; $log_data['log_status'] = $status; $log_data['module'] = MODULE_NAME; $log_data['action'] = ACTION_NAME; M("Log")->add($log_data); } } function get_toogle_status($tag,$id,$field) { if($tag) { return "<span class='is_effect' onclick=\"toogle_status(".$id.",this,'".$field."');\">".l("YES")."</span>"; } else { return "<span class='is_effect' onclick=\"toogle_status(".$id.",this,'".$field."');\">".l("NO")."</span>"; } } function get_is_effect($tag,$id) { if($tag) { return "<span class='is_effect' onclick='set_effect(".$id.",this);'>".l("IS_EFFECT_1")."</span>"; } else { return "<span class='is_effect' onclick='set_effect(".$id.",this);'>".l("IS_EFFECT_0")."</span>"; } } function get_is_new($tag,$id) { if($tag) { return "<span class='is_new' onclick='set_new(".$id.",this);'>".l("IS_NEW_1")."</span>"; } else { return "<span class='is_new' onclick='set_new(".$id.",this);'>".l("IS_NEW_0")."</span>"; } } function get_sort($sort,$id) { if($tag) { return "<span class='sort_span' onclick='set_sort(".$id.",".$sort.",this);'>".$sort."</span>"; } else { return "<span class='sort_span' onclick='set_sort(".$id.",".$sort.",this);'>".$sort."</span>"; } } function get_isrec($is_rec,$id) { if($tag) { return "<span class='is_rec' onclick='set_isrec(".$id.",".$is_rec.",this);'>".$is_rec."</span>"; } else { return "<span class='is_rec' onclick='set_isrec(".$id.",".$is_rec.",this);'>".$is_rec."</span>"; } } function get_nav($nav_id) { return M("RoleNav")->where("id=".$nav_id)->getField("name"); } function get_module($module_id) { return M("RoleModule")->where("id=".$module_id)->getField("module"); } function get_group($group_id) { if($group_data = M("RoleGroup")->where("id=".$group_id)->find()) $group_name = $group_data['name']; else $group_name = L("SYSTEM_NODE"); return $group_name; } function get_role_name($role_id) { return M("Role")->where("id=".$role_id)->getField("name"); } function get_admin_name($admin_id) { $adm_name = M("Admin")->where("id=".$admin_id)->getField("adm_name"); if($adm_name) return $adm_name; else return l("NONE_ADMIN_NAME"); } function get_log_status($status) { return l("LOG_STATUS_".$status); } function check_sort($sort) { if(!is_numeric($sort)) { return false; } if(intval($sort)<=0) { return false; } return true; } function check_empty($data) { if(trim($data)=='') { return false; } return true; } function set_default($null,$adm_id) { $admin_name = M("Admin")->where("id=".$adm_id)->getField("adm_name"); if($admin_name == conf("DEFAULT_ADMIN")) { return "<span style='color:#f30;'>".l("DEFAULT_ADMIN")."</span>"; } else { return "<a href='".u("Admin/set_default",array("id"=>$adm_id))."'>".l("SET_DEFAULT_ADMIN")."</a>"; } } function get_order_sn($order_id) { return M("DealOrder")->where("id=".$order_id)->getField("order_sn"); } function get_order_sn_with_link($order_id) { $order_info = M("DealOrder")->where("id=".$order_id)->find(); if($order_info['type']==0) $str = l("DEAL_ORDER_TYPE_0")."：<a href='".u("DealOrder/deal_index",array("order_sn"=>$order_info['order_sn']))."'>".$order_info['order_sn']."</a>"; else $str = l("DEAL_ORDER_TYPE_1")."：<a href='".u("DealOrder/incharge_index",array("order_sn"=>$order_info['order_sn']))."'>".$order_info['order_sn']."</a>"; if($order_info['is_delete']==1) $str ="<span style='text-decoration:line-through;'>".$str."</span>"; return $str; } function get_user_name($user_id) { $user_info = M("User")->where("id=".$user_id." and is_delete = 0")->Field("user_name,user_type")->find(); if(!$user_info) return l("NO_USER"); else return "<a href='".u("User/".($user_info['user_type']==0? "index" : "company_index"),array("user_name"=>$user_info['user_name']))."' target='_blank'>".$user_info['user_name']."</a>"; } function get_user_name_real($user_id){ $user_info = M("User")->where("id=".$user_id." and is_delete = 0")->Field("user_name,AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name,user_type")->find(); if(!$user_info) return l("NO_USER"); else return "<a href='".u("User/".($user_info['user_type']==0? "index" : "company_index"),array("user_name"=>$user_info['user_name']))."' target='_blank'>".$user_info['user_name'].($user_info['real_name']!="" ? "[".$user_info['real_name']."]":"")."</a>"; } function get_user_name_reals($user_id){ $user_info = M("User")->where("id=".$user_id." and is_delete = 0")->Field("user_name,AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name")->find(); if(!$user_info) return l("NO_USER"); else return $user_info['user_name'].($user_info['real_name']!="" ? "[".$user_info['real_name']."]":""); } function get_user_name_js($user_id) { $user_name = M("User")->where("id=".$user_id." and is_delete = 0")->getField("AES_DECRYPT(real_name_encrypt,'".AES_DECRYPT_KEY."') as real_name"); if(!$user_name) return l("NO_USER"); else return "<a href='javascript:void(0);' onclick='account(".$user_id.")'>".$user_name."</a>"; } function get_pay_status($status) { return L("PAY_STATUS_".$status); } function get_delivery_status($status,$order_id) { $order_item_ids = $GLOBALS['db']->getOne("select group_concat(id) from ".DB_PREFIX."deal_order_item where order_id = ".intval($order_id)); if(!$order_item_ids) $order_item_ids = 0; $rs = $GLOBALS['db']->getAll("select dn.notice_sn,dn.id from ".DB_PREFIX."delivery_notice as dn where dn.order_item_id in (".$order_item_ids.") "); $result = ""; foreach($rs as $row) { $result .= "&nbsp;".get_notice_info($row['notice_sn'],$row['id'])."<br />"; } return L("ORDER_DELIVERY_STATUS_".$status)."<br />".$result; } function get_notice_info($sn,$notice_id) { $express_name = M()->query("select e.name as ename from ".DB_PREFIX."express as e left join ".DB_PREFIX."delivery_notice as dn on dn.express_id = e.id where dn.id = ".$notice_id); $express_name = $express_name[0]['ename']; if($express_name) $str = $express_name."<br/>&nbsp;".$sn; else $str = $sn; return $str; } function get_payment_name($payment_id) { return M("Payment")->where("id=".$payment_id)->getField("name"); } function get_delivery_name($delivery_id) { return M("Delivery")->where("id=".$delivery_id)->getField("name"); } function get_region_name($region_id) { return M("DeliveryRegion")->where("id=".$region_id)->getField("name"); } function get_city_name($id) { return M("DealCity")->where("id=".$id)->getField("name"); } function get_message_type($type_name,$rel_id) { $show_name = M("MessageType")->where("type_name='".$type_name."'")->getField("show_name"); if($type_name=='deal_order') { $order_sn = M("DealOrder")->where("id=".$rel_id)->getField("order_sn"); if($order_sn) return "[".$order_sn."] <a href='".u("DealOrder/deal_index",array("id"=>$rel_id))."'>".$show_name."</a>"; else return $show_name; } elseif($type_name=='deal') { $sub_name = M("Deal")->where("id=".$rel_id)->getField("sub_name"); if($sub_name) return "[".$sub_name."]" .$show_name; else return $show_name; } elseif($type_name=='supplier') { $name = M("Supplier")->where("id=".$rel_id)->getField("name"); if($name) return "[".$name."] <a href='".u("Supplier/index",array("id"=>$rel_id))."'>".$show_name."</a>"; else return $show_name; } else { if($show_name) return $show_name; else return $type_name; } } function get_send_status($status) { return L("SEND_STATUS_".$status); } function get_send_mail_type($deal_id) { if($deal_id>0) return l("DEAL_NOTICE"); else return l("COMMON_NOTICE"); } function get_send_type($send_type) { return l("SEND_TYPE_".$send_type); } function get_all_files( $path ) { $list = array(); $dir = @opendir($path); while (false !== ($file = @readdir($dir))) { if($file!='.'&&$file!='..') if( is_dir( $path.$file."/" ) ){ $list = array_merge( $list , get_all_files( $path.$file."/" ) ); } else { $list[] = $path.$file; } } @closedir($dir); return $list; } function get_order_item_name($id) { return M("DealOrderItem")->where("id=".$id)->getField("name"); } function get_supplier_name($id) { return M("Supplier")->where("id=".$id)->getField("name"); } function get_send_type_msg($status) { if($status==0) { return l("SMS_SEND"); } else { return l("MAIL_SEND"); } } function show_content($content,$id) { return "<a title='".l("VIEW")."' href='javascript:void(0);' onclick='show_content(".$id.")'>".l("VIEW")."</a>"; } function get_is_send($is_send) { if($is_send==0) return L("NO"); else return L("YES"); } function get_send_result($result) { if($result==0) { return L("FAILED"); } else { return L("SUCCESS"); } } function get_is_buy($is_buy) { return l("IS_BUY_".$is_buy); } function get_point($point) { return l("MESSAGE_POINT_".$point); } function get_status($status) { if($status) { return l("YES"); } else return l("NO"); } function getMPageName($page) { return L('MPAGE_'.strtoupper($page)); } function getMTypeName($type) { return L('MTYPE_'.strtoupper($type)); } function get_submit_user($uid) { if($uid==0) return "管理员发布"; else { $uname = M("SupplierAccount")->where("id=".$uid)->getField("account_name"); return $uname?$uname:"商家不存在"; } } function get_event_cate_name($id) { return M("EventCate")->where("id=".$id)->getField("name"); } function get_deal_user($uid) { $uinfo = M("User")->getById($uid); if($uinfo) { return $uinfo['user_name']; } else { if($uid==0) return "管理员发起"; else return "发起人被删除"; } } function get_to_date($time) { if($time==0)return "长期"; if($time<get_gmtime()) { return "<span style='color:#f30;'>过期</span>"; } else { return "<span>".to_date($time,"Y/m/d H:i")."</span>"; } } function write_sys_conf(){ $return = array("status"=>0,"info"=>""); $sys_configs = M("Conf")->findAll(); $config_str = "<?php\n"; $config_str .= "return array(\n"; foreach($sys_configs as $k=>$v) { $config_str.="'".$v['name']."'=>'".addslashes($v['value'])."',\n"; } $config_str.=");\n ?>"; $filename = get_real_path()."public/sys_config.php"; if (!$handle = fopen($filename, 'w')) { $return['info'] = l("OPEN_FILE_ERROR").$filename; return $return; } if (fwrite($handle, $config_str) === FALSE) { $return['info'] = l("WRITE_FILE_ERROR").$filename; return $return; } fclose($handle); return array("status"=>1,"info"=>""); } return array ( 'app_debug' => false, 'app_domain_deploy' => false, 'app_plugin_on' => false, 'app_file_case' => false, 'app_group_depr' => '.', 'app_group_list' => '', 'app_autoload_reg' => false, 'app_autoload_path' => 'Think.Util.,@.COM.', 'app_config_list' => array ( 0 => 'taglibs', 1 => 'routes', 2 => 'tags', 3 => 'htmls', 4 => 'modules', 5 => 'actions', ), 'cookie_expire' => 3600, 'cookie_domain' => '', 'cookie_path' => '/', 'cookie_prefix' => '', 'default_app' => '@', 'default_group' => 'Home', 'default_module' => 'Index', 'default_action' => 'index', 'default_charset' => 'utf-8', 'default_timezone' => 'PRC', 'default_ajax_return' => 'JSON', 'default_theme' => 'default', 'default_lang' => 'zh-cn', 'db_type' => 'mysql', 'db_host' => '127.0.0.1', 'db_name' => 'p2p-safei', 'db_user' => 'root', 'db_pwd' => 'root', 'db_port' => '3306', 'db_prefix' => 'p2p_', 'db_suffix' => '', 'db_fieldtype_check' => false, 'db_fields_cache' => true, 'db_charset' => 'utf8', 'db_deploy_type' => 0, 'db_rw_separate' => false, 'data_cache_time' => -1, 'data_cache_compress' => false, 'data_cache_check' => false, 'data_cache_type' => 'File', 'data_cache_path' => './admin/../public/runtime/admin/Temp/', 'data_cache_subdir' => false, 'data_path_level' => 1, 'error_message' => '您浏览的页面暂时发生了错误！请稍后再试～', 'error_page' => '', 'html_cache_on' => false, 'html_cache_time' => 60, 'html_read_type' => 0, 'html_file_suffix' => '.shtml', 'lang_switch_on' => false, 'lang_auto_detect' => true, 'log_record' => false, 'log_file_size' => 2097152, 'log_record_level' => array ( 0 => 'EMERG', 1 => 'ALERT', 2 => 'CRIT', 3 => 'ERR', ), 'page_rollpage' => 5, 'page_listrows' => 30, 'session_auto_start' => true, 'show_run_time' => false, 'show_adv_time' => false, 'show_db_times' => false, 'show_cache_times' => false, 'show_use_mem' => false, 'show_page_trace' => false, 'show_error_msg' => true, 'tmpl_engine_type' => 'Think', 'tmpl_detect_theme' => false, 'tmpl_template_suffix' => '.html', 'tmpl_cachfile_suffix' => '.php', 'tmpl_deny_func_list' => 'echo,exit', 'tmpl_parse_string' => '', 'tmpl_l_delim' => '{', 'tmpl_r_delim' => '}', 'tmpl_var_identify' => 'array', 'tmpl_strip_space' => false, 'tmpl_cache_on' => '0', 'tmpl_cache_time' => -1, 'tmpl_action_error' => 'Public:error', 'tmpl_action_success' => 'Public:success', 'tmpl_trace_file' => './admin/ThinkPHP/Tpl/PageTrace.tpl.php', 'tmpl_exception_file' => './admin/ThinkPHP/Tpl/ThinkException.tpl.php', 'tmpl_file_depr' => '/', 'taglib_begin' => '<', 'taglib_end' => '>', 'taglib_load' => true, 'taglib_build_in' => 'cx', 'taglib_pre_load' => '', 'tag_nested_level' => 3, 'tag_extend_parse' => '', 'token_on' => 0, 'token_name' => '__hash__', 'token_type' => 'md5', 'url_case_insensitive' => false, 'url_router_on' => false, 'url_dispatch_on' => true, 'url_model' => '0', 'url_pathinfo_model' => 2, 'url_pathinfo_depr' => '/', 'url_html_suffix' => '', 'var_group' => 'g', 'var_module' => 'm', 'var_action' => 'a', 'var_router' => 'r', 'var_page' => 'p', 'var_template' => 't', 'var_language' => 'l', 'var_ajax_submit' => 'ajax', 'var_pathinfo' => 's', 'default_admin' => 'admin', 'auth_key' => 'yuemordk', 'time_zone' => '8', 'admin_log' => '1', 'db_version' => '3.6', 'db_vol_maxsize' => '8000000', 'water_mark' => '', 'currency_unit' => '￥', 'big_width' => '500', 'big_height' => '500', 'small_width' => '200', 'small_height' => '200', 'water_alpha' => '75', 'water_position' => '4', 'max_image_size' => '3000000', 'allow_image_ext' => 'jpg,gif,png', 'max_file_size' => '1', 'allow_file_ext' => '1', 'bg_color' => '#ffffff', 'is_water_mark' => '1', 'template' => 'new', 'score_unit' => '积分', 'user_verify' => '0', 'shop_logo' => './public/attachment/201708/18/10/59964c4eec921.png', 'shop_lang' => 'zh-cn', 'shop_title' => '上海萨飞投资管理有限公司', 'shop_keyword' => '萨飞,萨飞资本,萨飞宝,上海萨飞投资管理有限公司,', 'shop_description' => '萨飞宝-专业透明的供应链金融综合产品理财平台，由上海萨飞投资管理有限公司投资运营。', 'shop_tel' => '400-778-1969', 'invite_referrals' => '1', 'online_qq' => 'a:6:{i:0;a:2:{s:4:\\"name\\";s:13:\\"萨飞-浅浅\\";s:2:\\"qq\\";s:10:\\"3446416536\\";}i:1;a:2:{s:4:\\"name\\";s:13:\\"萨飞-馨佑\\";s:2:\\"qq\\";s:10:\\"2370666086\\";}i:2;a:2:{s:4:\\"name\\";s:13:\\"萨飞-夏漠\\";s:2:\\"qq\\";s:10:\\"3012910441\\";}i:3;a:2:{s:4:\\"name\\";s:13:\\"萨飞-梦梦\\";s:2:\\"qq\\";s:10:\\"3458585924\\";}i:4;a:2:{s:4:\\"name\\";s:13:\\"萨飞-芸草\\";s:2:\\"qq\\";s:10:\\"3457295692\\";}i:5;a:2:{s:4:\\"name\\";s:13:\\"萨飞-天意\\";s:2:\\"qq\\";s:10:\\"3457271661\\";}}', 'online_time' => '周一至周日 9:00-18:00', 'deal_page_size' => '10', 'page_size' => '20', 'help_cate_limit' => '4', 'help_item_limit' => '4', 'shop_footer' => '<div style=\\"text-align:right;\\">
	联系我们：
</div>
<div style=\\"text-align:right;\\">
	&copy; 2015 萨飞宝信贷 All rights reserved<br />
	<p style=\\"color:#666666;font-family:\'Microsoft YaHei\';text-align:right;background-color:#F6F6F6;\\">
		<br />
	</p>
</div>', 'custom_service' => ',', 'sms_send_repay' => '1', 'user_message_auto_effect' => '1', 'mail_send_payment' => '1', 'sms_send_payment' => '0', 'reply_address' => 'info@yuemor.com', 'mail_on' => '1', 'sms_on' => '1', 'batch_page_size' => '500', 'public_domain_root' => '', 'referrals_delay' => '1', 'submit_delay' => '5', 'app_msg_sender_open' => '1', 'admin_msg_sender_open' => '1', 'shop_open' => '1', 'shop_close_html' => '', 'footer_logo' => '', 'gzip_on' => '0', 'integrate_code' => '', 'integrate_cfg' => '', 'shop_seo_title' => '【萨飞资本】官网-萨飞宝', 'referral_ip_limit' => '0', 'cache_on' => '0', 'expired_time' => '0', 'filter_word' => '', 'style_open' => '0', 'style_default' => '1', 'tmpl_domain_root' => '', 'invite_referrals_type' => '1', 'memcache_host' => '127.0.0.1:11211', 'image_username' => 'admin', 'image_password' => 'admin', 'register_type' => '1', 'attr_select' => '0', 'icp_license' => '', 'count_code' => '', 'deal_msg_lock' => '0', 'promote_msg_lock' => '0', 'send_span' => '2', 'user_loan_interest_manage_fee' => '0', 'investors_commission_ratio' => '10', 'borrower_commission_ratio' => '10', 'generation_repay_fee' => '0', 'user_bid_score_fee' => '0', 'shop_search_keyword' => '萨飞，萨飞资本，萨飞宝，萨飞投资', 'index_notice_count' => '5', 'domain_root' => '', 'main_app' => 'shop', 'verify_image' => '0', 'apns_msg_lock' => '1', 'promote_msg_page' => '440180', 'apns_msg_page' => '0', 'apple_dowload_url' => 'https://itunes.apple.com/us/app/%E8%90%A8%E9%A3%9E%E5%AE%9D/id1273152380?l=zh&ls=1&mt=8', 'android_dowload_url' => 'https://www.pgyer.com/sfbapp', 'borrow_agreement' => '11', 'user_login_score' => '0', 'company' => '萨飞投资管理（上海）有限公司', 'company_address' => '上海市杨浦区', 'company_reg_address' => '上海市', 'manage_fee' => '6', 'manage_impose_fee_day1' => '0.1', 'manage_impose_fee_day2' => '0.5', 'impose_fee_day1' => '0.05', 'impose_fee_day2' => '0.1', 'compensate_fee' => '0', 'impose_point' => '0', 'yz_impose_point' => '0', 'yz_impse_day' => '31', 'repay_success_point' => '0', 'repay_success_day' => '0', 'repay_success_limit' => '0', 'user_register_point' => '0', 'user_register_money' => '0', 'user_register_score' => '0', 'max_borrow_quota' => '1000000', 'min_borrow_quota' => '3000', 'user_repay_quota' => '0', 'user_loan_manage_fee' => '0', 'sms_repay_touser_on' => '0', 'mail_send_contract_on' => '1', 'deal_bid_multiple' => '0', 'user_lock_money' => '0', 'user_bid_rebate' => '0', 'agreement' => '107', 'privacy' => '2', 'user_load_transfer_fee' => '1', 'virtual_money_1' => '', 'virtual_money_2' => '', 'virtual_money_3' => '', 'open_autobid' => '1', 'open_ips' => '0', 'ips_mercode' => 'GPhKt7sh4dxQQZZkINGFtefRKNPyAj8S00cgAwtRyy0ufD7alNC28xCBKpa6IU7u54zzWSAv4PqUDKMgpOnM7fucO1wuwMi4RgPAnietmqYIhHXZ3TqTGKNzkxA55qYH', 'ips_key' => '808801', 'ips_3des_key' => '2EDxsEfp', 'ips_3des_iv' => 'ICHuQplJ0YR9l7XeVNKi6FMn', 'ips_fee_type' => '1', 'invite_referrals_min' => '10', 'invite_referrals_max' => '20', 'invite_referrals_rate' => '0.1', 'invite_referrals_auto' => '0', 'invite_referrals_date' => '12', 'user_login_money' => '0', 'user_login_point' => '0', 'open_quota' => '1', 'open_point' => '1', 'user_login_keep_money' => '0', 'user_login_keep_score' => '0', 'user_login_keep_point' => '0', 'sms_send_ip_noallow' => '', 'user_register_redbag' => '0', 'mobile_head' => '15|18|13|17|19', 'show_exprie_deal' => '1', 'score_page_size' => '12', 'user_login_nmc_money' => '0', 'user_login_keep_nmc_money' => '0', 'user_login_money_type' => '0', 'user_login_keep_money_type' => '0', 'licai_open' => '0', 'pay_radio' => '0.5', 'buy_presend_point_multiple' => '0.3', 'repay_make' => '0', 'score_trade_number' => '20', 'buy_presend_score_multiple' => '0.1', 'buy_invite_referrals' => '0', 'referral_limit' => '1', 'interestrate_time' => '1', 'weixin_msg' => '1', 'app_name' => '借贷商业系统', 'app_sub_ver' => 9636, '_taglibs_' => array ( 'html' => '@.TagLib.TagLibHtml', ), ); ?>