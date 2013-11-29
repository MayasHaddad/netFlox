<?php
class mainAutoloader{
	public static function init(){
		$classes = array();
		array_walk($classes, 'bisAutoLoader::performRequire');

	public static function performRequire($className){
	if(file_exists($className . '.php')){
		require_once($className . '.php');
		return;
	}
mainAutoloader::init();