var hide_button=document.getElementById('hide');
var obj=document.getElementById("content-img");
hide_button.onclick=function()
{
	console.log("success");
	hides1.style.display="none";
	hides2.style.display="none";
	change.innerHTML=show_button_copy;
};

function MyCtrl($scope,$location){
	$scope.jumpToUrl=function(path){
$location.path(path);
var curUrl=$location.absUrl();
	};
}