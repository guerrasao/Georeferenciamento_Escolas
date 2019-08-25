smoothScroll.init({
    selector: '[data-scroll]',
    selectorHeader: null,
    speed: 2000,
    easing: 'easeInOutCubic',
    offset: 0,
    callback: function ( anchor, toggle ) {}
});

function ajustaTamanhoMenu() {
    tamanhoMenu = $("#menu").height();
    tamanhoMenu += 16;
    $(".controlePadding").css({"padding-top": tamanhoMenu+"px"});
}

function tamanhoTela() {
    return (screen.height >= 768);
}

function ajustaTamanhoAtuacao() {
    if(tamanhoTela()) {
        tamanhoTotal = $("#atuacao-colunas").height();
        $(".atuacao-coluna").height(tamanhoTotal);
    }else{
        $(".atuacao-coluna").height("auto");
    }
}

window.onload=function () {
    ajustaTamanhoMenu();
    ajustaTamanhoAtuacao();
};

$(window).resize(function () {
    ajustaTamanhoMenu();
    ajustaTamanhoAtuacao();
});