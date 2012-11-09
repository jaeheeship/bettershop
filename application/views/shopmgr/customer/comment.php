
<div class="span12">
    <ul class="breadcrumb">
        <li><a href="#">Home</a> <span class="divider"> /</span> </li>
        <li>고객분석<span class="divider"> /</span> </li>
        <li class="active">고객반응</li>
    </ul>
</div>

<div class="span8">
    <div id="comment" >

    </div>   
</div>

<div class="span4">
    <h6><i class="icon icon-thumbs-up"></i>&nbsp;입소문 고객(최근 100일 기준)</h6>
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
    var comment_tmpl = $('#comment_tmpl').html() ; 
    var comment_panel = Common.ListPanel({ 
        url : base_url+'shopmgr/customer/getCommentList' , 
        target_id : 'comment' ,
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
                            '<th></th>'+
                            '<th></th>'+
                        '</tr>'+
                    '</thead>'+
                    '<tbody id="_items_area">'+ 
                    '</tbody>'+
                '</table>', 
        item_config : {
            tmpl : comment_tmpl , 
            display_fields : [{
                name : 'content'
            },{
                name : 'username'
            },{
                name : 'thumbnail'
            },{
                name : 'total_point'
            }] 
        }
    }) ; 

    comment_panel.render() ; 
}); 
</script>

<script id="comment_tmpl">
    <tr>
    <td>
    <div style="padding-left:70px;">
        <div style="float:left;margin-left:70px;width:60px;" >
        </div>
        <div style="" >
            <div><strong>{username}</strong></div>
            <p>{content}</p>
            <div class="sub_comment">
                <div class="alert">
                    <form class="form form-inline">
                        <input type="text" /><a class="btn" >댓글달기 </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </td>
    <td>
        <img src="{thumbnail}"/>
    </td>
    </tr>
</script>
