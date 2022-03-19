<?php
class FormSanitizer {

	public static function sanitizeFormString($inputText) {
		$inputText = strip_tags($inputText);
    	$inputText = str_replace(" ", "", $inputText);
    	$inputText = strtolower($inputText);
   		$inputText = ucfirst($inputText);
    	return $inputText;
	} // End of public static function sanitizeFormString

		public static function sanitizeFormUsername($inputText) {
		$inputText = strip_tags($inputText);
    	$inputText = str_replace(" ", "", $inputText);
    	return $inputText;
	} // End of public static function sanitizeFormUsername

		public static function sanitizeFormPassword($inputText) {
		$inputText = strip_tags($inputText);
    	return $inputText;
	} // End of public static function sanitizeFormPassword

		public static function sanitizeFormEmail($inputText) {
		$inputText = strip_tags($inputText);
    	$inputText = str_replace(" ", "", $inputText);
    	return $inputText;
	} // End of public static function sanitizeFormEmail






}
?>