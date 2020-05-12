<?php
define('FB','https://m.facebook.com');
define('FORM','~<form method="post" (.*?)</form>~s');
define('ACTION','~action=(?:["\'])?([^"\'\s]*)~i');
define('INPUT','~<input(.*?)>~');
define('NAME','~name=(?:["\'])?([^"\'\s]*)~i');
define('VALUE','~value=(?:["\'])?([^"\'\s]*)~i');

class FBform extends HttpCurl	{
private $_url;
private $_inputs = array();

public function __construct() 	{}	 	
public function __destruct()	{}
	
public function fbLogin($username, $password) {
	unset ($this->_inputs);
	unset ($this->_url);	
	$this->getFormFields();
	$this->_inputs['email']=$username;
	$this->_inputs['pass']=$password;
//	$this->_url = FB . $this->_url;	
	$post_field = $this->arrayImplode( '=', '&', $this->_inputs);
	$this->post($this->_url,  $post_field);	
}

public function fbLogout() {
	$dom = new DOMDocument;
    @$dom->loadxml(parent::getBOdy());
    $links = $dom->getElementsByTagName('a');
    foreach ($links as $link) {
        if (strpos($link->getAttribute('href'), 'logout.php')) {
            $logout = $link->getAttribute('href');
            break;
        }
    }
	if($saida=parent::get(FB.$logout)){
		return $saida;
	}else{
		return false;
	}
}

	
public function fbStatusUpdate($status) {
	unset ($this->_inputs);
	unset ($this->_url);	
	$this->getFormFields();
	$this->_inputs['status']=$status;
	$this->_url = FB . $this->_url;
	$post_field = $this->arrayImplode( '=', '&', $this->_inputs);
	$this->post($this->_url,  $post_field);	
}

public function fbSendMsg($msg) {
	unset ($this->_inputs);
	unset ($this->_url);	
	$this->getMsgFields();
	$this->_inputs['body']=$msg;
	$this->_url = FB . $this->_url;
	$post_field = $this->arrayImplode( '=', '&', $this->_inputs);
	//echo $this->_url.'<br>'.$post_field;
	$this->post($this->_url,  $post_field);	
}
	
public function arrayImplode( $glue, $separator, $array ) {
	$string = array();
	foreach ( $array as $key => $val ) {
		if ( is_array( $val ) )
		$val = implode( ',', $val );
		$string[] = "{$key}{$glue}{$val}";
	}
	return implode( $separator, $string );
}
public function getFormFields() {
		$dom = new DOMDocument;
		@$dom->loadHTML(parent::getBody());
		$form=  $dom->getElementsByTagName('form')->item(0);
		$this->_url= $form->getAttribute('action');
		$inputs = $form->getElementsByTagName('input');
		foreach($inputs as $input){
			$this->_inputs[$input->getAttribute('name')] = $input->getAttribute('value')?$input->getAttribute('value'):NULL;
		}
	}
public function getMsgFields() {
		$dom = new DOMDocument;
		@$dom->loadHTML(parent::getBody());
		$this->_url= $dom->getElementById('composer_form')->getAttribute('action');
		$inputs = $dom->getElementById('composer_form')->getElementsByTagName('input');
		foreach($inputs as $input){
			$this->_inputs[$input->getAttribute('name')] = $input->getAttribute('value');
		}

	}
	
}

?>