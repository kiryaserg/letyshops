<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ParserBundle\Reader;

/**
 * Description of XmlFileReader
 *
 * @author kiryaserg
 */
class XmlFileReader implements StreamFileReaderInterface  {
    private $simpleXmlReader;

    public function __construct() {
        $this->simpleXmlReader = new SimpleXMLReaderFork();
    }

    function open($file){
         $this->simpleXmlReader->open($file);
    }
    
    function close(){
        $this->simpleXmlReader->close();
    }
    
    /**
     * Register callback will be called when node is found
     * @param string $node
     * @param callback $callback 
     * $callback should return false if 
     * should stop parsing document and true in other case  
     */
    function registerCallback($node, $callback){
        $this->simpleXmlReader->registerCallback($node, $callback);
    }
    
    function parse(){
         $this->simpleXmlReader->parse();
    }
    
}
