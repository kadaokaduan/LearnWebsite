// JavaScript Document<script type="text/javascript">
	var show_button = document.getElementById('show');
	var show_button_copy = show_button.outerHTML;
	var change = document.getElementById('change');
	var hide_button = document.getElementById('hide');
	var hides1 = document.getElementById('hide_tr1');
	var hides2 = document.getElementById('hide_tr2');
	
	function show()
	{
			console.log("success");
			hides1.style.display = "table-row";		
			hides2.style.display = "table-row";	
			change.innerHTML = "公益";
			
	}
	hide_button.onclick = function()
	{
			console.log("success");
			hides1.style.display = "none";		
			hides2.style.display = "none";	
			change.innerHTML = show_button_copy;
	};
	
	//列表标题始终浮于页面顶端
	var pic_index=0;
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
	
	//幻灯片点击按钮事件
	var pic_index=0;
	var button_index;
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
	
      //文档高度
      function getDocumentTop() {
         var scrollTop = 0, bodyScrollTop = 0, documentScrollTop = 0;
         if (document.body) {
            bodyScrollTop = document.body.scrollTop;
         }
         if (document.documentElement) {
            documentScrollTop = document.documentElement.scrollTop;
         }
         scrollTop = (bodyScrollTop - documentScrollTop > 0) ? bodyScrollTop : documentScrollTop;
         return scrollTop;
      }
      //可视窗口高度

      function getWindowHeight() {
         var windowHeight = 0;
         if (document.compatMode == "CSS1Compat") {
            windowHeight = document.documentElement.clientHeight;
         } else {
            windowHeight = document.body.clientHeight;
         }
         return windowHeight;
      }
      //滚动条滚动高度
      function getScrollHeight() {
         var scrollHeight = 0, bodyScrollHeight = 0, documentScrollHeight = 0;
         if (document.body) {
            bodyScrollHeight = document.body.scrollHeight;
         }
         if (document.documentElement) {
            documentScrollHeight = document.documentElement.scrollHeight;
         }
         scrollHeight = (bodyScrollHeight - documentScrollHeight > 0) ? bodyScrollHeight : documentScrollHeight;
         return scrollHeight;
      }
      window.onscroll = function () {
         //监听事件内容
		 console.log(getScrollHeight()+" "+getWindowHeight()+" "+getDocumentTop());
         if (getScrollHeight() == getWindowHeight() + parseInt(getDocumentTop())) {
		// 当页面高度 + 滚动高度 === 文档整体高度时为滚动至底部 执行异步加载方法等等
		console.log("到达底部");
		fresh();
		}
	}
		function fresh()
	  {
		  var xhttp = new XMLHttpRequest();
		  xhttp.onreadystatechange = function() {
		  if(this.readyState == 4 && this.status == 200) {
			  myFunction(this);
			}
		  };
		  xhttp.open("GET", "try/ajax/list.xml", true);
		  xhttp.send();
	  }
		function myFunction(xml){
			var i;
			var xmlDoc = xml.responseXML;
			var x = xmlDoc.getElementsByTagName("news");
			var newsList = document.getElementsByClassName("new_list");
			var tips = document.getElementById("load");
			for(i=0;i<x.length;i++)
			{
				var news = document.createElement('div');
				var hr = document.createElement('hr');

				hr.style = "width:93%;height:1px;border:none;border-top:1px solid #C7C7C7;z-index:20;font-size:0;line-height:0;padding:0px;margin-bottom:20px;"
				news.className = "new_content";
				console.log(x[i].getElementsByTagName("title")[0].childNodes[0].nodeValue);
				news.innerHTML = "<h4>"+x[i].getElementsByTagName("title")[0].childNodes[0].nodeValue+"</h4><h5>"+x[i].getElementsByTagName("comment")[0].childNodes[0].nodeValue+"</h5>"+
            								"<img class = 'content_image' src="+x[i].getElementsByTagName("image")[0].childNodes[0].nodeValue+">";
				newsList[0].appendChild(news);
				newsList[0].appendChild(hr);
			}
		}