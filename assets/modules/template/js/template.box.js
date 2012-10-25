TMPL.Box = function(oConfig){

    var box_type = oConfig['box_type']||CONSTANT.get('DEFAULT.BOX_TYPE'),
        _self,
        dom, 
        target= oConfig['target'] , 
        box_config = {  
            box_cls : oConfig['box_cls']||'',
	        box_css : oConfig['box_css']||'',
	        span_size : oConfig['span_size'],
	        show_title : oConfig['show_title']||true,
	        show_description : oConfig['show_description']||true,
	        show_image : oConfig['show_image']||true, 
	        title_cls : oConfig['title_cls']||'', 
	        title_css : oConfig['title_css']||'', 
	        description_cls : oConfig['description_cls']||'', 
	        description_css : oConfig['description_css']||'', 
	        image_cls : oConfig['image_cls']||'',
	        image_css : oConfig['image_css']||'',
	        image_align : oConfig['image_align']||'',
	        image_height : oConfig['image_height']||100,
	        image_width : oConfig['image_width']||100  
        };


    
    //private method 
    var imageON = function(){
            return box_config.show_image == 'true'? true:false ;
        },
        titleON = function(){
            return box_config.show_title == 'true'? true:false ; 
        },
        descriptionON = function(){
            return box_config.show_description == 'true'? true:false ; 
        }

    var that = {} ; 

    that.setInfo = function(box_info){ 
        for(var key in box_info){
            if(box_info.hasOwnProperty(key)){
                box_config[key] = box_info[key] ; 
            } 
        }
    } ;
    that.box_config = function(){
        var obj = {} ; 

        for(var i in box_config){
            obj[i] = box_config[i]; 

        }; 

        return obj ; 
    },
    that.editable = function(){
        $(dom).bind('click',function(){
            TMPL.BoxModal.load(that) ; 
            return false; 
        }); 
    },
    that.render = function(){
        var tpl = '' ; 
        var box_config = that.box_config(); 

        if(imageON()){ 
            tpl = tpl+CONSTANT.get('CONTENT_BOX.IMAGE') ;
            //tpl = $.printf(tpl,{image_width:image_width,image_height:image_height,image_align:image_align}); 
        }

        if(titleON()){
            tpl = tpl+CONSTANT.get('CONTENT_BOX.TITLE') ; 
        }

        if(descriptionON()){
            tpl = tpl+CONSTANT.get('CONTENT_BOX.DESCRIPTION') ; 
        } 
        tpl =  '<div class="span'+box_config.span_size+' box_wrapper"><div class="box clearfix {box_cls}" style="{box_css}">'+tpl+'</div></div>' ; 
        tpl = $.printf(tpl,box_config); 



        tpl = that.sampling(tpl) ; 
        
        if(that.getDom()){
            var dom = $(tpl).insertBefore($(that.getDom())); 
            $(that.getDom()).remove() ; 
        }else{ 
            var dom = $(tpl).appendTo($(target)) ;
        } 

        that.setDom(dom) ; 

        that.editable(); 
    };

    that.setDom = function(_dom){
        dom = _dom ; 
    }; 

    that.getDom = function(selector){
        var d ; 
        if(selector){
            d = $(dom).find(selector) ; 
        }else{ 
            d =  $(dom) ; 
        }

        if(d.length == 0){ 
            return null; 
        }else{ 
            return $(d) ; 
        } 
    };

    that.sampling = function(tpl){ 
        var sample_data = CONSTANT.get('SAMPLE.DATA') ; 
        var index = 'sample'+Math.floor(Math.random()*100+1)%5 ; 
        return $.printf(tpl,sample_data[index]) ; 
    };

    that.dataBinding = function(data){ 
        
    };

    return that ; 
        
}; 
