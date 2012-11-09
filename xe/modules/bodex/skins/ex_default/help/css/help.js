/**
* Copyright 2010 phiDel (FOXB.KR)
**/

function autoShowScrollbars(){
    var scollbarFrame = document.getElementById('scollbarFrame');
    var _height = document.documentElement["clientHeight"];
    var _top = scollbarFrame.offsetTop+2;
    scollbarFrame.style.height = (_height-_top)+'px';
    setTimeout(autoShowScrollbars, 500);
}
