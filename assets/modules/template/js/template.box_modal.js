var TMPL=TMPL||{} ; 

TMPL.BoxModal = (function(_modal_id){

    var modal_id  = _modal_id  ;
    var box ; 

    $(function(){ 

        $('#'+modal_id+' #box_save_btn').click(function(){
            var id = '#'+modal_id ; 
            //var info = box.getInfo() ; 
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

            that.saveBox(fields) ; 
            that.hide() ; 
        }); 
    }); 

    var that = {
        load : function(box){ 
            that.setBox(box) ; 

            /*
            that.setDefaultField() ;

            var id = '#'+modal_id ; 
            var info = box.getBoxInfo() ; 


            if(info){ 
                $input_list = $(id).find('form :input') ; 

                $input_list.each(function(i,o){
                    var $o = $(o) ; 
                    $o.val(info[$o.attr('name')]||'') ; 
                }); 
            }*/

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
        setBox : function(_box){ 
            box = _box ; 
        },

        saveBox : function(fields){ 
            //fields['box_css'] = 'background:#000;padding:15px;border:1px solid #ccc;'; 
            //fields['image_height'] = '200'; 
            //fields['image_width'] = '200'; 
            box.setInfo(fields) ; 
            box.render() ; 
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
})('box_modal');
