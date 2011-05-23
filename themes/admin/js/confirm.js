/*
 * args = {
 *      method: 'method name',
 *      action: 'action name',
 *      message: 'the message for the alert',
 *      submit_label: 'the label for the submit button',
 *      cancel_label: 'the label for the cancel button',
 *      id : the id of the page that needs to be deleted
 * }
*/
function confirm_action(args){
    this.method = args.method;
    this.action = args.action;
    this.message = args.message;
    this.submit_label = args.submit_label;
    this.cancel_label = args.cancel_label;
    this.id = args.id;
    this.build = function(){
        var template =
        '<div class="content contentcollapse absolute popup">\
            <h4 class="cheader">'+this.message+'</h4>\
            <div class="contents">\
                <form method="post" action="">\
                    <p class="input submit">\
                        <input type="submit" value="'+this.submit_label+'">\
                        <input type="button" class="cancel_button" value="'+this.cancel_label+'" >\
                    </p>\
                    <input type="hidden" value="'+this.id+'" name="'+this.action+'[id]">\
                    <input type="hidden" value="admin" name="action">\
                    <input type="hidden" value="'+this.action+'" name="method">\
                    <input type="hidden" value="'+this.method+'" name="'+this.action+'[widget]">\
                </form>\
            </div>\
        </div>';
        return template;
    }
    this.add = function(to){
        this.html = this.build();
        $('.popup').remove();
        $(to).filter(':nth(0)').append(this.html);
        $('.popup').hide().fadeIn(500);
        var width = $(to).width();
        $('.popup').css('width', width);
        var left = $('body').width()/2 - $('.popup').width()/2;
        var top = $('body').height()/2 - $('.popup').height()/2;
        $('.popup').css('left', left).css('top', top);
        console.log(left);
        $('.cancel_button').bind('click', this.remove);
    }
    this.remove = function(){
        $(this).parent().parent().parent().parent().remove();
    }
}