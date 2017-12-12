// JavaScript Documentvar pic_index=0;
	var button_index;
	var divH = $('.news_title').offset().top;
	$(window).scroll(function(){
		var scroH = $(this).scrollTop();
		if(scroH>=divH){
			$('.news_title').css({'position':'fixed','top':0,'background-color':'white','box-shadow':'1px 1px 20px #888888'});
		}
		else{
			$('.news_title').css({'position':'static','background-color':'white'});
		}
	});
	$("._button").eq(0).css('background-color','red');
	$("._button").click(function()
	{
		button_index = $(this).index();
		$("#slider ul li").eq(button_index).fadeIn("slow").siblings("li").hide();
		$("._button").eq(button_index).css('background-color','red');
		$("._button").eq(pic_index).css('background-color','#706F6F');
		$(".image_description ul li").eq(button_index).fadeIn("slow").siblings("li").hide();
	
		pic_index = button_index;
	});
	
	//函数控制如果为大于4返回第一个
	function slide_pic()
	{
		if(pic_index<4){pic_index = pic_index + 1}
		else{pic_index=0;}
	}
	//函数申明主体，以及图片切换函数
	slide_pic.prototype = {
		pic_num : '5',
		pic_slide : function() {
			$("#slider ul li").eq(pic_index).fadeIn("slow").siblings("li").hide();
			$("._button").eq(pic_index).css('background-color','red');
			$("._button").eq(pic_index-1).css('background-color','#706F6F');
			$(".image_description ul li").eq(pic_index).fadeIn("slow").siblings("li").hide();
		}
	};
	//实例化函数。以及调用函数
	function slide()
	{
		var obj = new slide_pic();
		obj.pic_slide(pic_index)                                                                                                                                                  ;
	}
	//函数计时器
	var slide_index = setInterval(slide,3000);
	$(".refresh").on("click",function()
	{
		var xmlhttp;
		if(window.XMLHttpRequest)
		{
			xmlhttp=new XMLHttpRequest();
		}
		else
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState==4&&xmlhttp.status==200)
			{
				$(".new_content").html("<h4>"+xmlhttp.responseText+"<br>规则</h4><h5>2010评论</h5><img class = 'content_image' src='images/x1.jpg'>");
	 		}
		};
		xmlhttp.open("GET","try/ajax/ajax_info.txt",true);
		xmlhttp.send();
	});