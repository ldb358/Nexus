$("body").css('background',"#0a102d url('')");
$("body").append("<img src='images/bg.png' class='preload' />");
$(".preload").load(function(){
    $("body").css('background',"url('images/bg.png') #0a102d");
    $(this).remove();
});