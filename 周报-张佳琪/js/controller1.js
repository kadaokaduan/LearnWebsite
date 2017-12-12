// JavaScript Document
var app = angular.module('myApp', []);
var flag = false;//flase表示原大小，true表示已经放大
app.controller('nc', function($scope) {	
	$scope.share_view = true;
	$scope.share=function()
	{
		$scope.share_view = !$scope.share_view;
		  //禁止滚动条
		 if(!$scope.share_view){
			 $(document.body).css({
				"overflow-x":"hidden",
				"overflow-y":"hidden"
			 });
		 }
		 else{
			   $(document.body).css({
				  "overflow-x":"auto",
				  "overflow-y":"auto"
				  });
		 }
	}
	$scope.ctrl1={
		 "font-size" : "18px"
				 }
	$scope.ctrl2={
		 "font-size" : "18px"
	}
    $scope.ctrl4={
		 "font-size" : "18px"
	}
	$scope.ctrl3=true;
	$scope.ctrl5=false;
	$scope.continute_read=function(){
	$scope.ctrl3=!$scope.ctrl3;
	$scope.ctrl5=!$scope.ctrl5;
	}
	$scope.size = "T大";
	$scope.change_size=function(){
		if(!flag)
		{
			$scope.ctrl1={
				 "font-size" : "20px"
			}
			$scope.ctrl2={
				 "font-size" : "20px"
			}
			$scope.ctrl4={
		 		 "font-size" : "20px"
			}
			flag = !flag; 
			$scope.size = "T小"
		}else{
			$scope.ctrl1={
				 "font-size" : "18px" 
			}
			$scope.ctrl2={
				 "font-size" : "18px"
			}
			$scope.ctrl4={
		 		 "font-size" : "18px"
			}
			flag = !flag;
			$scope.size = "T大"
		}
	}
});