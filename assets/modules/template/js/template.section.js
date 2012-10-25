var TMPL=TMPL||{} ; 

TMPL.Section = function(oConfig){
    var section_type = oConfig['section_type']||CONSTANT.get('DEFAULT.SECTION_TYPE'), 
        _self ,
        cls = oConfig['cls']||'' ,
        css = oConfig['css']||'' ,
        rows = 1 , 
        cols = 1 ,
        target = oConfig['target']||CONSTANT.get('DEFAULT.SECTION_TARGET'),
        height = oConfig['height'] ,
        box_config = null; 

    var remoconHandler = function(remocon){
        remocon.find('.correct_btn').bind('click',function(){ 
            TMPL.SectionModal.load(that) ; 
        }); 

        remocon.find('.remove_btn').bind('click',function(){ 
            that.remove() ; 
        });

        remocon.find('.down_btn').bind('click',function(){
            that.moveDOWN() ; 
        });

        remocon.find('.up_btn').bind('click',function(){
            that.moveUP() ; 
        });
    };

    var setBoxConfig = function(_box_config){
        box_config = {
            box_css : _box_config['box_css'],
            box_cls : _box_config['box_cls'],
            span_size : 12/_box_config['cols'], 
            show_title : _box_config['show_title'] || true ,
            title_css : _box_config['title_css'] || '' ,
            title_cls : _box_config['title_cls'] || '' ,
            show_description : _box_config['show_description'] || true, 
            description_css : _box_config['description_css'] || '', 
            description_cls : _box_config['description_cls'] || '', 
            show_image : _box_config['show_image'] || true, 
            image_height :_box_config['image_height'] ,
            image_width : _box_config['image_width'] ,
            image_css : _box_config['image_css'] ,
            image_cls : _box_config['image_cls'] ,
            target : _self ,
            image_align : _box_config['image_align'] 
        }

        return box_config ; 

    }; 

    var that =  { 
        wipe : function(){
            $(_self).html('') ; 
        },

        getBoxInfo:function(){ 
            return box_config ; 
        },

        getInfo : function(){
            return {
                section_type : section_type , 
                cls : cls , 
                css : css , 
                target : target ,
                height : height ,
                rows : rows ,
                cols : cols ,
                box_config: box_config , 
                _self  : _self ,
            } 
        },

        draw : function(setting){ 
            that.wipe() ; 
            if (section_type == CONSTANT.get('SECTION.TYPE.HTML')){

            }else if(section_type == CONSTANT.get('SECTION.TYPE.WIDGET')){

            }else{ 
                var box_config = setBoxConfig(setting) ; 

                var rows = setting['rows'] ;
                var cols = setting['cols'] ;  

                for(var i = 0 ; i < rows*cols ; i++){
                    var box = TMPL.Box(box_config); 
                    box.render() ; 
                    box.editable() ; 
                } 
            }
        }, 

        getType : function(){ 
            !CONSTANT.get('SECTION.TYPE.'+section_type) ?section_type = CONSTANT.get('SECTION.TYPE.CONTENT_BOX') : '' 
            return CONSTANT.get('SECTION.TYPE.'+section_type) ; 
        }, 

        getDom: function(){

        }, 

        remove : function(){
            var $row_section =  _self.parents('.row_section') ; 
            $row_section.fadeOut('slow',function(){ 
                $row_section.remove() ;     
            }); 
        },
        
        moveUP : function(){
            var $row_section =  _self.parents('.row_section') ; 
            $row_section.slideUp('slow',function(){
                var $prev = $row_section.prev() ; 
                $($prev[0]).before($row_section) ; 
                $row_section.fadeIn('slow') ; 
            });

        },

        moveDOWN : function(){ 
            var $row_section =  _self.parents('.row_section') ; 

            $row_section.slideDown('slow',function(){
                var $next = $row_section.next() ; 
                $($next[0]).after($row_section) ; 
                $row_section.fadeIn('slow') ; 
            }); 
        },

        render : function(){ 
            var $el = $(CONSTANT.get('SECTION.ROW_TEMPLATE')).appendTo($(target)) ; 

            !CONSTANT.get('SECTION.TYPE.'+section_type) ?section_type = CONSTANT.get('SECTION.TYPE.CONTENT_BOX') : ''

            $(CONSTANT.get('SECTION.HELP.'+section_type)).appendTo($el) ; 
            _self = $el.find('.content_body') ; 

            var remocon = $(CONSTANT.get('SECTION.REMOCON')).appendTo($el) ; 

            remoconHandler(remocon) ; 

        }
        
    }; 
    return that ; 
}; 
