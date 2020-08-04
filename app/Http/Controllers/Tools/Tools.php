<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Tools extends Controller
{
	/* Ajusta busca retirando acentos e "ç" da String
	* Alteração: adicionei retorno em array, separando a $str por espaços " "
	* @author Alexandre Liondas
	* @param mixed $str
	* @return array $str
	*/
	public static function ajustarBusca($str) : string
	{
      //Array de acentos
		$map = array(
			'á'=>'a','à'=>'a','ã'=>'a','â'=>'a','é'=>'e','ê'=>'e','í'=>'i','ó'=>'o','ô'=>'o','õ'=>'o','ú'=>'u','ü'=>'u','ç'=>'c',
			'Á'=>'A','À'=>'A','Ã'=>'A','Â'=>'A','É'=>'E','Ê'=>'E','Í'=>'I','Ó'=>'O','Ô'=>'O','Õ'=>'O','Ú'=>'U','Ü'=>'U','Ç'=>'C'
		);
       //Array para REGEXP
		$regpx = array(
			'a' => '(a|á|&aacute;|à|&agrave;|â|&acirc;|ã|&atilde;)', 'A' => '(a|á|&aacute;|à|&agrave;|â|&acirc;|ã|&atilde;)',
			'e' => '(e|é|&eacute;|è|&egrave;|ê|&ecirc;)', 'E' => '(e|é|&eacute;|è|&egrave;|ê|&ecirc;)',
			'i' => '(i|í|&iacute;|ì|&igrave;|î|&icirc;)', 'I' => '(i|í|&iacute;|ì|&igrave;|î|&icirc;)',
			'o' => '(o|ó|&oacute;|ò|&ograve;|ô|&ocirc;|õ|&otilde;)', 'O' => '(o|ó|&oacute;|ò|&ograve;|ô|&ocirc;|õ|&otilde;)',
			'u' => '(u|ú|&uacute;|ù|&ugrave;|û|&ucirc;)', 'U' => '(u|ú|&uacute;|ù|&ugrave;|û|&ucirc;)',
			'ç' => '(c|ç|&#231;)', 'c' => '(c|ç|&#231;)'
		);
		$str1 = strtr(trim($str), $map);
		$str2 = strtr($str1, $regpx);
		$str3 = str_replace(' ', '.+', $str2);
		return $str3;
	}
}
