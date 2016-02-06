<?php
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class GetChangeTime extends AbstractHelper {
	public function __invoke( $file ) {
		// Test various paths
		$routes = array( 'public/', $_SERVER['DOCUMENT_ROOT'] . '/public/' );
		foreach( $routes as $route ) {
			$test = $route . $file;
			if( file_exists( $test ) ) {
				return filemtime( $test );
			}
		}
		return -1;
	}
}
