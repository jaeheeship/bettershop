<?php if(!defined("__ZBXE__")) exit();?>
<?php  if($__Context->pagination_name == 'list'){
        $__Context->first_pagination = getUrl('page','','document_srl','','division',$__Context->division,'last_division',$__Context->last_division,'entry','');
        $__Context->last_pagination = getUrl('page',$__Context->pagination_navigation->last_page,'document_srl','','division',$__Context->division,'last_division',$__Context->last_division,'entry','');
        $__Context->current_page = $__Context->page;
    }elseif($__Context->pagination_name == 'history'){
        $__Context->first_pagination = getUrl('hpage','','document_srl',$__Context->oDocument->document_srl,'division',$__Context->division,'last_division',$__Context->last_division,'entry','').'#history';
        $__Context->last_pagination = getUrl('hpage',$__Context->pagination_navigation->last_page,'document_srl',$__Context->oDocument->document_srl,'division',$__Context->division,'last_division',$__Context->last_division,'entry','').'#history';
        $__Context->current_page = $__Context->hpage;
    }elseif($__Context->pagination_name == 'comment'){
        $__Context->first_pagination = getUrl('cpage',1).$__Context->c_url_tail;
        $__Context->last_pagination = getUrl('cpage',$__Context->pagination_navigation->last_page).$__Context->c_url_tail;
        $__Context->current_page = $__Context->cpage;
    }{ ?>

    <div class="exPagNav a1">
        <a href="<?php @print($__Context->first_pagination);?>" class="prevEnd"><?php @print($__Context->lang->first_page);?></a>
        <?php  while($__Context->pagination_no = $__Context->pagination_navigation->getNextPage()){ ?>
            <?php  if($__Context->current_page == $__Context->pagination_no){ ?>
                <strong><?php @print($__Context->pagination_no);?></strong>
            <?php  }else{ ?>
                <?php  if($__Context->pagination_name == 'list')
                        $__Context->pagination_url = getUrl('page',$__Context->pagination_no,'document_srl','','division',$__Context->division,'last_division',$__Context->last_division,'entry','');
                    elseif($__Context->pagination_name == 'history')
                        $__Context->pagination_url = getUrl('hpage',$__Context->pagination_no,'document_srl',$__Context->oDocument->document_srl,'division',$__Context->division,'last_division',$__Context->last_division,'entry','').'#history';
                    elseif($__Context->pagination_name == 'comment')
                        $__Context->pagination_url = getUrl('cpage',$__Context->pagination_no).$__Context->c_url_tail;{ ?>
                    <a href="<?php @print($__Context->pagination_url);?>"><?php @print($__Context->pagination_no);?></a>
                <?php  } ?>
            <?php  } ?>
        <?php  } ?>
        <a href="<?php @print($__Context->last_pagination);?>" class="nextEnd"><?php @print($__Context->lang->last_page);?></a>
    </div>
<?php  } ?>

