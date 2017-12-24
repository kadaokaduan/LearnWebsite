// JavaScript Document
'use strict';
$(function(){
//获取手指在轮播图元素上的一个滑动方向
//获取界面上轮播图容器
var $carousels=$('.carousel');
var startX,endX;
//在滑动的一定范围内，才切换图片
var offset=50;
//注册滑动事件
$carousels.on('touchstart',function(e){
//手指触摸开始时记录一下手指所在的坐标x
startX=e.originalEvent.touches[0].clientX;

});
$carousels.on('touchmove',function(e){
//目的是，记录手指离开屏幕一瞬间的位置，用move事件重复赋值
endX=e.originalEvent.touches[0].clientX;
});
$carousels.on('touchend',function(e){
var distance=Math.abs(startX-endX);
if(distance>offset){
$(this).carousel(startX>endX?'next':'prev');
}
})
});
