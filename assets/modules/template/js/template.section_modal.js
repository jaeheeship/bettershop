var TMPL=TMPL||{} ; 

TMPL.SectionModal = (function(_modal_id){

    var modal_id  = _modal_id  ;
    var section ; 

    $(function(){
        $('#column_changer').bind('change',function(){
            var $form = $('#'+modal_id+' form') ;
            var $this = $(this) ; 
            var columns = $this.val() ; 
            var span_size = parseInt(12/columns,10) ;
            var image_width = 80*span_size-20 ; 
            var image_height = 0 ; 
            if(image_width < 400){
                image_height = parseInt((image_width/3)*2,10); 
            }else if(image_width < 600){ 
                image_height = 300 ; 
            }else { 
                image_height = 350 ; 
            }

            $form.find('[name=image_width]').val(image_width) ; 
            $form.find('[name=image_height]').val(image_height) ; 
        }); 

        $('#'+modal_id+' #section_save_btn').click(function(){
            var id = '#'+modal_id ; 
            var info = section.getInfo() ; 
            var $input_list = $(id).find('form :input') ; 
            var fields = {} ; 
            $input_list.each(function(i,o){
                fields[$(o).attr('name') ] = $(o).val() ; 
            }); 

            var show_title = $(id).find('form input[name=show_title]:checked') ; 
            var show_image = $(id).find('form input[name=show_image]:checked') ; 
            var show_description = $(id).find('form input[name=show_description]:checked') ; 


            var image_align = $(id).find('form input[name=image_align]:checked').val() ; 

            fields['image_align']=image_align||'justify' ; 
            /*fields['show_title']=show_title||'false'; 
            fields['show_description']=show_description||'false'; 
            fields['show_image']=show_image||'false'; */


            that.drawSection(fields) ; 
            that.hide() ; 
        }); 
    }); 

    var that = {
        load : function(section){ 
            that.setSection(section) ; 
            that.setDefaultField() ;

            var id = '#'+modal_id ; 
            var info = section.getBoxInfo() ; 


            if(info){ 
                $input_list = $(id).find('form :input') ; 

                $input_list.each(function(i,o){
                    var $o = $(o) ; 
                    $o.val(info[$o.attr('name')]||'') ; 
                }); 
            }

            $('#'+modal_id).modal('show') ; 
        },
        setDefaultField : function(){
            var id = '#'+modal_id ; 
            var $form = $(id).find('form') ; 

            $form.find('[name=show_image]').attr('checked','checked') ; 
            $form.find('[name=image_height]').val(100) ; 
            $form.find('[name=image_width]').val(100) ; 

            $form.find('[name=show_title]').attr('checked','checked') ; 
            $form.find('[name=tilte_length]').val(100) ; 
            $form.find('[name=tilte_cls]').val('') ; 
            $form.find('[name=tilte_css]').val('') ; 

            $form.find('[name=show_description]').attr('checked','checked') ; 
            $form.find('[name=description_length]').val(100) ; 
            $form.find('[name=description_cls]').val('') ; 
            $form.find('[name=description_css]').val('') ; 


        },
        setSection : function(_section){ 
            section = _section ; 
        },

        drawSection : function(fields){ 
            section.draw(fields) ; 
        },

        show: function(form_fields){

        },
        hide: function(){
            $('#'+modal_id).modal('hide') ; 

        },
        reset : function(){

        }
    }; 

    return that ; 
})('section_modal');
