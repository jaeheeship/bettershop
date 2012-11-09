<div class="span12">
    <ul class="breadcrumb">
        <li><a href="#">Home</a> <span class="divider"> /</span> </li>
        <li>가게관리 <span class="divider"> /</span> </li>
        <li class="active">가게정보</li>
    </ul>
</div>
<div class="span8">
    <div>
        <h5>가게정보&nbsp;&nbsp;<span class="badge ">수정 </button></h5>
        <table class="table table-striped"> 
            <tr>
                <th>가게 이름</th><td><?=$shopInfo->getTitle() ?></td>
            </tr>
            <tr>
                <th>가게 소개</th><td><?=$shopInfo->getExtraEidValueHTML('shop_info') ?></td>
            </tr>
            <tr>
                <th>영업 시간</th><td><?=$shopInfo->getExtraEidValueHTML('shop_time') ?></td>
            </tr>
            <tr>
                <th>전화 번호</th><td><?=$shopInfo->getExtraEidValueHTML('shop_tel') ?></td>
            </tr>
            <tr>
                <th>업종</th><td><?=$shopInfo->getExtraEidValueHTML('category') ?></td>
            </tr>
        </table> 
    </div>
</div>
<div class="span4">

</div>
