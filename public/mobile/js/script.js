var menu = true;
function menulist(){
    if(menu){
        menu = false;
        $("#menubtn").css("transform","rotate(90deg)");
        $(".zw_black").show();
        $(".zwh_menulist").css("right","0%");
    }else{
        menu = true;
        $("#menubtn").css("transform","rotate(0deg)");
        $(".zw_black").hide();
        $(".zwh_menulist").css("right","-40%");
    }
}
$(function(){
    $(".zwh_menulist").height($(window).height()-44);
    $(".zw_black").height($(window).height()-44);
    // user
    $(".zwhu_menulist").height($(window).height()-44);
    $(".zwu_black").height($(window).height()-44);
});
//user 菜单
var usermenu = true;
function menulistuser(){
    if(usermenu){
        usermenu = false;
        $(".zwu_black").show();
        $(".zwhu_menulist").css("right","0%");
    }else{
        usermenu = true;
        $(".zwu_black").hide();
        $(".zwhu_menulist").css("right","-40%");
    }
}