var Common = {} ;

Common.Util = {} ; 

Common.Util.uid = function(){
    var s4 = function(){
        return (((1+Math.random()) * 0x10000) | 0).toString(16).substring(1) ; 
    };

    return (s4()+s4()+'-'+s4()+'-'+s4()+'-'+s4()+'-'+s4()+s4()+s4()) ; 
}; 

Common.Util.printf = function(str,oParam){ 
    $.each(oParam,function(key,val){ 
        str = str.replace('{'+key+'}',val) ;  
    }); 
    return str ; 
};

Common.Util.autolink = function(str){ 
    var protocol_re = '(https?|ftp|news|telnet|irc|mms)://';
    var domain_re   = '(?:[\\w\\-]+\\.)+(?:[a-z]+)';
    var max_255_re  = '(?:1[0-9]{2}|2[0-4][0-9]|25[0-5]|[1-9]?[0-9])';
    var ip_re       = '(?:'+max_255_re+'\\.){3}'+max_255_re;
    var port_re     = '(?::([0-9]+))?';
    var user_re     = '(?:/~[\\w-]+)?';
    var path_re     = '((?:/[\\w!"$-/:-@]+)*)';
    var hash_re     = '(?:#([\\w!-@]+))?';

    var url_regex = new RegExp('('+protocol_re+'('+domain_re+'|'+ip_re+'|localhost'+')'+port_re+user_re+path_re+hash_re+')', 'ig');

    var content = str ; 

    content = content.replace(/</g, '&lt;').replace(/>/g, '&gt;');
    content = content.replace(url_regex, '<a href="$1" target="_blank">$1</a>');

    return content ; 
};

Common.Util.is_email = function(val){
    var isEmail_re       = /^\s*[\w\-\+_]+(\.[\w\-\+_]+)*\@[\w\-\+_]+\.[\w\-\+_]+(\.[\w\-\+_]+)*\s*$/;
    return String(val).search(isEmail_re) != -1;
}; 

Common.Util.is_alpha = function(val){
    var isWhole_re       = /^\s*\d+\s*$/;
    return String(val).search (isWhole_re) != -1
}; 

Common.Util.is_required = function(val){ 
    if(val == ''){
        return false ; 
    }

    return true ; 
}; 

Common.Util.checkValidation = function($obj,filter){
    var value = $obj.val() ; 
    var filters = filter.split('|') ; 
    var length = filters.length ; 

    console.log(value) ; 

    for(var i = 0 ; i < length ; i++){
        var str = filters[i] ; 
        if(str == 'email'){
            if(! Common.Util.is_email(value)){ 
                $obj.parents('.control-group').addClass('error') ; 
                $obj.val('올바른 email이 아닙니다.') ; 

                return false ; 
            }
        }
        
        if(str == 'alpha'){
            if(! Common.Util.is_alpha(value)){ 
                $obj.parents('.control-group').addClass('error') ; 
                $obj.val('올바른 값이 아닙니다.') ; 

                return false ; 
            } 
        }
        
        if(str == 'required'){
            if(! Common.Util.is_required(value)){ 
                $obj.parents('.control-group').addClass('error') ; 
                $obj.val('값을 채워주세요..') ; 

                return false ; 
            }
        }
    }

    return true ; 
}; 
