$( function() {
    //TELA DE LOGIN
    var lembrar_email = localStorage.getItem('lembrar_email');
    var lembrar_password = localStorage.getItem('lembrar_password');

    $("#email").val(lembrar_email);
    $("#password").val(lembrar_password);

    if(lembrar_email){
        $('#remember').prop('checked', true);
    }

    $( "#remember" ).click(function() {
        var lembrar_email = $("#email").val();
        var lembrar_password = $("#password").val();

        if ($('#remember').prop('checked') == true) {
            window.localStorage.setItem('lembrar_email', lembrar_email);
            window.localStorage.setItem('lembrar_password', lembrar_password);
        }
        else{
            window.localStorage.removeItem('lembrar_email');
            window.localStorage.removeItem('lembrar_password');
        }
    });

    //ADICIONAR EVENTO
    $( "#salvar_evento" ).click(function() {
        if ($('#descricao').val() == '') {
            alert('Informa a descrição do evento.');
        }
        else if($('#data').val() == ''){
            alert('Informa a data do evento.');
        }
        else{
            $('#form_adicionar_evento').submit();
        }
    });

    //EDITAR EVENTO
    $( "#editar_evento" ).click(function() {
        if ($('#descricao').val() == '') {
            alert('Informa a descrição do evento.');
        }
        else if($('#data').val() == ''){
            alert('Informa a data do evento.');
        }
        else{
            $('#form_editar_evento').submit();
        }
    });


    //CANCELAR EVENTO
    $( ".cancelar_evento" ).click(function() {
        var descricao = $(this).attr('descricao');
        var id_evento = $(this).attr('id_evento');
        if(confirm('Deseja realmente cancelar o evento "'+descricao+'" ?')){
            window.location.href = "eventos/cancelar/"+id_evento
        }
    });

    //ATIVAR EVENTO
    $( ".ativar_evento" ).click(function() {
        var descricao = $(this).attr('descricao');
        var id_evento = $(this).attr('id_evento');
        if(confirm('Deseja realmente ativar o evento "'+descricao+'" ?')){
            window.location.href = "eventos/ativar/"+id_evento
        }
    });

    //CONVIDAR EVENTO
    $( ".convidar_evento" ).click(function() {
        var status_evento = $(this).attr('status_evento');
        var id_evento = $(this).attr('id_evento');
        if (status_evento == 'inativo') {
            alert('Atenção, não é possível convidar pessoas para eventos inativos.');
        }
        else{
            window.location.href = "eventos/pessoa/convidar/"+id_evento
        }
    });

    $( "#salvar_convite" ).click(function() {
        if(confirm('Deseja realmente convidar?')){
            $('#form_convidar_evento').submit();
        }
    });

    $( ".confirmar_evento" ).click(function() {
        var id_evento = $(this).attr('id_evento');
        if(confirm('Deseja realmente confirmar sua participação no evento?')){
            window.location.href = "eventos/pessoa/confirmar/"+id_evento
        }
    });

    $( ".recusar_evento" ).click(function() {
        var id_evento = $(this).attr('id_evento');
        if(confirm('Deseja realmente recusar sua participação no evento?')){
            window.location.href = "eventos/pessoa/recusar/"+id_evento
        }
    });
} );