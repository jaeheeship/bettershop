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
    <?echo js_asset('Common.js') ?>
    <?echo css_asset('admin.css','admin') ?>
    <?echo css_asset('docs.css','admin') ?>
    <?echo css_asset('style.css','member') ?>
</head>
<body>
    <div class="content_wrapper">
    <div class="pull-right right_box">
        <div class="login_div inner_box" id="login_box">
            <form method="post" class="form-horizontal" method="post" action="<?=base_url()?>shopmgr/bsmember/do_login">
                <div class="control-group"> 
                        <input type="text" name="login_id" class="input-xlarge" placeholder="이메일 주소" /><span> </span>
                </div> 
                <div class="control-group"> 
                        <input type="password" placeholder="비밀번호"  class="input-xlarge" name="password"/>
                </div> 
                <div>
                    <!--<label><input type="checkbox"/>&nbsp;로그인 유지</label>-->&nbsp;<button type="submit" class="pull-right btn btn-primary"> 로그인 </button>
                </div>
            </form>
        </div>

        <br/>

        <div class="join_div inner_box" id="join_box"> 
            <h6> '좋은가게'에 처음이세요 ? </h6>
            <form class="form-horizontal" method="post" action="join" id="join_form"> 
                <div class="control-group"> 
                        <input type="text" name="email" class="input-xlarge" placeholder="이메일 주소" filter="required|email" /><span></span>
                </div> 
                <div class="control-group"> 
                        <input type="password" placeholder="비밀번호"  class="input-xlarge" name="password"/>
                </div> 
                <div class="control-group"> 
                        <input type="password" placeholder="비밀번호 확인" class="input-xlarge"  name="confirm_password" />
                </div> 
                <br/>
                <div class="control-group"> 
                        <input type="text" placeholder="본인 이름(실명)" name="username" class="input-xlarge" filter="required"  />
                </div> 
                <div class="control-group"> 
                        <input type="text" placeholder="xxx" name="phone1" class="input-small" filter="required|number" />
                        <input type="text" placeholder="1234" name="phone2" class="input-small"filter="required|number"  />
                        <input type="text" placeholder="1234" name="phone3"  class="input-small"filter="required|number"  />
                </div> 
                <div>
                    <button type="submit" class="btn btn-primary"> 회원가입... </button>
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
                        <textarea></textarea>
                </div>
                <div class="control-group"> 
                        <input type="text" placeholder="가게 전화번호(숫자만 입력)" class="input-xlarge"  name="confirm_password" />
                </div> 
                <div class="control-group"> 
                        <input type="text" placeholder="영업시간" class="input-xlarge"  />
                </div> 
                <div class="control-group "> 
                    <div class="">
                    <label class="radio inline">카페<input type="radio" name="shop_type" value="카페" /></label>
                    <label class="radio inline">미용<input type="radio" name="shop_type" value="미용" /></label>
                    <label class="radio inline">음식<input type="radio" name="shop_type" value="음식" /></label>
                    <label class="radio inline">술집<input type="radio" name="shop_type" value="술집"/></label>
                    <label class="radio inline">기타<input type="radio" name="shop_type" value="기타"/></label>
                    </div>
                </div> 
                <div class="control-group"> 
                        <input type="text" placeholder="가게 주소" class="input-xlarge"  />
                </div>
                <h6> 기타 </h6>
                <div class="control-group"> 
                        <input type="text" placeholder="'좋은가게'를 알게된 경로" class="input-xlarge"  />
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
    $('#join_form input').on('focus',function(){ 
        $('#login_box').fadeOut(100); 
    }); 

    $('#join_form').submit(function(){ 
        var validation_check=true ; 
        $('#join_form input').each(function(i,obj){ 
            $obj = $(obj) ; 
            var filter = $obj.attr('filter') ; 

            filter = filter||'' ; 

            if(!Common.Util.checkValidation($obj,filter)){ 
                validation_check = false ; 
            } 
        }); 

        if(!validation_check){
            return false ; 
        } 

        return true ; 
    }); 

    $('#shop_join_form').submit(function(){

    }); 

}) ; 
</script>

</body>
</html>
