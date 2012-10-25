<?php $this->load->helper('url') ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>이야기가 함께하는 아트그라피</title>
    <?echo css_asset('bootstrap.css','bootstrap') ?>
    <?echo css_asset('/smoothness/jquery-ui-1.8.20.custom.css','jquery') ?>
    <?echo js_asset('jquery-1.7.2.min.js','jquery') ?>
    <?echo js_asset('jquery-ui-1.8.20.custom.min.js','jquery') ?>
    <?echo js_asset('bootstrap.min.js','bootstrap') ?>
    <?echo css_asset('admin.css','shopmgr') ?>
    <?echo css_asset('docs.css','shopmgr') ?>
    <?= $header_data ?>
</head>
<body style="padding-top:20px;">
    <header class="navbar">
        <div class="navbar-inner navbar-fixed-top">
            <div>
                <ul class="nav"> 
                    <li <?php if($this->uri->segment(2)=='dashboard'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>admin/dashboard">Dashboard</a>
                    </li>
                    <li <?php if($this->uri->segment(2)=='member'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>admin/member/memberlist">Member</a>
                    </li> 
                    <li <?php if($this->uri->segment(2)=='rss'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>admin/rss/feedlist">RSS</a>
                    </li> 
                    <li <?php if($this->uri->segment(2)=='template'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>admin/template/showlist">TEMPLATE</a>
                    </li> 
                    <li <?php if($this->uri->segment(2)=='filebox'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>admin/filebox/uploadForm">FILEBOX</a>
                    </li>

                    <li <?php if($this->uri->segment(2)=='exhibition'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>admin/exhibition/exhbList">EXHIBITION</a>
                    </li> 
                    <li <?php if($this->uri->segment(2)=='control_panel'):?> class="active" <?php endif;?>> 
                        <a href="<?=base_url()?>admin/control_panel/schemaList">CONTROL PANEL</a>
                    </li>
                </ul> 
            </div>
        </div>
    </header> 
    <div class="contents">
    <?= $contents ?>
    </div> 
    <?= $footer_data ?>
</body>
</html>
