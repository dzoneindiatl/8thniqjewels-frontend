$(window).on('click',function(){
    $(".searchBox").slideUp();
});
$(".searchBtn").on("click", function(e){
    e.stopPropagation();
    $(".searchBox").slideToggle();
});
$(".searchButton").on("click", function(){
    //alert("hi");
    $(".searchBox").slideUp();
});
$(".searchBox").on('click',function(e){
    e.stopPropagation();
});
$(".hamburgerClick").on("click", function(){
    $("html").addClass("nav-active");    
    $("#menu-full").css({"opacity" : "1" , "visibility" : "visible"});    
});
$(".menuClose").on("click", function(){
    $("html").removeClass("nav-active");    
    $("#menu-full").css({"opacity" : "0" , "visibility" : "hidden"});    
});

$(".filters li h3").on("click", function(){
    $(this).next().slideToggle();
    $(this).toggleClass("active");
    $(this).parent().siblings().find(".moreFilters").slideUp();
    $(this).parent().siblings().find("h3").removeClass("active");
});

$(document).on("click", "[data-tab]", function () {
    var tab = $(this).data("tab");
    //alert(tab);
    $(tab).fadeToggle().siblings().hide();
    $(this).toggleClass('active');
    $(this).parent().siblings().children().removeClass('active')
});