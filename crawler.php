<?php
/**
 * Classe para tratar as requisições web
 *
 */
class Crawler{

	public function __construct(){
		/**
		 * gosto de setar para liberar mais memoria e tempo para evitar que o script falhe 
		 * caso o servidor de destino esteja lento 
		 */
		ini_set('memory_limit','512M');
		ini_set('max_execution_time', 60);

		return $this;
	}
	
	const URL = '';		 
	/**
	 * URL que será requisitada e carregada
	 *
	 * @param String $i
	 * @return $this
	 */
	public function setURL($i){ 
		$this->URL=$i; 
		return $this;  
	}
	public function getURL(){		 
		if(!isset($this->URL)){
			return '';
		}
		return $this->URL; 
	}
	
	
	const URL_REFERER = '';		
	/**
	 * informa uma URL para usar como Referencia
	 *
	 * @param String $i
	 * @return $this
	 */
	public function setUrlReferer($i){ 
		$this->URL_REFERER=$i; 
		return $this;  
	}  
	public function getUrlReferer(){ 
		if(!isset($this->URL_REFERER)){
			return '';
		}
		return $this->URL_REFERER; 
	}
	
	
	const RESULT = '';		 
	public function setResult($i){ 
		$this->RESULT=$i; 
		return $this;  
	}  
	/**
	 * retorna o conteudo da requisição
	 *
	 * @return string
	 */
	public function getResult(){ 
		//return $this->RESULT; 
		if(!isset($this->RESULT)){
			return '';
		}
		return $this->RESULT; 
	}
	
	const RESULT_HEADER = '';		 
	public function setResultHeader($i){ 
		$this->RESULT_HEADER=$i; 
		return $this;  
	}  
	/**
	 * retorna o cabeçalho recebido na requisição
	 *
	 * @return array
	 */
	public function getResultHeader(){ 		
		if(!isset($this->RESULT_HEADER)){
			return array();
		}
		return $this->RESULT_HEADER; 
	} 
	
	
	const HEADER = array();	
	/**
	 * informa o valor para um item do cabeçalho/Header
	 *
	 * @param String $key
	 * @param $value
	 * @return $this
	 */
	public function addHeader(String $key, $value){
		$i = $this->getHeader();
		if(strlen($key) <= 0 && strlen($key) <= 0 ){
			return this;
		}
		$i[$key] = $value;		
		$this->setHeader($i); 
		
		return $this;
	}

	public function setHeader(Array $i){ 
		$this->HEADER=$i; 
		return $this;
	}
	public function getHeader(){
		if(!isset($this->HEADER)){
			return array();
		}
		return $this->HEADER;
	}
 
	
	
	const COOKIE = array();	
	/**
	 * informa o valor para um item do Cookie
	 *
	 * @param String $key
	 * @param $value
	 * @return $this
	 */
	public function addCookie(String $key, $value){
		$i = $this->getCookie();
		if(strlen($key) <= 0 && strlen($key) <= 0 ){
			return this;
		}
		$i[$key] = $value;
		$this->setCookie($i); 
		
		return $this;
	}

	public function setCookie(Array $i){ 
		$this->COOKIE=$i; 
		return $this;
	}
	public function getCookie(){
		if(!isset($this->COOKIE)){
			return array();
		}
		return $this->COOKIE;
	}
	
	
	const POST_DATA = array();	
	/**
	 * informa o valor para um item para ser enviado via POST
	 *
	 * @param String $key
	 * @param $value
	 * @return $this
	 */
	public function addPostData(String $key, $value){
		$i = $this->getPostData();
		if(strlen($key) <= 0 && strlen($key) <= 0 ){
			return this;
		}
		$i[$key] = $value;
		$this->setPostData($i); 
		
		return $this;
	}

	public function setPostData(Array $i){ 
		$this->POST_DATA=$i; 
		return $this;
	}
	public function getPostData(){
		if(!isset($this->POST_DATA)){
			return array();
		}
		return $this->POST_DATA;
	}
	
