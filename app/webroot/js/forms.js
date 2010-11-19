                
    // <![CDATA[
    $(document).ready(function () {
        $('.dataField').datepicker({
                    dateFormat: 'dd-mm-yy',
                    dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    maxDate: 'd-m-y'
                });
        
        $('.dateFieldAhead').datepicker({
                    dateFormat: 'dd-mm-yy',
                    dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'],
                    monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    minDate: 'd-m-y'
                });
    });  
    // ]]>
    
    function disableOrNotInputs(value){
        if(value == 0){
            $('#AgendamentoFrequenciaId').attr('disabled','disabled');
            $('#AgendamentoNumdeparcelas').attr('disabled','disabled');
            
        }else{
            $('#AgendamentoFrequenciaId').attr('disabled','');
            $('#AgendamentoNumdeparcelas').attr('disabled','');
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
    
    function insereInputFontes(name){
        
        $('div.select select').fadeOut('fast',function(){
                $('div.select a').remove();
                $('div.select').append('<input type="text" maxlength="30" name="data[Fonte][nome]" />');
                $('div.select').append('<a href="javascript:;" title="cadastrar fonte" class="btnadd" onclick="insereSelectFontes();">SELECIONAR UMA FONTE</a>');    
        });
    }
    
    function insereSelectFontes(){
        
        $('div.select input').fadeOut('fast',function(){
            $('div.select input').remove();
            $('div.select a').remove();
            $('div.select select').show();
            $('div.select').append('<a href="javascript:;" class="btnadd" title="inserir fonte" onclick="insereInputFontes();">INSERIR NOVA FONTE</a>');    
        });
    }
    
    
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
        
