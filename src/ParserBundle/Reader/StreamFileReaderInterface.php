<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ParserBundle\Reader;

/**
 *
 * @author kiryaserg
 */
interface StreamFileReaderInterface {
    function open($file);
    function close();
    function registerCallback($node, $callback);
    function parse();
    
    
}