	const POST_DATA_JSON = false;	
	/**
	 * informa se os dados passados para o post serão enviados como um JSON
	 *
	 * @param boolean $i
	 * @return $this
	 */
	public function setPostDataJson($i){ 
		$this->POST_DATA_JSON=$i; 
		return $this;  
	}  
	public function isPostDataJson(){ 		
		return $this->POST_DATA_JSON; 
	} 
	
	
	/**
	 * Executa a requisição com os parametros informados
	 *
	 * @return $this
	 */
	public function get(){
		
		
		if (strlen($this->getURL())<=0){
			throw new Exception('Ocorreu um erro ao iniciar. A URL não foi informada!');
		}
		
		///inicia o CURL
		$curlObj = curl_init();
		curl_setopt($curlObj, CURLOPT_RETURNTRANSFER,1);
		
		//seta a URL a ser carregada
		curl_setopt($curlObj, CURLOPT_URL,$this->getURL());
		
		///passa o referer
		if (strlen($this->getUrlReferer())>0){
			curl_setopt($curlObj, CURLOPT_REFERER, $this->getUrlReferer());
			
			$uData = parse_url($this->getUrlReferer());
			$_SERVER['HTTP_HOST'] = $uData['host'];
			$_SERVER['HTTP_REFERER'] = $this->getUrlReferer();
		}
		
		/////define os cabeçalhos da requisição, só insere se forem passados		
		$header = array();
		$h = $this->getHeader();		 
		if (count($h)>0){
			foreach ($h as $k=>$v){
				$header[] = $k.': '.$v;
			}
			
			curl_setopt($curlObj, CURLOPT_HTTPHEADER, $header);
		}
						
		/////define os cookies da requisição, só insere se forem passados		
		$cookies = array();
		$c = $this->getCookie();		 
		if (count($c)>0){
			foreach ($c as $k=>$v){
				$cookies[] = $k.'='.$v;
			}											 
						
			curl_setopt($curlObj, CURLOPT_COOKIE,implode('; ',$cookies));	
		}		
		
		/////define os dados passados via POST caso seja informados	
		$postData = array();
		$p = $this->getPostData();		 
		if (count($p)>0){
			foreach ($p as $k=>$v){				
				if ($this->isPostDataJson()){
					$postData[] = '"'.$k.'":"'.$v.'"';
				}else{ 
					$postData[] = $k.'='.$v;
				} 
			}											 
					
			if ($this->isPostDataJson()){
				$postString = '{'.implode(',',$postData).'}';
			}else{
				$postString = implode('&',$postData);
			}
				 			
			curl_setopt($curlObj, CURLOPT_POST, 1);
			curl_setopt($curlObj, CURLOPT_POSTFIELDS,$postString);

		}
						
		///seta para retornar os cabeçalhos
		curl_setopt($curlObj, CURLOPT_HEADER, 1);
		
		$result=curl_exec ($curlObj);
		curl_close ($curlObj);
		
			
		$hRequest = array();	
		$cRequest = array();
			
		$output = rtrim($result);
		$data = explode("\n",$result);		
		$hRequest['status'] = $data[0];
		array_shift($data);
		
		
		///isola os dados do header e do conteudo
		$isHeader = true;
		foreach($data as $part){
		
			if ($isHeader){
			    //alguns cabeçalhos contem o caractere ":" por exemplo "Location"
			    $middle = explode(":",$part,2);				   
			    if ( !isset($middle[1]) ) { $middle[1] = null; }		
			    
			    //nos testes que fiz, o header tem uma separação em branco do conteudo, aqui divido ambos
			    if (strlen(trim($middle[0])) > 0 && strlen(trim($middle[1])) > 0){
			   		$hRequest[trim($middle[0])] = trim($middle[1]);
			    }else{
			    	$isHeader = false;
			    }
			    
			}else{
				$cRequest[] = $part;
			}
		    
		}
		
		$this->setResultHeader($hRequest);
		$this->setResult(trim(implode("\n",$cRequest)));
 	
		return $this;
	}
	
	
	
	
	
	
	/**
	 * extrai uma String dentro de uma sequencia maior
	 *
	 * @param String $html
	 * @param String $str_init_mark
	 * @param String $init
	 * @param String $end
	 * @return String
	 */
	public static function cutStr($html,$str_init_mark,$init,$end){
		$text = '';
		//se localizar o a marcação do corte
		$b = strpos($html,$str_init_mark);
		if ($b>0){
			//se achar a primeira posição
			if (strpos($html,$init,$b) > 0){
				$b = strpos($html,$init,$b)+ strlen($init);
				$e = strpos($html,$end,$b);
				$text = html_entity_decode(trim(substr($html,$b,$e-$b)));
			}
		}

		return $text;
	}
	 
	
	
	
}
?>
