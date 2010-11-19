
    <div class="agendamentos box" id="colorboxContent">
        
        <?= $this->Form->create('Agendamento',array('default' => false));?>
        <div id="datepicker">
            
            
        </div>
        <? $this->Form->input('datadevencimento',
                        array('label' => 'Confirme a data do vencimento',
                              'type' => 'text',
                              'error' => false,
                              'class' => 'dataField',
                              'default' => $vencimento,
                              'div' => array('style' => 'float: left; clear: none;')));  
        ?>

    </div>
    
    <?php   echo $this->Html->script('forms');  ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#datepicker').datepicker({
                        <? list($dia,$mes,$ano) = explode('-',$vencimento); ?>
                        defaultDate: new Date(<?=$ano?>,<?=$mes-1?>,<?=$dia?>),
                        maxDate: 'dd-mm-yy'
                    });
        });  
    </script>