
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
                $('#select_categoria').append('<input type="text" maxlength="30" name="'+name+'" style="float: left;margin-right: 10px;width:250px;" />');
                $('#select_categoria').append('<a href="javascript:;" title="cadastrar categoria" onclick="insereSelect();" style="margin-top: 10px;display: block;float: left;">Retornar a seleção</a>');    
            });
        
    }
    
    function insereSelect(name){
        
        $('div.select input').fadeOut('fast',function(){
            $('div.select input').remove();
            $('div.select a').remove();
            $('div.select select').show();
            $('#select_categoria').append('<a href="javascript:;" title="cadastrar categoria" onclick="insereInput();">Inserir nova categoria</a>');    
        });
    }
        
