$(document).ready(function(){
    $(".gh-middle-right img").hover(function(){
        $(this).stop().animate({"opacity": '1'}, "fast");
        }, function(){
         $(this).stop().animate({"opacity": '.7'}, "fast");
    });
});

$(document).ready(function(){
    $(".gh-middle-left a").hover(function(){
        $(this).stop().animate({"color": '#63d2e5'}, "fast");
        }, function(){
         $(this).stop().animate({"color": '#fff'}, "fast");
    });
});
$("a").click(function(){
 $("a").css('background-color','white');
   if($(this).attr('id') == "select1"||$(this).attr('id') == "select2"||$(this).attr('id') == "select3"||$(this).attr('id') == "select4") 
      $(this).css('background-color', 'red');  
});