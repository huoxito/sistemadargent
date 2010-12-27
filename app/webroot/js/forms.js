                
    // <![CDATA[
    $(document).ready(function () {
        
        
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
        
    });  
    // ]]>

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

    var options3 = {
                    'maxCharacterSize': 200,
                    'originalStyle': 'originalTextareaInfo',
                    'warningStyle' : 'warningTextareaInfo',
                    'warningNumber': 40,
                    'displayFormat' : '#left / #max'
    };
    
    $('#Observacoes').textareaCount(options3, function(data){
        var result = 'Characters Input: ' + data.input + '<br />';
        result += 'Words Input: ' + data.words + '<br />';
        result += 'Left Characters: ' + data.left + '<br />';
        result += 'Characters Limitation: ' + data.max + '<br />';
        $('#textareaCallBack').html(result);
    });
    
    function insereInput(name){
        
        $('.select_categoria').fadeOut('fast',function(){
                $('#select_categoria a').remove();
                $('#select_categoria').append('<input type="text" maxlength="30" name="'+name+'" />');
                $('#select_categoria').append('<a href="javascript:;" class="btnadd" title="cadastrar categoria" onclick="insereSelect();">RETORNAR A SELEÇÃO</a>');    
            });
        
    }
    
    function insereSelect(name){
        
        $('div.select input').fadeOut('fast',function(){
            $('div.select input').remove();
            $('div.select a').remove();
            $('div.select select').show();
            $('#select_categoria').append('<a href="javascript:;" class="btnadd" title="cadastrar" onclick="insereInput();">INSERIR NOVA CATEGORIA</a>');    
        });
    }
    
    var insereSelectFontes = function(){
        $.ajax({
            url: urlInsereSelect,
            beforeSend: function(){
                $('#inputCategoria img').detach();
                $('#inputCategoria').append(' <img src="../img/ajax-loader-p.gif" />');
            },
            success: function(result){
                $('#inputCategoria').fadeOut('fast',function(){
                    $('#inputCategoria').remove();
                    $('.inputsRight').prepend(result);
                });
            }
        });
        $('#insereSelectFontes').die('click');
        $('#insereInputFontes').live('click', insereInputFontes);
        return false;
    };
    
    var insereInputFontes = function(){
        $.ajax({
            url: urlInsereInput,
            beforeSend: function(){
                $('#selectCategoria img').detach();
                $('#selectCategoria').append(' <img src="../img/ajax-loader-p.gif" />');
            },
            success: function(result){    
                $('#selectCategoria').remove();
                $('.inputsRight').prepend(result);
            }
        });
        $('#insereInputFontes').die('click');
        $('#insereSelectFontes').live('click', insereSelectFontes);
        return false;
    };
    
    $('#insereSelectFontes').live('click', insereSelectFontes);
    $('#insereInputFontes').live('click', insereInputFontes);
    
    function insereInputDestinos(){
        
        $('div.select select').fadeOut('fast',function(){
                $('div.select a').remove();
                $('div.select').append('<input type="text" maxlength="30" name="data[Destino][nome]" />');
                $('div.select').append('<a href="javascript:;" title="cadastrar" class="btnadd" onclick="insereSelectDestinos();">SELECIONAR UM DESTINO</a>');    
            });
        
    }
    
    function insereSelectDestinos(){
        
        $('div.select input').fadeOut('fast',function(){
            $('div.select input').remove();
            $('div.select a').remove();
            $('div.select select').show();
            $('div.select').append('<a href="javascript:;" title="inserir" class="btnadd" onclick="insereInputDestinos();">CADASTRAR NOVO DESTINO</a>');    
        });
    }
        
