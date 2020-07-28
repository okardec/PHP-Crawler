<?php
  
  require_once 'crawler.php';
  
 
	$cw = new Crawler();
	$cw->setURL('https://www.site.com/')	
	
		/*
		->addHeader('cabecalho-1','valor-1')
		->addHeader('cabecalho-2','valor-2')
		*/
    //exemplos de headers:
		->addHeader('User-Agent','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:78.0) Gecko/20100101 Firefox/78.0')
		->addHeader('Accept',' text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8')
		->addHeader('Accept-Language','pt-BR,pt;q=0.8,en-US;q=0.5,en;q=0.3')
		->addHeader('Connection','keep-alive')
		->addHeader('Cache-Control','max-age=0')
		->addHeader('Upgrade-Insecure-Requests','1')
		->addHeader('Keep-Alive','300')
		->addHeader('Accept-Charset','ISO-8859-1,utf-8;q=0.7,*;q=0.7')
		->addHeader('Content-type','text/html; charset=utf-8')
				
		/*
		->addCookie('cookie-1','valor-1')
		->addCookie('cookie-2','valor-2')
		*/

		/*	
		->addPostData('campo-1','valor-1')
		->addPostData('campo-2','valor-2')
		->setPostDataJson(true) ///define se os dados do Post serão enviados como Json ou não		
		*/
		
		->get();
		 
		///para recuperar os dados carregados
		//** cabeçalhos
		print_r($cw->getResultHeader());		
		//** conteudo html 
		print($cw->getResult());
			
    
?>
