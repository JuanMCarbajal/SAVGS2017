<?php

abstract class View
{
	public $headTitle;
	public $headerTitle;
	public function render() 
	{
		include '../html/' . get_class($this) . '.php';
	}

	public function renderHead($title) 
	{
		$this->headTitle = $title;
		include '../html/HeadSection.php';
	}
	
	public function renderHeader($title) 
	{
		$this->headerTitle = $title;
		include '../html/HeaderSection.php';
	}
	
	public function renderFooter() 
	{
		include '../html/FooterSection.php';
	}
}