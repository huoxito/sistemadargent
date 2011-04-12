                
// <![CDATA[
$(document).ready(function () {
        
    $('#ContaSaldo').maskMoney({
        allowNegative: true,
        decimal: ',',
        thousands: '.',
        symbol: 'R$ ',
        showSymbol: true,
        symbolStay: true,
        defaultZero: true
    });
    
    $('#valorMask').maskMoney({
        symbol: 'R$ ',
        showSymbol: true,
        symbolStay: true,
        decimal: ',',
        thousands: '.',
        defaultZero: true
    });

    $.ajaxSetup({
        type: "GET",
        contentType: "application/x-www-form-urlencoded; charset=utf-8",
        cache: false
    });
    
    $.datepicker.setDefaults({
        dateFormat: 'dd-mm-yy',
        dayNamesMin: ['Dom', 'Sex', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
        dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
        monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
        dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado']});
    
    $('.dataField').datepicker({
                maxDate: 'd-m-y'
            });
    
    $('.dateFieldAhead').datepicker({
                minDate: 'd-m-y'
            });
        
    

    $('#AgendamentoConfig0').click(function() {           
        if($(this).is(':checked'))  {
            $('#AgendamentoFrequenciaId').attr('disabled','disabled');
            $('#AgendamentoNumdeparcelas').attr('disabled','disabled');
        }else{
            
        } 
    });
    
    $('#AgendamentoConfig1').click(function() {           
        if($(this).is(':checked'))  {
            $('#AgendamentoFrequenciaId').removeAttr('disabled');
            $('#AgendamentoNumdeparcelas').removeAttr('disabled');
        } 
    });
    
    function disableOrNotInputs(value){
        if(value == 0){
            $('#AgendamentoFrequenciaId').attr('disabled','disabled');
            $('#AgendamentoNumdeparcelas').attr('disabled','disabled');
        }
    }
    
    $('#MoveData').datepicker({ maxDate: 'd-m-y' });
    $('#MoveData').datepicker('setDate', new Date()); 
    
    var insereSelectCategorias = function(){
        $.ajax({
            url: '/moves/insereSelect',
            beforeSend: function(){
                $('#inputCategoria img').detach();
                $('#inputCategoria').append(' <img src="/img/ajax-loader-p.gif" />'); }, success: function(result){
                $('#inputCategoria').fadeOut('fast',function(){
                    $('#inputCategoria').remove();
                    $('#categorias_').prepend(result);
                });
            }
        });
        $('#insereSelect').die('click');
        $('#insereInputCategorias').live('click', insereInputCategorias);
        return false;
    };
    
    var insereInputCategorias = function(){
        $.ajax({
            url: '/moves/insereInput',
            beforeSend: function(){
                $('#selectCategoria img').detach();
                $('#selectCategoria').append(' <img src="/img/ajax-loader-p.gif" />');
            },
            success: function(result){    
                $('#selectCategoria').remove();
                $('#categorias_').prepend(result);
            }
        });
        $('#insereInputCategorias').die('click');
        $('#insereSelectCategorias').live('click', insereSelectCategorias);
        return false;
    };
    
    $('#insereSelectCategorias').live('click', insereSelectCategorias);
    $('#insereInputCategorias').live('click', insereInputCategorias);
    
    
});  
    // ]]>
