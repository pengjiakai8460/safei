<div class="buttons-tab">
  <a href="#tab1" class="tab-link button active">借款人</a>
  <a href="#tab2" class="tab-link button">审核记录</a>
  <a href="#tab3" class="tab-link button">投资记录</a>
  <a href="#tab4" class="tab-link button">留言列表</a>
</div>
<div class="tabs">
	<div id="tab1" class="tab active">
		<div class="content-block-title"> 借款详情</div>
		<div class="list-block row no-gutter">
                <div class="item-box">
					<?php echo $this->_var['data']['deal']['description']; ?>
				</div>
		</div>
				
        <div class="content-block-title"> 基本信息</div>
        <div class="list-block row no-gutter">
            <ul class="no-border">
                <li class=" guide-box">
                	<div class="item-box">
                		<div class="col-50">
	                		<div class="item-title">融资方</div>
	                		<div class="item-content"><?php echo $this->_var['data']['u_info']['user_name']; ?></div>
                		</div>
                		<div class="col-50">
                			<div class="item-title">性别</div>
	                    	<div class="item-content">
	                    		<?php if ($this->_var['data']['u_info']['sex'] > 0): ?><?php if ($this->_var['data']['u_info']['sex'] == 1): ?>男<?php else: ?>女<?php endif; ?><?php else: ?>未知<?php endif; ?>
	                    	</div>
                		</div>
                	</div>
                </li>
                <li class=" guide-box">
                	<div class="item-box">
                		<div class="col-50">
	                    	<div class="item-title">年龄</div>
	                    	<div class="item-content">
	                    		<?php if ($this->_var['data']['u_info']['byear'] > 0): ?><?php echo to_date(get_gmtime(),"Y")- $this->_var['data']['u_info']['byear'];?>岁<?php else: ?>未知<?php endif; ?>
	                    	</div>
                    	</div>
                    	<div class="col-50">
                    		<div class="item-title">是否结婚</div>
		                    <div class="item-content"><?php echo $this->_var['data']['u_info']['marriage']; ?></div>
		                </div>
                    </div>
                </li> 
             
                <li class="guide-box">
                	<div class="item-box">
                		<div class="col-50">
	                    	<div class="item-title">工作城市</div>
							<div class="item-content">
	                        	<?php echo $this->_var['data']['u_info']['workinfo']['region_province']; ?><?php echo $this->_var['data']['u_info']['workinfo']['region_city']; ?>
							</div>
						</div>
						<div class="col-50">
							<div class="item-title">公司行业</div>
                    		<div class="item-content"><?php echo $this->_var['data']['u_info']['workinfo']['officedomain']; ?></div>
						</div>
					</div>
				</li>
				
                <li class="guide-box">
                	<div class="item-box">
                		<div class="col-50">
	                    	<div class="item-title">公司规模</div>
	                    	<div class="item-content"><?php echo $this->_var['data']['u_info']['workinfo']['officecale']; ?></div>
	                    </div>
	                    <div class="col-50">
	                    	<div class="item-title">工作收入</div>
                    		<div class="item-content"><?php echo $this->_var['data']['u_info']['workinfo']['salary']; ?></div>
	                    </div>
                    </div>
                </li>
           
                <li class="guide-box">
                	<div class="item-box">
                		<div class="col-50">
	                    	<div class="item-title">学历</div>
	                    	<div class="item-content"><?php echo $this->_var['data']['u_info']['graduation']; ?></div>
	                    </div>
	                    <div class="col-50">
	                    	<div class="item-title">有无购房</div>
	                    	<div class="item-content">
	                    		<?php if ($this->_var['data']['u_info']['hashouse'] == 1): ?><?php if ($this->_var['data']['u_info']['housepassed'] == 1): ?><font>有</font><?php else: ?>有<?php endif; ?><?php else: ?>无<?php endif; ?>
	                    	</div>
	                    </div>
	                    
                    </div>
                </li>
                
 			</ul>
        </div>
        
        <div class="content-block-title">借贷记录</div>
        <div class="list-block row no-gutter">
            <ul>
                <li class="guide-box">
                	<div class="item-box">
                		<div class="col-50">
	            			<div class="item-title">借款笔数</div>
	            			<div class="item-content"><?php echo $this->_var['data']['user_statics']['deal_count']; ?></div>
	            		</div>
	            		<div class="col-50">
	            			<div class="item-title">成功笔数</div>
            				<div class="item-content"><?php echo $this->_var['data']['user_statics']['success_deal_count']; ?></div>
	            		</div>
	            	</div>
            	</li>
            	
            	 <li class="guide-box">
                	<div class="item-box">
                		<div class="col-50">
	            			<div class="item-title">还清笔数</div>
                			<div class="item-content"><?php echo $this->_var['data']['user_statics']['repay_deal_count']; ?></div>
	            		</div>
	            		<div class="col-50">
	            			<div class="item-title">逾期次数</div>
            				<div class="item-content"><?php echo $this->_var['data']['user_statics']['yuqi_count']; ?></div>
	            		</div>
	            	</div>
            	</li>
            	
            	<li class="guide-box">
                	<div class="item-box">
                		<div class="col-50">
	            			<div class="item-title">共计借入</div>
            				<div class="item-content"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_statics']['borrow_amount'],
);
echo $k['name']($k['v']);
?></div>
	            		</div>
	            		<div class="col-50">
	            			<div class="item-title">待还本息</div>
            				<div class="item-content"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data'][''],
);
echo $k['name']($k['v']);
?></div>
	            		</div>
	            	</div>
            	</li>
          		
          		<li class="guide-box">
                	<div class="item-box">
                		<div class="col-50">
	            			<div class="item-title">逾期金额</div>
            				<div class="item-content"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_statics']['yuqi_amount'],
);
echo $k['name']($k['v']);
?></div>
	            		</div>
	            		<div class="col-50">
	            			<div class="item-title">共计借出</div>
            				<div class="item-content"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_statics']['load_money'],
);
echo $k['name']($k['v']);
?></div>
	            		</div>
	            	</div>
            	</li>
            	
               <li class="guide-box">
                	<div class="item-box">
                		<div class="col-50">
	            			<div class="item-title">待收本息</div>
	            			<div class="item-content">
	            				<?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['data']['user_statics']['load_wait_repay_money'],
);
echo $k['name']($k['v']);
?>
	            			</div>
	            		</div>
	            		<div class="col-50">
	            		</div>
	            	</div>
            	</li>
              
            </ul>
        </div>
	</div><!--tab1-->
	<div id="tab2" class="tab">
            <div class="content-block-title row no-gutter">
				<div class="col-40 text-center">审核项目</div>
				<div class="col-20 text-center">状态</div>
				<div class="col-40 text-center">通过时间</div>
			</div>
            
            <div class="list-block">
          		<ul>
          		<?php if ($this->_var['data']['u_info']['idcardpassed'] == 1 || ( $this->_var['data']['u_info']['idcardpassed'] == 0 && $this->_var['data']['credit_file']['credit_identificationscanning']['file_list'] )): ?>
	              <li class="row no-gutter">
                	 <div class="item-box">
                        <div class="col-33 text-center">身份证认证</div>
                   
                    	<div class="col-33 text-center">
                    		<?php if ($this->_var['data']['u_info']['idcardpassed'] == 1): ?><span class="Tick">已通过</span><?php else: ?>待审核<?php endif; ?>
                    	</div>
                  
                        <div class="col-33 text-center">
                        	<?php if ($this->_var['data']['u_info']['idcardpassed'] == 1): ?><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['idcardpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?><?php endif; ?>
                    	</div>
                    </div>
                        		
                </li> 
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['workpassed'] == 1 || ( $this->_var['data']['u_info']['workpassed'] == 0 && $this->_var['data']['credit_file']['credit_contact']['file_list'] )): ?>
                 <li class="row no-gutter">
                	 <div class="item-box">
                        <div class="col-33 text-center">工作认证</div>
                    	<div class="col-33 text-center">
		                    <?php if ($this->_var['data']['u_info']['workpassed'] == 1): ?>
					   		<?php if ($this->_var['data']['expire']['workpassed_expire']): ?>
							已过期
							<?php else: ?><span class="Tick">已通过</span><?php endif; ?>
							<?php else: ?>
							待审核
							<?php endif; ?>
						</div>
                        <div class="col-33 text-center">
	                    <?php if (! $this->_var['data']['expire']['workpassed_expire']): ?>
		            	<?php if ($this->_var['data']['u_info']['workpassed'] == 1): ?>
		                <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['workpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
						<?php endif; ?><?php endif; ?>
						</div>
					</div>
                </li>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['creditpassed'] == 1 || ( $this->_var['data']['u_info']['creditpassed'] == 0 && $this->_var['data']['credit_file']['credit_credit']['file_list'] )): ?>
                  <li class="row no-gutter">
                	 <div class="item-box">
                        <div class="col-33 text-center">信用报告</div>
                        <div class="col-33 text-center"><?php if ($this->_var['data']['u_info']['creditpassed'] == 1): ?>
							<?php if ($this->_var['data']['expire']['creditpassed_expire']): ?>
							已过期
							<?php else: ?><span class="Tick">已通过</span><?php endif; ?>
							<?php else: ?>
							待审核
							<?php endif; ?>
						</div>
                        <div class="col-33 text-center">
                        	<?php if (! $this->_var['data']['expire']['creditpassed_expire']): ?>
			            	<?php if ($this->_var['data']['u_info']['creditpassed'] == 1): ?>
			                <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['creditpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
							<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
                </li>
                <?php endif; ?>
         <!-- xsz -->       
                <?php if ($this->_var['data']['u_info']['incomepassed'] == 1 || ( $this->_var['data']['u_info']['incomepassed'] == 0 && $this->_var['data']['credit_file']['credit_incomeduty']['file_list'] )): ?>
                <li class="row no-gutter">
                	 <div class="item-box">
                        	<div class="col-33 text-center">收入认证</div>
                        	<div class="col-33 text-center"><?php if ($this->_var['data']['u_info']['incomepassed'] == 1): ?>
								<?php if ($this->_var['data']['expire']['incomepassed_expire']): ?>
								已过期
								<?php else: ?><span class="Tick">已通过</span><?php endif; ?>
								<?php else: ?>
								待审核
								<?php endif; ?>
							</div>
                        	<div class="col-33 text-center"><?php if (! $this->_var['data']['expire']['incomepassed_expire']): ?>
			             	<?php if ($this->_var['data']['u_info']['incomepassed'] == 1): ?>
			                <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['incomepassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
						    <?php endif; ?>
							<?php endif; ?>
							</div>
					</div>
                </li>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['housepassed'] == 1 || ( $this->_var['data']['u_info']['housepassed'] == 0 && $this->_var['data']['credit_file']['credit_house']['file_list'] )): ?>
                 <li class="row no-gutter">
                	 <div class="item-box">
                        <div class="col-33 text-center">房产认证</div>
                        <div class="col-33 text-center">
                        	<?php if ($this->_var['data']['u_info']['housepassed'] == 1): ?><span class="Tick">已通过</span><?php else: ?>
							待审核
							<?php endif; ?>
						</div>
                        <div class="col-33 text-center"> <?php if ($this->_var['data']['u_info']['housepassed'] == 1): ?>
			               <?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['housepassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
						   <?php endif; ?>
						</div>
				   </div>
                </li>
                 <?php endif; ?>
                 
                <?php if ($this->_var['data']['u_info']['carpassed'] == 1 || ( $this->_var['data']['u_info']['carpassed'] == 0 && $this->_var['data']['credit_file']['credit_car']['file_list'] )): ?>
                 <li class="row no-gutter">
                	 <div class="item-box">
                        <div class="col-33 text-center">
                        	购车证明
                    	</div>
                		<div class="col-33 text-center">
	                		<?php if ($this->_var['data']['u_info']['carpassed'] == 1): ?><span class="Tick">已通过</span><?php else: ?>
							待审核
							<?php endif; ?>
						</div>
	                    <div class="col-33 text-center">
	                    	<?php if ($this->_var['data']['u_info']['carpassed'] == 1): ?>
			            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['carpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
							<?php endif; ?>
						</div>
					</div>
                </li>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['marrypassed'] == 1 || ( $this->_var['data']['u_info']['marrypassed'] == 0 && $this->_var['data']['credit_file']['credit_marriage']['file_list'] )): ?>
               <li class="row no-gutter">
                	 <div class="item-box">
                    	<div class="col-33 text-center">结婚认证</div>
                    	<div class="col-33 text-center"><?php if ($this->_var['data']['u_info']['marrypassed'] == 1): ?><span class="Tick">已通过</span><?php else: ?>
						待审核
						<?php endif; ?></div>
	                    <div class="col-33 text-center"><?php if ($this->_var['data']['u_info']['marrypassed'] == 1): ?>
		            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['marrypassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
						<?php endif; ?>
						</div>
					</div>
                </li>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['edupassed'] == 1 || ( $this->_var['data']['u_info']['edupassed'] == 0 && $this->_var['data']['credit_file']['credit_graducation']['file_list'] )): ?>
                <li class="row no-gutter">
                	 <div class="item-box">
                        <div class="col-33 text-center">学历认证 </div>
					
                    	<div class="col-33 text-center">
                    		<?php if ($this->_var['data']['u_info']['edupassed'] == 1): ?><span class="Tick">已通过</span><?php else: ?>
							待审核
							<?php endif; ?>
						</div>
					
                        <div class="col-33 text-center"><?php if ($this->_var['data']['u_info']['edupassed'] == 1): ?>
			            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['edupassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
							<?php endif; ?>
						</div>
					</div>	
				</li>
                <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['skillpassed'] == 1 || ( $this->_var['data']['u_info']['skillpassed'] == 0 && $this->_var['data']['credit_file']['credit_titles']['file_list'] )): ?>
                <li class="row no-gutter">
                	 <div class="item-box">
                        	<div class="col-33 text-center">职称认证</div>	
                        	<div class="col-33 text-center">
                        		<?php if ($this->_var['data']['u_info']['skillpassed'] == 1): ?><span class="Tick">已通过</span><?php else: ?>
                        		待审核
                        		<?php endif; ?>
                        	</div>	
                        	<div class="col-33 text-center">
                        		<?php if ($this->_var['data']['u_info']['skillpassed'] == 1): ?>
                        		<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['skillpassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
                        		<?php endif; ?>
							</div>	
						</div>	
				 </li>
                 <?php endif; ?>
                 
                 <?php if ($this->_var['data']['u_info']['videopassed'] == 1 || ( $this->_var['data']['u_info']['videopassed'] == 0 && $this->_var['data']['u_info']['has_send_video'] == 1 )): ?>
                 <li class="row no-gutter">
                 	  <div class="item-box">
                        	<div class="col-33 text-center">视频认证</div>	
                        	<div class="col-33 text-center">
                        		<?php if ($this->_var['u_info']['videopassed'] == 1): ?><span class="Tick">已通过</span><?php else: ?>
                        		待审核
                        		<?php endif; ?>
                        	</div>	
                        	<div class="col-33 text-center">
                        		<?php if ($this->_var['u_info']['videopassed'] == 1): ?>
                        		<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['videopassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
                        		<?php endif; ?>
							</div>	
						</div>
					</li>
                 <?php endif; ?>
                
                <?php if ($this->_var['data']['u_info']['mobiletruepassed'] == 1 || ( $this->_var['data']['u_info']['mobiletruepassed'] == 0 && $this->_var['data']['credit_file']['credit_mobilereceipt']['file_list'] )): ?>
                <li class="row no-gutter">
                	 <div class="item-box">
                    	<div class="col-33 text-center">手机实名认证</div>	
                    	<div class="col-33 text-center">
                    		<?php if ($this->_var['data']['u_info']['mobiletruepassed'] == 1): ?><span class="Tick">已通过</span><?php else: ?>
							待审核
							<?php endif; ?>
						</div>	
                       <div class="col-33 text-center">
                       	<?php if ($this->_var['data']['u_info']['mobiletruepassed'] == 1): ?>
                       	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['mobiletruepassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
                       	<?php endif; ?>
						</div>
					</div>	
				</li>
                <?php endif; ?>   
                
                <?php if ($this->_var['data']['u_info']['residencepassed'] == 1 || ( $this->_var['data']['u_info']['residencepassed'] == 0 && $this->_var['data']['credit_file']['credit_residence']['file_list'] )): ?>
                <li class="row no-gutter">
                    <div class="item-box">
                    	<div class="col-33 text-center">居住地证明</div>
                    	<div class="col-33 text-center"><?php if ($this->_var['data']['u_info']['residencepassed'] == 1): ?>
							<?php if ($this->_var['data']['expire']['residencepassed_expire']): ?>
							已过期
							<?php else: ?><span class="Tick">已通过</span><?php endif; ?>
							<?php else: ?>
							待审核
							<?php endif; ?>
						</div>	
	                   <div class="col-33 text-center">
	                   		<?php if (! $this->_var['data']['expire']['residencepassed_expire']): ?>
			            	<?php if ($this->_var['data']['u_info']['residencepassed'] == 1): ?>
			            	<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['data']['u_info']['residencepassed_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
							<?php endif; ?>
							<?php endif; ?>
						</div>
					</div>
				</li>
                <?php endif; ?>
               </ul>
            </div>
	</div><!--tab2-->
	<div id="tab3" class="tab">
		<div class="content-block-title row no-gutter">
			<div class="col-20 text-center">投资人</div>
			<div class="col-35 text-center">金额</div>
			<div class="col-45 text-center">时间</div>
		</div>
        <div class="list-block">
        	 <ul>
         	 <?php $_from = $this->_var['data']['load_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'load');if (count($_from)):
    foreach ($_from AS $this->_var['load']):
?>
           
                <li class="row no-gutter">
                    <div class="item-box">
                    	<div class=" col-20 text-center"><?php 
$k = array (
  'name' => 'utf_substr',
  'v' => $this->_var['load']['user_name'],
);
echo $k['name']($k['v']);
?></div>
                    	<div class=" col-35 text-center"><?php 
$k = array (
  'name' => 'format_price',
  'v' => $this->_var['load']['money'],
);
echo $k['name']($k['v']);
?></div>
                    	<div class=" col-45 text-center"><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['load']['create_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?>
                    		<?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['load']['create_time'],
  'f' => 'H:i',
);
echo $k['name']($k['v'],$k['f']);
?>
						</div>
					</div>
                </li>
            
         	 <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
          
            </ul>
        </div>
	</div><!--tab3-->
	<div id="tab4" class="tab">
         <div class="contentblock">
         	
        	<?php if ($this->_var['data']['message']): ?>
	          <ul>
	          	<?php $_from = $this->_var['data']['message']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'load');if (count($_from)):
    foreach ($_from AS $this->_var['load']):
?>
	          	<li class="w_b bb1">
	          		<div class="img_block"><img src="<?php 
$k = array (
  'name' => 'wap_user_avatar',
  'uid' => $this->_var['load']['user_id'],
);
echo $k['name']($k['uid']);
?>" style="width:100%; height:100%;"/></div>
					<div class="d_block w_b_f_1">
						<div class="top clearfix">
							<span class="name"><?php echo $this->_var['load']['user_name']; ?> </span>
							<span class="time"><?php 
$k = array (
  'name' => 'to_date',
  'v' => $this->_var['load']['create_time'],
  'f' => 'Y-m-d',
);
echo $k['name']($k['v'],$k['f']);
?></span>
						</div>
						<p class="middle"><?php echo $this->_var['load']['content']; ?></p>
					</div>
	          	</li>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			  </ul>
			 <?php else: ?>
			 <div class="list-block row no-gutter">
			 	<div class="item-box text-center">
					暂无留言
				</div>
			 </div>
			 <?php endif; ?>
        </div>
		<div class="pro_detail_foot leave_word btn_leave_word but_box ">
			<div class="bg_ea544a but_this">留言</div>
		</div>
		<div class="Leave_Word">
			<div class="Leave_Word_block">	
				 <input type="hidden" id="title" value="留言板">
				 <textarea id="content" name="content"></textarea> 
			</div>
			<div class="lish_but clearfix" avatar="">
				 	<div class="abolish  lish">取消</div>
				 	<?php if ($this->_var['data']['act'] == 'transfer_mobile'): ?>
				 	<input type="hidden" id="rel_table" value="transfer">
				 	<input type="hidden" id="rel_id" value="<?php echo $this->_var['data']['transfer_id']; ?>">
				 	<?php else: ?>
				 	<input type="hidden" id="rel_table" value="deal">
				 	<input type="hidden" id="rel_id" value="<?php echo $this->_var['data']['deal']['id']; ?>">
				 	<?php endif; ?>
				 	<input type="hidden" id="deal_id" value="<?php echo $this->_var['data']['deal']['id']; ?>">
					<div id="add_msg" class="publish  lish ">发表</div>
			</div>
		</div>
	</div><!--tab4-->
</div>


