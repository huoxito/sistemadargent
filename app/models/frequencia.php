<?php
class Frequencia extends AppModel {
	var $name = 'Frequencia';
	var $displayField = 'nome';
    var $cacheQueries = true;
    
	var $validate = array(
		'nome' => array(
			'notempty' => array('rule' => array('notempty')),
		),
	);
}
?>