<?php $this->load->helper('url') ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>좋은가게에 오신 것을 환영합니다.</title>
    <?echo css_asset('bootstrap.css','bootstrap') ?>
    <?echo css_asset('/smoothness/jquery-ui-1.8.20.custom.css','jquery') ?>
    <?echo js_asset('jquery-1.7.2.min.js','jquery') ?>
    <?echo js_asset('jquery-ui-1.8.20.custom.min.js','jquery') ?>
    <?echo js_asset('bootstrap.min.js','bootstrap') ?>
    <?echo css_asset('admin.css','admin') ?>
    <?echo css_asset('docs.css','admin') ?>
    <?echo css_asset('style.css','member') ?>
</head>
<body>
    <div class="content_wrapper">
    <div class="pull-right right_box">
        <div class="login_div inner_box" id="login_box">
            <form method="post" class="form-horizontal" method="post" action="do_join">
                <div class="control-group"> 
                        <input type="text" name="email" class="input-xlarge" placeholder="이메일 주소" /><span> </span>
                </div> 
                <div class="control-group"> 
                        <input type="password" placeholder="비밀번호"  class="input-xlarge" name="password"/>
                </div> 
                <div>
                    <label><input type="checkbox"/>&nbsp;로그인 유지</label>&nbsp;<button type="submit" class="pull-right btn btn-primary"> 로그인 </button>
                </div>
            </form>
        </div>

        <br/>

        <div class="join_div inner_box" id="join_box"> 
            <h6> '좋은가게'에 처음이세요 ? </h6>
            <form class="form-horizontal" method="post" action="do_join" id="join_form"> 
                <div class="control-group"> 
                        <input type="text" name="email" class="input-xlarge" placeholder="이메일 주소" /><span> </span>
                </div> 
                <div class="control-group"> 
                        <input type="password" placeholder="비밀번호"  class="input-xlarge" name="password"/>
                </div> 
                <div class="control-group"> 
                        <input type="password" placeholder="비밀번호 확인" class="input-xlarge"  name="confirm_password" />
                </div> 
                <br/>
                <div class="control-group"> 
                        <input type="password" placeholder="본인 이름(실명)" class="input-xlarge"  />
                </div> 
                <div class="control-group"> 
                        <input type="password" placeholder="휴대폰 번호(숫자만 입력)" class="input-xlarge"  />
                </div>
                <div>
                    <button type="submit" class="btn btn-primary"> 점주 가입하기 </button>
                </div>
            </form>
        </div>

        <div class="shop_info_div inner_box" id="shop_box" style="display:none;"> 
            <h6> 가게정보 </h6>
            <form class="form-horizontal" method="post" action="do_join" id="shop_join_form"> 
                <div class="control-group"> 
                        <input type="text" name="email" class="input-xlarge" placeholder="가게이름 " /><span> </span>
                </div> 
                <div class="control-group"> 
                        <input type="password" placeholder="비밀번호"  class="input-xlarge" name="password"/>
                </div> 
                <div class="control-group"> 
                        <input type="password" placeholder="가게 전화번호(숫자만 입력)" class="input-xlarge"  name="confirm_password" />
                </div> 
                <div class="control-group"> 
                        <input type="password" placeholder="영업시간" class="input-xlarge"  />
                </div> 
                <div class="control-group"> 
                        <input type="password" placeholder="가게 주소" class="input-xlarge"  />
                </div>
                <h6> 기타 </h6>
                <div class="control-group"> 
                        <input type="password" placeholder="'좋은가게'를 알게된 경로" class="input-xlarge"  />
                </div>

                <div>
                    <button type="submit" class="btn btn-primary"> 가입신청하기 </button>
                </div>
            </form>
        </div>
    </div>
    </div>

<script> 
$(function(){
    $('#join_form').submit(function(){ 
        $('#login_box').hide(); 
        $('#join_box').fadeOut(200,function(){
            $('#shop_box').fadeIn(200,function(){ 

            }) ; 
            return false ; 
        });

        return false ; 
    }); 

    $('#shop_join_form').submit(function(){

    }); 

}) ; 
</script>

</body>
</html>
