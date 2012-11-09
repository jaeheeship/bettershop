
<div class="span12">
    <ul class="breadcrumb">
        <li><a href="#">Home</a> <span class="divider"> /</span> </li>
        <li><a href="#">쿠폰관리</a> <span class="divider"> /</span> </li>
        <li class="active">적립쿠폰</li>
    </ul>
</div>
<div class="span8">
    <div id="couponHistory" >

    </div>
</div>
<div class="span4">
    <h6>적립 혜택 목록</h6>
    <div>
        <a href="#coupon_modal" class ="btn btn-large btn-block btn-primary" type="button" data-toggle="modal">적립 혜택 추가/삭제</a>
    </div>
    <table class="table table-striped">
        <thead> 
            <tr> 
                <th>혜택 </th>
                <th>소진포인트 </th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($coupon_list as $key => $coupon): ?> 
        <tr> 
            <td><?=$coupon->title;?></td>
            <td style="text-align:right;"><?=$coupon->point;?>&nbsp;P </td>
        </tr> 
        <?php endforeach ; ?>
        </tbody>
    </table> 
</div>

<div class="modal hide fade" id="coupon_modal">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" > &times;</button>
        <h3>발행중인 쿠폰 목록</h3>
    </div>
    <div class="modal-body">
    <table id ="coupon_table" class="table table-striped">
        <thead> 
            <tr> 
                <th>혜택 </th>
                <th>소진포인트 </th>
                <th>추가/삭제 </th>
            </tr>
        </thead>
        <tbody>
        <tr id="first_row"> 
            <td><input type="text" class="input-large" name="title"/> </td>
            <td><input type="text" class="input-small" name="point"/>P </td>
            <td><a class="btn btn-info" id="coupon_add_btn" >추가</a></td>
        </tr>
        <?php foreach($coupon_list as $key => $coupon): ?> 
        <tr id="<?=$coupon->coupon_srl?>"> 
            <td><?=$coupon->title;?></td>
            <td style="text-align:right;"><?=$coupon->point;?>&nbsp;P </td>
            <td><?php if($coupon->valid=='yes'):?><a class="btn delete_btn ">삭제 </a> <?php else:?><a class="btn ">삭제취소 </a><?php endif;?> </td>
        </tr> 
        <?php endforeach ; ?>
        </tbody>
    </table>
    </div>
    <div class="modal-footer"> 
        <a href="#" class="btn btn-primary">변경사항 저장</a>
    </div>
</div>

<?echo js_asset('Common.js') ?>
<?echo js_asset('Common.List.js') ?>
<script> 
$(function(){
    var coupon_delete = function(data){ 
        var obj = { 
            coupon_srl : data.coupon_srl , 
            command : 'delete'
        }; 

        $.getJSON(base_url+'shopmgr/coupon/batchCoupon' ,{data :obj},function(data){

        }); 
    }

    $('.delete_btn').click(function(){
        $tr = $(this).parents('tr') ; 
        $tr.attr('id') ; 
        
    }) ; 

    $('#coupon_add_btn').click(function(){
        var title = $('#first_row [name=title]').val() ; 
        var point = $('#first_row [name=point]').val() ; 
        
        var obj = {
            title : title, 
            point : point , 
            command : 'insert' 
        }; 

        
        $.getJSON(base_url+'shopmgr/coupon/batchCoupon' ,{data :obj},function(data){
            var tmpl = '<tr id="{coupon_srl}"><td>{title}</td><td style="text-align:right;">{point}P</td><td><a class="btn delete_btn">삭제</a> </td> </tr>' ; 
            var tr = Common.Util.printf(tmpl,data) ; 
            $(tr).appendTo($('#coupon_table tbody')).find('.delete_btn').click(function(){ 
                alert("t") ; 
                coupon_delete(data) ; 
            }); 
        }) ; 
    }); 

    var coupon_panel = Common.ListPanel({ 
        url : base_url+'shopmgr/coupon/getUsedCouponHistory' , 
        target_id : 'couponHistory' ,
        pagination : {
            list_count : 20, 
            page_count : 10, 
            endless : true, 
        }, 
        panel_body : { 
            height : 300 
        },

        tmpl : '<table class="table table-striped"">'+
                    '<thead>'+ 
                        '<tr>'+
                            '<th>날짜</th>'+
                            '<th>손님</th>'+
                            '<th>혜택</th>'+
                            '<th>소진포인트</th>'+ 
                        '</tr>'+
                    '</thead>'+
                    '<tbody id="_items_area">'+ 
                    '</tbody>'+
                '</table>', 
        item_config : {
            tmpl : '<tr><td>{write_time}</td><td>{type}</td><td>{shop_code}</td><td>{info}</td>  </tr>',
            display_fields : [{
                name : 'write_time'
            },{
                name : 'type'
            },{
                name : 'shop_code'
            },{
                name : 'info'
            }] 
        }
    }) ; 

    //coupon_panel.load() ; 
    coupon_panel.render() ; 
}); 
</script>
