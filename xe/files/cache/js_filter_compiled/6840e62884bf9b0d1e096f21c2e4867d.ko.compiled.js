function install_ftp_info(form){ return legacy_filter('install_ftp_info', form, 'install', 'procInstallAdminSaveFTPInfo', completeMessage, ['error','message'], '', {}) };
(function($){
	var v=xe.getApp('validator')[0];if(!v)return false;
	v.cast("ADD_FILTER", ["install_ftp_info", {'ftp_user': {required:true},'ftp_port': {required:true},'ftp_root_path': {required:true},'sftp': {}}]);
	
	v.cast('ADD_MESSAGE',['ftp_user','ftp_user']);
	v.cast('ADD_MESSAGE',['ftp_port','FTP port']);
	v.cast('ADD_MESSAGE',['ftp_root_path','ftp_root_path']);
	v.cast('ADD_MESSAGE',['sftp','SFTP 사용']);
	v.cast('ADD_MESSAGE',['isnull','%s을 입력해주세요.']);
	v.cast('ADD_MESSAGE',['outofrange','%s의 글자 수를 맞추어 주세요.']);
	v.cast('ADD_MESSAGE',['equalto','%s이 잘못되었습니다.']);
	v.cast('ADD_MESSAGE',['invalid_email','%s의 형식이 잘못되었습니다. (예: xe@xpressengine.com)']);
	v.cast('ADD_MESSAGE',['invalid_userid','%s의 형식이 잘못되었습니다.\n영문, 숫자와 _로 만드실 수 있으며, 첫 글자는 영문이어야 합니다.']);
	v.cast('ADD_MESSAGE',['invalid_user_id','%s의 형식이 잘못되었습니다.\n영문, 숫자와 _로 만드실 수 있으며, 첫 글자는 영문이어야 합니다.']);
	v.cast('ADD_MESSAGE',['invalid_homepage','%s의 형식이 잘못되었습니다. (예: http://www.xpressengine.com)']);
	v.cast('ADD_MESSAGE',['invalid_korean','%s의 형식이 잘못되었습니다. 한글로만 입력하셔야 합니다.']);
	v.cast('ADD_MESSAGE',['invalid_korean_number','%s의 형식이 잘못되었습니다. 한글과 숫자로만 입력하셔야 합니다.']);
	v.cast('ADD_MESSAGE',['invalid_alpha','%s의 형식이 잘못되었습니다. 영문으로만 입력하셔야 합니다.']);
	v.cast('ADD_MESSAGE',['invalid_alpha_number','%s의 형식이 잘못되었습니다. 영문과 숫자로만 입력하셔야 합니다.']);
	v.cast('ADD_MESSAGE',['invalid_number','%s의 형식이 잘못되었습니다. 숫자로만 입력하셔야 합니다.']);
})(jQuery);