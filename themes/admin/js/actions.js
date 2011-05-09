$(document).ready(function(){
    /* create collapseable "widgets" */
    $('.content').live('click', function(){
        var p = $(this).find('.contents:visible').not(':animated');
        if(p.length == 1){
            p.addClass('contentsclosed', 1000);
            $(this).removeClass('contentcollapse').addClass('contentexpand');
        }else{
            p = $(this).find('.contents:hidden').not(':animated');
            p.removeClass('contentsclosed', 1000);
            $(this).removeClass('contentexpand').addClass('contentcollapse');
       }
    });
    /* add drag and drop functions */
    var header = $('.cheader'); 
    var left, offset;
    header.bind('mousedown', function(event){
        header = $(this); 
        var par = $(header).parent();
        var cssleft = parseInt(par.css('left'));
        $('.cheader').parent().addClass('contenthover');
        if(!(cssleft > 0)){
            var parOffsetLeft = this.offsetLeft,
            parOffsetTop = this.offsetTop;
            var cords = {x: parOffsetLeft,
                         y: parOffsetTop};
        }else{
            var cords = {x: cssleft,
                         y: parseInt(par.css('top'))};
        }
        offset = {x: cords.x-event.pageX,
                  y: cords.y-event.pageY};
        par.css('width',par.width()+"px").css('left', par.offset().left).css('top', par.offset().top).addClass('absolute');
        $('body').bind('mousemove', function(e){
            left = {x :e.pageX+offset.x,
                    y :e.pageY+offset.y}
            par.css('left', left.x+"px").css('top', left.y+"px");
        });
        $('body').bind('mouseup', function(e){
            $('body').unbind('mousemove');
            var len = $('.col').length;
            for(var i=0;i<len;i++){
                var col = $(".col:nth("+i+")");
                if(e.pageX > col.offset().left && e.pageX < col.offset().left+col.width() && e.pageY > col.offset().top && e.pageY < col.offset().top+col.height()){
                    $(header).parent().appendTo('.col:nth('+i+')').removeClass('absolute').css('left', 'auto').css('top','auto').css('width', '96%');
                    break;
                }
            }
            $('.cheader').parent().removeClass('contenthover');
            $('body').unbind('mouseup');
        });
    });
    //$('.content').children().bind('click', function(){ return false });
    $('.contents').find(':not(input[type="submit"])').bind('click', function(){ return false });
    $('input[type="submit"]').unbind('click').click(function(){
        $(this).parent().parent().submit();
    });
    /* create the hide unhide edit form */
    $('.editpage-button a').bind('click', function(){
        var editpage = $(this).parent().parent().find('.editpage-form');
        if(editpage.hasClass('hide')){
            editpage.removeClass('hide', 1000).fadeIn(1000);
        }else{
            editpage.addClass('hide', 0)
        }
        return false;
    });
});