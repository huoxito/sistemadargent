<?php 
App::import('Controller', 'Usuarios');

class TestUsuariosController extends UsuariosController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}
class UsuariosControllerTest extends CakeTestCase { 
    
    var $fixtures = array(
        'app.usuario', 'app.conta'
    );
    
    function startTest() {
		$this->Usuarios =& new TestUsuariosController();
		$this->Usuarios->constructClasses();
	}

	function endTest() {
		unset($this->Usuarios);
		ClassRegistry::flush();
	}   

    function testCadastro(){
        
        $data['Usuario'] = array(
            'nome' => 'teste teste tes te',
            'login' => 'teste',
            'email' => 'teste@mail.com',
            'passwd' => 'mbarwerd',
        );

        $result = $this->testAction('/usuarios/cadastro',
                            array(
                                'data' => $data,
                                'method' => 'post',
                            ));
        debug($result);
    }
     
} 
?> 
