/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// 主导航 在页面下滑时永远置顶在浏览器上方
function tscroll() {
    if ($(document).scrollTop() > 40) {
        $(".navbar-main ul li a").css({
            "line-height": "30px"
        })
       
         $(".navbar-main .navbar-header button").css({
            "margin-top": "15px"
        })
         $(".navbar-main .navbar-header a").css({
            "padding": "5px"
        })
        $(".navbar-main .navbar-header a img").css({
            "height": "50px"
        })

    }
    else {
        if($(window).width()>768){
        $(".navbar-main ul li a").css({
            "line-height": "80px"
        })
    
          $(".navbar-main .navbar-header a").css({
            "padding": "15px"
        })
        $(".navbar-main .navbar-header a img").css({
            "height": "auto"
        })
    }
    }
}
$(window).scroll(function () {
    tscroll();
})
window.onload = function(){ 
    tscroll();
}
//手机端导航
$(".navbar-main .navbar-header .collapsed").click(function(){
    setTimeout(function () {
     $(".navbar-main .in .navbar-right").height( $(".navbar-main .in .navbar-right").height())
     
     
     },400)
})
//新闻列表右侧导航 样式
$(".news-right ul li").click(function(){
 		$(".news-right ul li").removeClass("active");
    $(this).addClass("active")
})
//培训资料 
$(".training-main #accordion .panel-default").eq(0).find("span").removeClass();
$(".training-main #accordion .panel-default").eq(0).find("span").addClass("glyphicon glyphicon-menu-up");
$(".training-main #accordion .panel-heading h4 a").click(function(){
    setTimeout(function(){
      var ta = $(".training-main #accordion .panel-collapse")
      
        for(var i = 0;i< ta.length; i++){
    if(ta.eq(i).hasClass("in")){
       ta.eq(i).prev().find("span").removeClass();
       ta.eq(i).prev().find("span").addClass("glyphicon glyphicon-menu-up")
    }
    else{
        ta.eq(i).prev().find("span").removeClass();
       ta.eq(i).prev().find("span").addClass("glyphicon glyphicon-menu-down")
    }
    
    }
    },400); 
    
    
})
//瀑布流
var $container = $('#container'); 
window.onload = function(){
$container.masonry({   
    itemSelector : '.item',   
    columnWidth : '.item'
  });  
}; 
$(window).resize(function(){
  $container.masonry({   
    itemSelector : '.item',   
    columnWidth : '.item'
  }); 
});
 
 //banner相册
   var tlinum= $(".w3cFocusIn .hd ul li")
        $(".w3cFocusIn .hd ul").width(tlinum.length*114)
     //焦点图功能，用到SuperSlide插件
	jQuery(".w3cFocus").slide({ mainCell:".bd ul", effect:"fold", delayTime:300, autoPlay:true ,trigger:"click"});

	

	//拉伸浏览器时触发，为了适应不同浏览设备
	jQuery(window).resize(function(){moveBtn();});
        
        
$(".w3cFocusIn .hd .hd-left").click(function(){
    
    
    var ltmargin=$(".w3cFocusIn .hd ul").css("margin-left");
    var ltmarginnum=ltmargin.replace("[^0-9\u4e00-\u9fa5.]+","");

    if(parseInt(ltmarginnum)>0){
       
    }
    else{
   var ltmarginsum=(parseInt(ltmarginnum)+114)+"px";
        $(".w3cFocusIn .hd ul").css("margin-left",ltmarginsum)
        }
    
})
$(".w3cFocusIn .hd .hd-right").click(function(){
    var tmargin=$(".w3cFocusIn .hd ul").css("margin-left");
    var tmarginnum=tmargin.replace("[^0-9\u4e00-\u9fa5.]+","");
     var nli=$(".w3cFocusIn .hd ul li").length-2;
     var nsum=nli*-114;
    if(parseInt(tmarginnum)<nsum){
       
    }
    else{
        var tmarginsum=(parseInt(tmarginnum)-114)+"px";
        $(".w3cFocusIn .hd ul").css("margin-left",tmarginsum)
    }
    })
        
     $(".w3cFocusIn .bd-click").click(function(){
      var tliindex= $(".w3cFocusIn .hd ul .on").index(); 
            if (tliindex>3) {
            	var nonum=(tliindex-3)*-114;
            	$(".w3cFocusIn .hd ul").css("margin-left",nonum)
            }
        else{
            	$(".w3cFocusIn .hd ul").css("margin-left","0")
            }
   })     

   


