<?php if ($_REQUEST['is_ajax'] != 1): ?>
<?php echo $this->fetch('./inc/header.html'); ?>	
<div class="page" id='<?php echo $this->_var['data']['act']; ?>'>
<?php
	$this->_var['back_url'] = wap_url("index","init#index");
	$this->_var['back_page'] = "#init";
	$this->_var['back_epage'] = $_REQUEST['epage']=="" ? "#init" : "#".$_REQUEST['epage'];
?>
<?php echo $this->fetch('./inc/title.html'); ?>
<!-- 这里是页面头部选项卡 -->
<style type="text/css">
	
	.tabs{width: 100%;height: 2.5em;line-height: 2.5em;clear: both;font-size: 1.1em;font-weight: bold;}
	.tabs div{width: 20%;margin-left: 10%;text-align: center;float: left;display: block;}
	.tab-active{color: #094DA0;border-bottom: 3px solid #094DA0;}
	.content-body{clear: both;width: 100%;}
	
	.hides{display: none;}
</style>
<div class="content infinite-scroll pull-to-refresh-content article_list_content"  data-distance="<?php echo $this->_var['data']['rs_count']; ?>"  all_page="<?php echo $this->_var['data']['page']['page_total']; ?>" ajaxurl="<?php
echo parse_wap_url_tag("u:index|article_list#index|"."".""); 
?>">
<!-- 这里是页面内容区 -->
<!--文章列表-->
<div class="content-inner">
	<div class="list-block">

	   
<?php endif; ?>
<script type="text/javascript">
	$(function(){
		$(".tabs div").each(function(){
			$(this).click(function(){
				$(this).addClass("tab-active").siblings("div").removeClass("tab-active");
				var index = $(".tabs > div").index($(this));
				$(".content-body > div").eq(index).removeClass("hides").siblings().addClass("hides");
			})
		})
	})
</script>
<!-- 默认的下拉刷新层 -->
    <div class="pull-to-refresh-layer" all_page="<?php echo $this->_var['data']['page']['page_total']; ?>" >

        <div class="preloader"></div>
        <div class="pull-to-refresh-arrow"></div>
    </div>
    <div class="tabs">
    	<div class="tab-active">平台公告</div>
    	<div>平台动态</div>
    	<div>媒体报道</div>
    </div>
    <div class="content-body">
    	<div>
    		<ul>
    			<?php $_from = $this->_var['data']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
				<li style="clear: both;">
	            	<a href="#" onclick="RouterURL('<?php
echo parse_wap_url_tag("u:index|show_article|"."id=".$this->_var['item']['id']."".""); 
?>','#show_article',2);" class="item-link item-content" >

		              	<div class="item-inner w_b">
		              		<span style="color: #C9C9C9;font-size: 0.6em;">2017-09-19</span>
		                	<div class="item-title w_b_f_1" style="float: left;"><?php echo $this->_var['item']['title']; ?></div>

		              	</div>

	            	</a>

	         	</li>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>	
    		</ul>
    	</div>
    	<div class="hides">2222</div>
    	<div class="hides">3333</div>
    </div>
					 
<?php if ($_REQUEST['is_ajax'] != 1): ?>
		
	</div>
</div>
<?php echo $this->fetch('./inc/footer.html'); ?>
<?php endif; ?>




