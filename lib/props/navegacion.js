var site = null;
var backSite = null;

function linkTo(link = null) {

    $('#content').empty();

    if (link != null) { $('#content').load('index.php/' + link); backSite = site; site = link; return; }

    $('#content').load('index.php/' + site);

}

function back() {
   linkTo(backSite);
}

$('.menu-link').click(function () {
    $('#link-page').html(this.dataset.nombre);
    if(this.dataset.link == '') {linkTo('Admin/nopage'); return;}
    linkTo(this.dataset.link);
});

var wait = false;
function wo() {
    wait = true;
    $('#wait').fadeIn('slow');
}

function wc() {
    wait = false;
    $('#wait').fadeOut('slow');
}

var bak_icon = null;
var wait_icon = '<i class="fa fa-spinner fa-spin mr-1"></i>';
function wb(e) 
{
    const ban = $(e).prop('disabled');

    if(ban){
        $(e).find('i').remove();
        $(e).prepend("<i class='"+bak_icon+"'></i>");
    }else{
        bak_icon = $(e).find('i').attr('class');
        $(e).find('i').remove();
        $(e).prepend(wait_icon);
    }
   
    $(e).prop('disabled',!ban);
}

function reload(e, parametro = false) {
    var link = false;

    if($(e).hasClass('reload')){
        link = $(e).attr('data-link');
    }else{
        link = $(e).closest('.reload').attr('data-link');
    }

    if(!link){
        console.log('Falla al recargar el contenido');
        return;
    }
    $(e).html('Cargando...');
    $(e).load(link + (parametro?'/'+parametro:''));
}