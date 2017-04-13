$(document).ready(function(){
    $('#create-account')
        .on('click', function(e){
        $('.create-form').show();
        $('.login-form').hide();
    });
    $('#login-account').on('click', function(e){
        $('.login-form').show();
        $('.create-form').hide();
    });
    $('.remove-lnk').on('click', function(e){
        return confirm('Tem certeza que deseja remover este contato?');
    });

    $("#phone-number").mask("(00) 0000-00009");
});

