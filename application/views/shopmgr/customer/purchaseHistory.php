<div class="span12">
    <ul class="breadcrumb">
        <li><a href="#">Home</a> <span class="divider"> /</span> </li>
        <li>고객분석<span class="divider"> /</span> </li>
        <li class="active">구매기록</li>
    </ul>
</div>

<div class="span8">
    <div id="purchaseHistory" >

    </div>   
</div>

<div class="span4">
    <h6><i class="icon icon-thumbs-up"></i>&nbsp;구매우수고객(최근 100일 기준)</h6>
    <table class="table">
        <thead> 
            <tr> 
                <th>순위 </th>
                <th>손님 </th>
                <th>총구매액 </th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<?echo js_asset('Common.js') ?>
<?echo js_asset('Common.List.js') ?>
<script> 
$(function(){ 
    var purchase_panel = Common.ListPanel({ 
        url : base_url+'shopmgr/customer/getPurchaseHistory' , 
        target_id : 'purchaseHistory' ,
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
                            '<th>구매액</th>'+
                            '<th>총구매액</th>'+ 
                        '</tr>'+
                    '</thead>'+
                    '<tbody id="_items_area">'+ 
                    '</tbody>'+
                '</table>', 
        item_config : {
            tmpl : '<tr><td>{time}</td><td>{user_name}</td><td>{point}</td><td>{total_point}</td>  </tr>',
            display_fields : [{
                name : 'time'
            },{
                name : 'user_name'
            },{
                name : 'point'
            },{
                name : 'total_point'
            }] 
        }
    }) ; 

    purchase_panel.render() ; 
}); 
</script>
