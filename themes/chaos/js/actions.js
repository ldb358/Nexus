function slider(mask, image_div){
    this.images = [];
    this.interval = null;
    this.count = 0;
    this.cyclerate = 3000;
    this.object_name = null;
    this.rate = 0;
    this.mask = mask;
    this.image_div = image_div;
    this.imagesloaded = 0;
    this.checkLoaded = null;
    this.onLoad;
    this.add_images = function(){
        $(this.image_div).css('width', ((this.images.length+1)*986) +"px");
        for(var i=0;i<this.images.length;i++){
            $(this.image_div).append("<img src='"+this.images[i]+"' alt='slider image "+i+"' />");
        }
        $(this.image_div).append("<img src='"+this.images[0]+"' alt='slider image "+0+"' />");
    }
    this.cycle = function(object_name, interval, rate){
        if(this.interval == null){
            this.interval = setInterval(object_name+'.cycle()', interval);
            this.cyclerate = interval;
            this.rate = rate;
            this.object_name = object_name;
        }else{
            this.next(this.rate);
        }
    }
    this.next = function(rate){
        if(this.count < this.images.length){
            $(this.mask).animate({scrollLeft: '+='+986+'px'}, rate);
            $(".slidebutton:checked").removeAttr('checked','checked');
            this.count++;
            $(".slidebutton").attr('checked','checked');
        }else{
            this.first(0);
            this.next(rate);
        }
    }
    this.prev = function(rate){
        if(this.count > 0){
            $(this.mask).animate({scrollLeft: '-='+986+'px'}, rate);
            this.count--;
        }else{
            this.last(0);
            this.prev();
        }
    }
    this.first = function(rate){
        $(this.mask).animate({scrollLeft: 0+'px'}, rate);
        this.count = 0;
    }
    this.last = function(rate){
        $(this.mask).animate({scrollLeft: (this.images.length)*986+'px'}, rate);
        this.count = this.images.length;
    }
    this.n = function(n, rate){
        clearInterval(this.interval);
        if(n!= this.count){
            if(this.count < this.images.length){
                $(this.mask).animate({scrollLeft: (n)*986+'px'}, rate);
                this.count = n;
            }else{
                this.first(0)
                this.n(n);
            }
            this.interval = setInterval(this.object_name+'.cycle()',this.cyclerate);
        }
    }
    this.addClickListeners = function(slider){
        for(var i=0;i<this.images.length;i++){
            $(".buttonsbar .buttons").append("<input type='radio' id='"+i+"' class='sliderbutton' name='slider' />")
        }
        return $(".sliderbutton").click(function(){ slider.n(this.id); });
    }
    this.loadImagesFromXml = function(file, onFinished){
        var image_srcs = [];
       $.get(file, function(data){
            $(data).find('image').each(function(){
                image_srcs[image_srcs.length] = $(this).text();
            });
            onFinished(image_srcs);
        });
    }
    this.setImages = function(images){
        for(var i=0,len=images.length; i<len; i++){
            images[i] = base+images[i];
        }
        this.images = images;
    }
    this.preload = function(object_name){
        $(".slider").append("<div id='blackdiv'><img id='blackdivimg' src='"+base+"images/loading.gif' alt='loading slider' /></div>");
        for(var i=0;i<this.images.length;i++){
            $("body").append("<img src='"+this.images[i]+"' class='preload preloadslider' id='preload"+i+"' />");
        }
        
        this.checkLoaded = setInterval(object_name+".imagesLoaded()",1000);
        return $(".preloadslider").load(function(){
            $("#"+this.id).remove();
            window[object_name].imagesloaded++;
        });
    }
    this.imagesLoaded = function(){
        if(this.imagesloaded == this.images.length){
            clearInterval(this.checkLoaded);
            $(".preloadslider").remove();
            $("#blackdiv").remove();
            this.onLoad();
        }
    }
}
$(document).ready(function(){
    window.test = new slider("#slidemask", "#sliderimages");
    test.loadImagesFromXml(base+'images.xml',  function(images){
    test.setImages(images);
    test.onLoad = function(){
        test.add_images();
        test.first(0);
        test.addClickListeners(test);
        test.cycle('test', 4000, 2000);
    }
    test.preload('test');    
    });
    
});
