<?php

namespace ParserBundle\Parser;

/**
 *
 * @author kiryaserg
 */
interface ParserInterface {
 /**
  * 
  * @param string $file
  */
    public function parse ($file); 
    public function setShopId($id); 
}
