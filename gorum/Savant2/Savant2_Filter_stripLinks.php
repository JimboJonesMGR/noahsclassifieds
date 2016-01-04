<?php

/**
* Base filter class.
*/
require_once 'Filter.php';

/**
* 
* Convert links to normal texts with removing <a ....> and </a> tags
* 
**/

class Savant2_Filter_stripLinks extends Savant2_Filter {

	/**
	* 
	* Convert links to normal texts with removing <a ....> and </a> tags
	* 
	* @access public
	* 
	* @param string &$text The source text to be filtered.
	*
	* @return void
	* 
	*/
	
	function filter(&$text)
	{
		$text = preg_replace("{(<a [^>]*>)|(</a>)}", "", $text);
	}
}