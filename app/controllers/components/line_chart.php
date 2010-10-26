<?php

class LineChartComponent extends Object{
	
    var $components = array('Chart'); // the other component your component uses
    /*
	function initialize(&$controller) {
		$this->Chart->setProperty('cht', 'lc');
		$this->Chart->setDimensions($width = 200, $height = 200);		
	}
    */
    
	public function getUrl() {
		$retStr = parent::getUrl();
		return $retStr;	
	}
}

?>