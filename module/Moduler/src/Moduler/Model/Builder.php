<?php
namespace Moduler\Model;

use PhpParser\Model\PhpParser;
use Parser\Model\Raw;
use Parser\Model\Vector;
use Parser\Model\Path;

class Builder {
	protected $moduler;
	protected $templatesDir;
	protected $log;

	public function __construct( $moduler, $templatesDir ) {
		$this->moduler = $moduler;
		$this->templatesDir = $templatesDir;
		$this->log = array();
	}
	public function buildModule() {
		$files = $this->readTemplate( $this->getTemplateDir() );
		$replaceContent = array();
		$replaceContent[] = $this->getName();
		$lowerName = $this->getName( true );
		$replaceContent[] = $lowerName;
		$replaceContent[] = $this->moduler->table;
		$replaceContent[] = $this->moduler->unit;
		$this->createStructure( $this->moduler->getModuleDir() . DIRECTORY_SEPARATOR, $files, array( $this->getTemplateDir() => '', 'template' => $this->getName( true ), 'Template' => $this->getName() ), $replaceContent );
		return $this->log;
	}
	public function activate() {
		$file = $this->moduler->getApplicationConfig();
		if( $file !== null ) {
			$config = file_get_contents( $file );
			$vector = new Vector( 0, mb_strlen( $config ) );
			$root = new Raw( $config, $vector, 'root' );
			$parser = new PhpParser();
			$parser->parse( $root );
			$path = new Path( $root );
			$result = $path->query( '//modules' );
			$result->push( 'Core' );

			echo "<pre>";
			echo $result->getNodeCode();
			echo str_replace( '<', '&lt;', $root->printTree() );
			echo "\n\n";
			echo str_replace( '<', '&lt;', $root->toString() );
			echo "\n\n";
			die();
			/*echo "<pre>";
			$root->printClean();
			die();*/
		}
	}
	protected function readTemplate( $dir = "template/Module/" ) {
		$files = array();
		if( $handle = opendir( $dir ) ) {
			while( ( $entry = readdir( $handle ) ) !== false ) {
				if( !preg_match( '/^\.{1,2}$/', $entry ) ) {
					$file = $dir . DIRECTORY_SEPARATOR . $entry;
					$obj = new \stdClass();
					$obj->name = $file;
					if( is_file( $file ) ) {
						$obj->is_file = 1;
						$files[] = $obj;
					} else if( is_dir( $file ) ) {
						$obj->is_file = 0;
						$obj->files = $this->readTemplate( $file );
						$files[] = $obj;
					}
				}
			}
		}
		return $files;
	}
	// Directory structure function
	protected function createStructure( $dest, $files, $rewritePath, $replaceContent ) {
		if( !file_exists( $dest ) ) {
			$this->log[] = "<b>Making folder $dest</b>\n\n";
			mkdir( $dest );
		}
		foreach( $files as $file ) {
			$destName = $file->name;
			foreach( $rewritePath as $replace => $with ) {
				$destName = str_replace( $replace, $with, $destName );
			}
			$moduleObj = $dest . $destName;
			if( $file->is_file ) {
				$this->log[] = "copy( " . $file->name . ", " . $moduleObj . ");\n";
				copy( $file->name, $moduleObj );
				$templateFile = $this->read( $moduleObj );
				$replace = '"' . implode( '", "', $replaceContent ) . '"';
				$moduleFile = '';
				eval( "\$moduleFile = sprintf( \$templateFile, " . $replace . " );" );
				$this->write( $moduleObj, $moduleFile );
			} else {
				if( !file_exists( $moduleObj ) ) {
					$this->log[] = "\n<b>Making folder $moduleObj</b>\n";
					mkdir( $moduleObj );
				}
				$this->createStructure( $dest, $file->files, $rewritePath, $replaceContent );
			}
		}
	}
	// File helper functions
	protected function read( $file ) {
		$handle = fopen( $file, "r" );
		$data = fread( $handle, filesize( $file ) );
		fclose( $handle );
		return $data;
	}
	protected function write( $file, $data ) {
		$handle = fopen( $file, "w" );
		fwrite( $handle, $data );
		fclose( $handle );
	}
	protected function getName( $lowerCase = false ) {
		return $lowerCase ? strtolower( $this->moduler->name ) : $this->moduler->name;
	}
	protected function getTemplateDir() {
		return implode( DIRECTORY_SEPARATOR, array( $this->templatesDir, $this->moduler->template, 'Module' ) );
	}
}
