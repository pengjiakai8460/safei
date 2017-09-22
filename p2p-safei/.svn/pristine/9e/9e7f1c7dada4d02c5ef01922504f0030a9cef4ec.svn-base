<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","uc_setting#index");
	$this->_var['back_page'] = "#uc_setting";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#uc_setting" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<div class="content">
<!-- 这里是页面内容区 -->
<!--身份认证页-->
<div class="detail">
   <div class="mainblok mainborder">
        	<form id="form_credit" enctype="multipart/form-data" action="<?php
echo parse_wap_url_tag("u:index|uc_credit_save|"."".""); 
?>" method="post">
            <div class="detail_list new_version">
            	<div class="blank055"></div>
               <ul>
                 <li>
                    <label><?php if ($this->_var['data']['user_type'] == 1): ?>法人姓名<?php else: ?>真实姓名<?php endif; ?>：</label>
                    <div class="list_con new_version">
                        <input type="text" name="real_name" id="real_name" value="<?php echo $this->_var['data']['user_info']['real_name']; ?>" class="textbox ui_width" placeholder="请输入姓名" autocomplete="off"/>
                    </div>
                 </li>
                <li class="reset_pay_pwd">
                    <label><?php if ($this->_var['data']['user_type'] == 1): ?>法人<?php endif; ?>身份证号：</label>
                    <div class="list_con new_version">
                    <input id="idno" name="idno" class="ui-button_login ui_width" value="<?php echo $this->_var['data']['user_info']['idno']; ?>" style=" height:31px;" type="text" placeholder="请输入身份证号">
                    </div>
                 </li>
				 <li class="limitconditions"> 每张图片最大限制为3MB，图片格式为JPG,GIF,PNG</li>
				 
				 <div class="blank055"></div>
				 <li>
                    <input type="file" name="file[]" value="d17e05a5dbbed7ee823da52eb3736464.png" style=" line-height:0;"/><!--<?php if ($this->_var['data']['file']['one']): ?><img src="<?php echo $this->_var['data']['file']['one']; ?>" style="height:30px;"/><?php endif; ?>-->
                 </li>
				 <div class="blank055"></div>
				 <li>
				 	<input type="file" name="file[]" value="<?php echo $this->_var['data']['credit_info']['file']['1']; ?>" style=" line-height:0;" /><!--<?php if ($this->_var['data']['file']['two']): ?><img src="<?php echo $this->_var['data']['file']['two']; ?>" style="height: 30px;"/><?php endif; ?>-->
                 </li>
				 <div class="blank055"></div>
				</ul>
            </div>
           </form> 
        </div>
		<div class="w_b but_box_parent padding">
					<div class="w_b_f_1 but_box">
						<div id="submitt"  class=" but_this" >提交审核</div>
					</div>
				</div>
   </div>		
</div>


   
<script type="">
	$("#submitt").click(function(){
		$("#form_credit").submit();
	});
</script>

<?php echo $this->fetch('./inc/footer.html'); ?>





