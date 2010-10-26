<?php
class Frequencia extends AppModel {
	var $name = 'Frequencia';
	var $displayField = 'nome';
	var $validate = array(
		'nome' => array(
			'notempty' => array('rule' => array('notempty')),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed
}
?>