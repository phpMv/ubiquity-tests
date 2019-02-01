<?php
namespace controllers;
 use Classes\User;

 /**
 * Controller Main
 **/
class Main extends ControllerBase{

	public function index(){
		$semantic=$this->jquery->semantic();
		$header=$semantic->htmlHeader("header",1);
		$header->asTitle("Welcome to Ubiquity","Version ".\Ubiquity\core\Framework::version);
		$bt=$semantic->htmlButton("btTest","Semantic-UI Button");
		$bt->onClick("$('#test').html('It works with Semantic-UI too !');");
		\Ubiquity\core\postinstall\Display::semanticMenu("menu",$semantic);
		$this->jquery->compile($this->view);
		$this->loadView("@framework/index/semantic.html");
}


	public function testUser(){
		$user=new User();
		$user->setPrenom("Robert");
		$user->setNom("SMITH");
		echo $user;
	}

}
