<?php
class Coringa_Minify_ParserJs
{
    public function __construct(){
	
    }
    public function setScripts($array){
	    $this->scripts = $array;
	
    }
    public function init(){
	
	if(is_array($this->scripts )){
	    foreach($this->scripts as $scripts){
		if(is_file($scripts)){
		    $scriptLoaded .= ';';
		    $scriptLoaded .= trim(file_get_contents( $scripts ));
		    
		}else {
		    # Exception handler
		    throw new Exception('Erro lista: Nao foi possivel buscar o arquivo '.$scripts);
		}
	    }
	}else{
	   if(is_file($this->scripts)){
	       $scriptLoaded = trim(file_get_contents( $this->scripts ));
	   }else {
		# Exception handler
		throw new Exception('Erro: Nao foi possivel buscar o arquivo;');
	   }
	}
	 $js = new Coringa_Minify_Js($scriptLoaded);
	 return ';'.$js->pack();
	
    }
}

?>
