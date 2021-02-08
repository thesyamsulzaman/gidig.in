<?php

namespace Core;
use Core\Session;
use Core\Helpers;

class FormHelpers {

	public static function inputBlock(
		$type, $label, $name, $value = "", $inputAttributes = [], $divAttributes = []
	) {

		$divString = self::stringifyAttributes($divAttributes);
		$inputString = self::stringifyAttributes($inputAttributes);

		$html = '<div' . $divString . '>';
		$html .= '<label for="' . $name . '">'. $label .'</label>' ;
		$html .= '<input type="'. $type .'" name="'. $name .'" id="'. $name .'" value="'. $value .'" '. $inputString .'/>';
		$html .= '</div>';

		return $html;

	}

	public static function uploadFileBlock($wow, $name) { return 0;}

	public static function submitTag($buttonText, $inputAttributes = []) {
		$inputString = self::stringifyAttributes($inputAttributes);
		$html = '<input type="submit" value="'. $buttonText .'" '. $inputString .' />';

		return $html;
	}

	public static function submitBlock($buttonText, $inputAttributes = [], $divAttributes = []) {
		$divString = self::stringifyAttributes($divAttributes);
		$inputString = self::stringifyAttributes($inputAttributes);

		$html = '<div '. $divString .'>';
		$html .= '<input type="submit" value="'. $buttonText .'"'. $inputString .'/>';
		$html .= '</div>';

		return $html;
	}

	public static function checkBoxBlock($label, $name, $checked = false, $inputAttributes = [], $divAttributes = [] ) {
		$divString = self::stringifyAttributes($divAttributes);
		$inputString = self::stringifyAttributes($inputAttributes);
		$checkString = ($checked) ? ' check="checked" ' : ' ' ;

		$html = '<div ' . $divString . '>';
		$html .= '<label for="'.$name.'"> '. $label .' <input type="checkbox" id="'.$name.'" name="'.$name.'" value="on" '.$checked.' /> </label>';
		$html .= '</div>';

		return $html;

	}


	public static function stringifyAttributes($attributes) {
		$string = "";
		foreach ($attributes as $key => $value) {
			$string .= ' ' . $key . ' = " ' . $value . ' " ';
		}
		return $string;
	}

	public static function generateToken() {
		$token = base64_encode(openssl_random_pseudo_bytes(32));
		Session::set('csrf_token', $token);
		return $token;
	}

	public static function checkToken($token) {
		return (Session::exists('csrf_token') && Session::get('csrf_token') == $token) ;
	}

	public static function csrf_input() {
		return  '<input type="hidden" class="form-control" name="csrf_token" id="csrf_token" value='. self::generateToken() .'>';
	}

  public static function posted_values($post) {
   $clean_array = [];
   foreach ($post as $key => $value) {
    $clean_array[$key] = self::sanitize($value);
   }
   return $clean_array;
  }

  public static function sanitize($dirtyData) {
  	return htmlentities($dirtyData, ENT_QUOTES, 'utf-8');
  }

	public static function parseErrorToFormFields($errors) {
		$scriptInjector = '<script type="text/javascript">';

		foreach ($errors as $field_key => $field_error) {
			$scriptInjector .= 'document.querySelector(".form-control[name='."'".$field_key."'".']").parentElement.setAttribute("data-error", "'.$field_error.'");';
		}
		$scriptInjector .= '</script>';



	return $scriptInjector;
}

	public static function displayErrors($errors) {
	$html = '<div>';
	foreach ($errors as $field => $error) {
	  $html .= '<div class="alert alert-danger" role="alert">';
			$html .=  $error;
		$html .= '</div>';
	}
	$html .= '</div>';
	return $html;
}



}
 ?>
