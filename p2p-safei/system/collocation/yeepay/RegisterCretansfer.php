<?php
	/**
	 * 
	 * @param unknown_type $pMerBillNo
	 * @return string
	 */

	function RegisterCretansferXml($data,$details,$extend,$pWebUrl,$pS2SUrl){
		$strxml = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>"
				."<request platformNo='".$data['platformNo']."'>"
				."<requestNo>" .$data['requestNo'] ."</requestNo>"
				."<platformUserNo>" .$data['platformUserNo'] ."</platformUserNo>"
				."<userType>" .$data['userType'] ."</userType>"
				."<bizType>" .$data['bizType'] ."</bizType>"
				.$details.$extend
				."<callbackUrl><![CDATA[" .$pWebUrl ."]]></callbackUrl>"
				."<notifyUrl><![CDATA[" .$pS2SUrl ."]]></notifyUrl>"
				."</request>";
	
		$strxml=preg_replace("/[\s]{2,}/","",$strxml);//去除空格、回车、换行等空白符
		$strxml=str_replace('\\','',$strxml);//去除转义反斜杠\
		return $strxml;
	}
	
	/**
	 * 登记债权转让
	 * @param int $transfer_id  转让id
	 * @param int $t_user_id  受让用户ID
	 * @param int $MerCode  商户ID
	 * @param string $cert_md5 
	 * @param string $post_url
	 * @return string
	 */
	function RegisterCretansfer($transfer_id,$t_user_id, $platformNo,$post_url){
	
		$transfer = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal_load_transfer where id = ".$transfer_id);
		$deal_id = intval($transfer['deal_id']);
		$user_id = intval($transfer['user_id']);	
		
		$user = get_user_info("*","id = ".$user_id);
		$tuser = get_user_info("*","id = ".$t_user_id);
		$user_load_transfer_fee = $GLOBALS['db']->getOne("SELECT user_load_transfer_fee FROM ".DB_PREFIX."deal WHERE id=".$deal_id);

		if (empty($user['ips_acct_no']) || empty($tuser['ips_acct_no'])){
			return '有一方未申请 ips 帐户';
		}
		
		
		$pWebUrl= SITE_DOMAIN.APP_ROOT."/index.php?ctl=collocation&act=response&class_name=Yeepay&class_act=RegisterCretansfer&from=".$_REQUEST['from'];//web方式返回
		$pS2SUrl= SITE_DOMAIN.APP_ROOT."/index.php?ctl=collocation&act=notify&class_name=Yeepay&class_act=RegisterCretansfer&from=".$_REQUEST['from'];//s2s方式返回		
	
		$sql = "update ".DB_PREFIX."deal_load_transfer set lock_user_id = ".$t_user_id.", lock_time =".TIME_UTC;
		$sql .= " where ips_status = 0 and t_user_id = 0 and status = 1 and (lock_user_id = 0 || lock_user_id =".$t_user_id." || (lock_user_id > 0 && lock_time < ".(TIME_UTC - 600)."))";
		$sql .= " and id = ".$transfer_id;
		
		//echo $sql; exit;
		$GLOBALS['db']->query($sql);
		if ($GLOBALS['db']->affected_rows()){
			
			$yeepay_log = array();
			$yeepay_log['code'] = 'toCpTransaction';
			$yeepay_log['create_date'] = to_date(TIME_UTC,'Y-m-d H:i:s');
			$GLOBALS['db']->autoExecute(DB_PREFIX."yeepay_log",$yeepay_log);
			$requestNo = $GLOBALS['db']->insert_id();
			
			$data = array();
			$data['requestNo'] = $requestNo;//请求流水号
			$data['platformUserNo'] = $tuser['id'];//
			$data['platformNo'] = $platformNo;// 商户编号
			$data['transfer_id'] = $transfer_id;
			
			//用户类型 0普通用户 1 企业用户；现在只支持 普通用户
			if ($tuser['user_type'] == 0){
				$data['userType'] = 'MEMBER';//出款人用户类型
			}else{
				$data['userType'] = 'MERCHANT';//出款人用户类型MEMBER 个人会员  商户
			}
			
			//TENDER 投标 REPAYMENT 还款 CREDIT_ASSIGNMENT 债权转让 TRANSFER 转账 COMMISSION 分润，仅在资金转账明细中使用
			$data['bizType'] = 'CREDIT_ASSIGNMENT';//根据业务的不同，需要传入不同的值，见【业务类型】。并参考下面的详细信息
			
			//投标 扩展字段
			$data['tenderOrderNo'] = $deal_id;//项目编号
			$data['creditorPlatformUserNo'] = $user_id;//债权转让人 
			
			$transfer_requestNo = $GLOBALS['db']->getOne("select pMerBillNo from ".DB_PREFIX."deal_load where id = ".$transfer["load_id"]);
			
			$data['originalRequestNo'] = $transfer_requestNo;//需要转让的投资记录流水号 
			
			//成交服务费
			$fee = round($transfer['transfer_amount'] * $user_load_transfer_fee / 100,2);
			//实际可到账金额
			$targetAmount = $transfer['transfer_amount'] - $fee;
			
			$data["tenderAmount"] = $fee + $targetAmount;
			
			$deal = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."deal where id = ".$deal_id);
			
			$data["tenderName"] = $deal["sub_name"];
			
			$data["borrowerPlatformUserNo"] = $deal["user_id"];
			
			$data["tenderDescription"] = $deal["name"];
			
			//$data["money"] = $deal["name"];
			
			$details = "<details><detail><targetUserType>".$data['userType']."</targetUserType><targetPlatformUserNo>".$user_id."</targetPlatformUserNo><amount>".$targetAmount."</amount><bizType>CREDIT_ASSIGNMENT</bizType></detail>"
					."<detail><targetUserType>MERCHANT</targetUserType><targetPlatformUserNo>$platformNo</targetPlatformUserNo><amount>$fee</amount><bizType>COMMISSION</bizType></detail></details>";
			
			$extend = '<extend>'
				.'<property name="tenderOrderNo" value="'.$data['tenderOrderNo'].'" />'
				.'<property name="creditorPlatformUserNo" value="'.$data['creditorPlatformUserNo'].'" />'
				.'<property name="originalRequestNo" value="'.$data['originalRequestNo'].'" />'
				.'</extend>';
			
			
			$data['details'] = $details;//资金明细记录
			$data['extend'] = $extend;//业务扩展属性，根据业务类型的不同，需要传入不同的参数
			$data['create_time'] = TIME_UTC;	
			
			$GLOBALS['db']->autoExecute(DB_PREFIX."yeepay_cp_transaction",$data,'INSERT');
				
			$id = $GLOBALS['db']->insert_id();
			
			
			$strxml = RegisterCretansferXml($data,$details,$extend,$pWebUrl,$pS2SUrl);
			
			$pSign= cfca($strxml);
			
			$html = '<html><head><meta http-equiv="content-type" content="text/html; charset=UTF-8" /></head><body>
			<form style="display:none;" name="form1" id="form1" method="post" action="'.$post_url.'/bha/toCpTransaction" target="_self">
				<input type="hidden" name="sign" value="'.$pSign.'" />
				<textarea name="req" cols="100" rows="5" style="display:none">'.$strxml.'</textarea>
				<input type="submit" value="提交"></input>
			</form>
			</body></html>
			<script language="javascript">document.form1.submit();</script>';
			//echo $html; exit;
			
			$yeepay_log = array();
			$yeepay_log['strxml'] =$strxml;
			$yeepay_log['html'] = $html;
			$GLOBALS['db']->autoExecute(DB_PREFIX."yeepay_log",$yeepay_log,'UPDATE','id='.$requestNo);
			
			
			return $html;
		}else{
			return '该债权转让已经被其它用户锁定';
		}		
	}
	
	//登记债权转让回调
	function RegisterCretansferCallBack($str3Req,$platformNo,$post_url){
		$pS2SUrl= SITE_DOMAIN.APP_ROOT."/index.php?ctl=collocation&act=notify&class_name=Yeepay&class_act=RegisterCretansferBack&from=".$_REQUEST['from'];//s2s方式返回		

		$requestNo = $str3Req["requestNo"];
		$where = " requestNo = '".$requestNo."'";
		$sql = "update ".DB_PREFIX."yeepay_cp_transaction set is_callback = 1 where is_callback = 0 and ".$where;
		$GLOBALS['db']->query($sql);
		if ($str3Req["code"] == "1"  && $GLOBALS['db']->affected_rows()){
			
			$result = array();
			$result['code'] = $str3Req['code'];
			$result['description'] = strim($str3Req['description'])==""?$str3Req['message']:$str3Req['description'];
			
			$GLOBALS['db']->autoExecute(DB_PREFIX."yeepay_cp_transaction",$result,'UPDATE',$where);			
			if ($GLOBALS['db']->affected_rows()){
				
				$where = " requestNo = '".$requestNo."' and is_callback = 1 and bizType ='CREDIT_ASSIGNMENT' ";
				$ipsdata = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."yeepay_cp_transaction where ".$where);
				$user_id = intval($ipsdata['platformUserNo']);
				$expired = to_date(TIME_UTC+3600*12,"Y-m-d H:i:s");
				
				/* 请求参数 */  
				$req = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>"
				."<request platformNo=\"".$platformNo."\">"
				."<requestNo>".$requestNo."</requestNo>"
				."<mode>CONFIRM</mode>"
				."<notifyUrl><![CDATA[" .$pS2SUrl ."]]></notifyUrl>"
				."</request>";
		
				/* 签名数据 */
				$pSign= cfca($req);
				/* 调用账户查询服务 */
				$service = "COMPLETE_TRANSACTION";
				
				$yeepay_log = array();
				$yeepay_log['code'] = 'bhaController';
				$yeepay_log['strxml'] = $req;
				$yeepay_log['create_date'] = to_date(TIME_UTC,'Y-m-d H:i:s');
				$GLOBALS['db']->autoExecute(DB_PREFIX."yeepay_log",$yeepay_log);
				
				$ch = curl_init($post_url."/bhaexter/bhaController");
				curl_setopt_array($ch, array(
				CURLOPT_POST => TRUE,
				CURLOPT_RETURNTRANSFER => TRUE,
				CURLOPT_SSL_VERIFYPEER=>0,
				CURLOPT_SSL_VERIFYHOST=>0,
				CURLOPT_POSTFIELDS => 'service=' . $service . '&req=' . rawurlencode($req) . "&sign=" . rawurlencode($pSign)
				));
				$resultStr = curl_exec($ch);
				
				if (empty($resultStr)){
					$result = array();
					$result['pErrCode'] = 9999;
					$result['pErrMsg'] = '返回出错';
					$result['pIpsAcctNo'] = '';
					$result['pBalance'] = 0;
					$result['pLock'] = 0;
					$result['pNeedstl'] = 0;
				}else{
						require_once(APP_ROOT_PATH.'system/collocation/ips/xml.php');
						$str3ParaInfo = @XML_unserialize($resultStr);
						//print_r($str3ParaInfo);exit;
						$str3Req = $str3ParaInfo['response'];
						
						$result = array();
						$result['pErrCode'] = $str3Req["code"];
						$result['pErrMsg'] = $str3Req["description"];
						$result['pIpsAcctNo'] = $user_id;	
						if($str3Req["code"] == 1)
						{
							$r_data = array();
							$r_data["is_complete_transaction"] = 1;
							
							$GLOBALS['db']->autoExecute(DB_PREFIX."yeepay_cp_transaction",$r_data,'UPDATE','id='.$ipsdata["id"]);
							
							$sql = "update ".DB_PREFIX."deal_load_transfer set ips_status = 2, pMerBillNo = '".$requestNo."',t_user_id = lock_user_id, transfer_time = '".get_gmtime()."', ips_bill_no = id where ips_status = 0 and id =".$ipsdata["transfer_id"];
							//echo $sql;
							$GLOBALS['db']->query($sql);
							
							$sql = "select * from ".DB_PREFIX."deal_load_transfer where ips_status = 2 and id =".intval($ipsdata['transfer_id']);
								
							$transfer = $GLOBALS['db']->getRow($sql);
								
							//将用户投资回款计划,收款人更改为：承接者
							$sql = "update ".DB_PREFIX."deal_load_repay set t_user_id = '".$transfer['t_user_id']."' where has_repay = 0 and load_id =".intval($transfer['load_id'])." and user_id =".intval($transfer['user_id'])." and deal_id = ".intval($transfer['deal_id']);
							//echo $sql;
							$GLOBALS['db']->query($sql);
							
							
							return 1;
						}
				}
			}
			else
			{
				return '该债权转让已经被其它用户锁定';
			}
			return 1;
		}
		return 1;
	}	
	function RegisterCretansferBack($str3Req)
	{
		$result = array();
		$result['pErrCode'] = $str3Req["code"];
		$result['pErrMsg'] = $str3Req["description"];
		//$result['pIpsAcctNo'] = $user_id;	
		
		$requestNo = $str3Req["requestNo"];
		
		$where = " requestNo = '".$requestNo."' and is_callback = 1 and bizType ='CREDIT_ASSIGNMENT' ";
		$ipsdata = $GLOBALS['db']->getRow("select * from ".DB_PREFIX."yeepay_cp_transaction where ".$where);
		$user_id = intval($ipsdata['platformUserNo']);
		
		if($str3Req["code"] == 1)
		{
			$r_data = array();
			$r_data["is_complete_transaction"] = 1;
			$r_data["update_time"] = TIME_UTC;
			
			$GLOBALS['db']->autoExecute(DB_PREFIX."yeepay_cp_transaction",$r_data,'UPDATE','id='.$ipsdata["id"]);
			if($GLOBALS['db']->affected_rows()>0){
				$sql = "update ".DB_PREFIX."deal_load_transfer set t_user_id = lock_user_id, transfer_time = '".get_gmtime()."', ips_status = 2, ips_bill_no = '".$requestNo."' where ips_status = 1 and id =".intval($ipsdata['transfer_id']);
				//echo $sql;
				$GLOBALS['db']->query($sql);
				
				$sql = "select * from ".DB_PREFIX."deal_load_transfer where ips_status = 2 and id =".intval($ipsdata['transfer_id']);
					
				$transfer = $GLOBALS['db']->getRow($sql);
					
				//将用户投资回款计划,收款人更改为：承接者
				$sql = "update ".DB_PREFIX."deal_load_repay set t_user_id = '".$transfer['t_user_id']."' where has_repay = 0 and load_id =".intval($transfer['load_id']) + " and user_id =".intval($transfer['user_id']) + " and deal_id = ".intval($transfer['deal_id']);
				//echo $sql;
				$GLOBALS['db']->query($sql);
			}
			//return 1;
		}
		return 1;
	}
?>