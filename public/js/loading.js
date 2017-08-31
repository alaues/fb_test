function loading_show(){
    $("body").append("<div id='loading_wrap' style='position: fixed; z-index:1000; background: rgba(225, 225, 225, .8); height:100%; width:100%; overflow:hidden; top:0; left:0;'><div style='position: absolute; top: 50%; left: 50%; margin-top: -16px; margin-left: -16px; width: 32px; height: 32px;'><img src='/img/loading.gif'></div></div>");
}
function loading_hide(){
    $("#loading_wrap").remove();
}