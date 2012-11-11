<?php $this->load->helper('url') ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>::좋은 가게::</title>
    <?echo css_asset('bootstrap.css','bootstrap') ?>
    <?echo css_asset('/smoothness/jquery-ui-1.8.20.custom.css','jquery') ?>
    <?echo js_asset('jquery-1.7.2.min.js','jquery') ?>
    <?echo js_asset('jquery-ui-1.8.20.custom.min.js','jquery') ?>
    <?echo js_asset('bootstrap.min.js','bootstrap') ?>
    <?echo css_asset('admin.css','shopmgr') ?>
    <?echo css_asset('docs.css','shopmgr') ?>
    <?= $header_data ?>
    <script>
    var base_url = "<?=base_url()?>" ; 
    </script>
</head>
<body style="padding-top:20px;">
    <header class="navbar">
        <div class="navbar-inner navbar-fixed-top">
            <div class="container">
                <a class="brand" >좋은 가게</a>
                <ul class="nav"> 
                    <li <?php if($this->uri->segment(2)=='statistics'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>shopmgr/statistics/info">가계 통계</a>
                    </li>
                    <li class="dropdown <?php if($this->uri->segment(2)=='customer'):?> active <?php endif;?>"> 
                        <a href="<?=base_url()?>shopmgr/customer/purchaseHistory" class="dropdown-toggle" data-toggle="dropdown">고객분석 
                            <b class="caret"></b> 
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=base_url()?>shopmgr/customer/purchaseHistory" >구매기록</a> </li> 
                            <li><a href="<?=base_url()?>shopmgr/customer/comment" >고객반응 알림</a> </li> 
                        </ul>
                    </li> 
                    <li class="dropdown <?php if($this->uri->segment(2)=='coupon'):?> active <?php endif;?>" > 
                        <a href="<?=base_url()?>shopmgr/coupon/couponHistory" class="dropdown-toggle"  data-toggle="dropdown">
                            쿠폰관리
                            <b class="caret"></b> 
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=base_url()?>shopmgr/coupon/couponHistory" >적립쿠폰</a> </li> 
                            <li><a href="<?=base_url()?>shopmgr/coupon/eventCouponHistory" >이벤트 알림</a> </li> 
                        </ul>
                    </li> 
                    <li class="dropdown <?php if($this->uri->segment(2)=='shop'):?> active <?php endif;?>"> 
                        <a href="<?=base_url()?>admin/template/showlist" class="dropdown-toggle"  data-toggle="dropdown">가게정보
                        
                            <b class="caret"></b> 
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=base_url()?>shopmgr/shop/shopInfo" >가게정보</a> </li> 
                            <li><a href="<?=base_url()?>shopmgr/shop/shopHistory" >요금 관리</a> </li> 
                        </ul>
                    </li> 
                    <li <?php if($this->uri->segment(2)=='filebox'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>admin/filebox/uploadForm">점주 게시판</a>
                    </li> 
                    <li>
                        <a href="<?=base_url()?>shopmgr/bsmember/logoff"><i
										class="icon-off"></i> Logout</a>
                    </li>
                </ul> 
            </div>
        </div>
    </header> 
    <div class="contents">
        <div class="container">
            <br/>
            <div class="row">
            <?= $contents ?>
            </div>
        </div>
    </div> 
    <?= $footer_data ?>
</body>
</html>
