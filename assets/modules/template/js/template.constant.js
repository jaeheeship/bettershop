var TMPL=TMPL||{} ; 

var CONSTANT =  (function(){
    var constants = {} ,
        ownProp = Object.prototype.hasOwnProperty,
        allowed = {
            string:1,
            number:1,
            object:1,
            boolean:1
        }, 
        prefix = (Math.random() +'_').slice(2) ; 

    return { 
        set:function(name,value){
            if(this.isDefined(name)){
                return false ; 
            }

            if(!ownProp.call(allowed,typeof value)){ 
                return false ; 
            } 

            constants[prefix+name] = value ; 

            return true ; 
        },

        get:function(name){ 
            if(this.isDefined(name)){ 
                return constants[prefix+name] ; 
            }

            return null ; 
        },

        isDefined:function(name){
            return ownProp.call(constants,prefix+name) ; 
        } 
    };

})(); 

CONSTANT.set('CONTENT_BOX.DESCRIPTION',
    '<p class="{description_cls}" style="{description_css}"><a href="{link}" >{description}</a></p>') ; 

CONSTANT.set('CONTENT_BOX.TITLE',
    '<h6 class="{title_cls}" style="{title_css}"><a href="{link}" >{title}</a></h6>') ; 

CONSTANT.set('CONTENT_BOX.IMAGE',
    '<div class="image image_{image_align} {image_cls}" style="{image_css}"><a href="{link}" ><img src="http://placehold.it/{image_width}x{image_height}"/></a></div>') ; 

CONSTANT.set('SECTION.ROW_TEMPLATE',
    '<section class="row row_section clearfix {section_cls}" style="{section_css}"></section>') ; 

CONSTANT.set('SECTION.REMOCON',
    '<div class="section_remocon"><a class="btn up_btn btn-mini"><i class="icon-arrow-up"></i></a>&nbsp;<a class="btn btn-mini down_btn"><i class="icon-arrow-down"></i></a>&nbsp;<a class="btn btn-danger btn-mini remove_btn"><i class="icon-remove icon-white"></i></a>&nbsp;<a class="btn btn-mini btn-primary correct_btn"><i class="icon-edit icon-white"></i></a></div>') ; 

CONSTANT.set('SECTION.HELP.CONTENT_BOX',
    '<div class="content_body" ><div class="well" ><div class="page-header"><h1>Content Box<small>&nbsp;&nbsp;나만의 컨텐츠를 위한 글상자를 만들어 보세요. </small></h1></div><p> 다양한 컨텐츠를 담는 글상자의 레이아웃을 디자인해보세요.</p></div></div>') ; 

CONSTANT.set('SECTION.HELP.HTML',
    '<div class="content_body clearfix"><div class="well" ><div class="page-header"><h1>HTML<small>&nbsp;&nbsp;HTML로 나만의 페이지를 만들어보세요.</small></h1></div><p> 다른 사이트의 위젯을 가져오거나, 또는 나만의 HTML로 페이지를 꾸며보세요. 남들과 다른 개성넘치는 페이지가 될거라 확신해요.</p></div></div>') ; 

CONSTANT.set('SECTION.HELP.WIDGET',
    '<div class="content_body"><div class="well" ><div class="page-header"><h1>WIDGET<small>&nbsp;&nbsp;위젯으로 화려한 페이지를 만들어보세요.</small></h1></div><p>화려한 포토갤러리, 멋진 이미지 슬라이드를 원하세요? 그러면 당장 위젯을 추가하세요.</p></div></div>') ; 

CONSTANT.set('DEFAULT.SECTION_TYPE','CONTENT_BOX'); 
CONSTANT.set('DEFAULT.SECTION_TARGET','#template_body'); 
CONSTANT.set('SECTION.TYPE.CONTENT_BOX','CONTENT_BOX'); 
CONSTANT.set('SECTION.TYPE.WIDGET','WIDGET'); 
CONSTANT.set('SECTION.TYPE.HTML','HTML'); 
CONSTANT.set('SAMPLE.DATA', {
    'sample0':{
        title : '박수근 화백의 숨결이 살아 숨쉬다.',
        description : '강원도 양구에서 만난 박수근 미술관. 그곳에서 만난 공간은 평화롭고 고요하다. ' , 
        link : 'http://www.naver.com' 
    },
    'sample1':{
        title : '예술이 살아 숨쉬는 제주',
        description : '뜨거운 햇살을 피하기 위해 잠시 들른 이곳은 제주도. 이미 관광명소로 소문난 제주도지만 여전히 알려지지 않은 곳이 많다.' , 
        link : 'http://www.naver.com' 
    },
    
    'sample2':{
        title : '2012 광주 비엔날레 개막',
        description : '세계적인 비엔날레 거듭 성장한 광주 비엔날레. 아트 광주에서 만나보는 예술은 어떤 멋이 숨어있을가?' , 
        link : 'http://www.naver.com' 
    }, 

    'sample3':{
        title : '광주에서 만난 색다른 예술시장.',
        description : '대인시장은 2008년부터 시작된 공공예술 프로젝트의 일환으로, 재래시장과 예술을 접목시킨 공간이다. ' , 
        link : 'http://www.naver.com'
    }, 

    'sample4':{
        title : '둥섭 르네상스 시대로 가다.',
        description : '서울 부암동에 새로운 명소가 떴다. 서울을 대표하고자 하는 소망을 담은 서울미술관. ' , 
        link : 'http://www.naver.com'
    }
}); 
