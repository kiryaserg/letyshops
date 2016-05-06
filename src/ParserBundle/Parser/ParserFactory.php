<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ParserBundle\Parser;

/**
 * Description of ParserFactory
 *
 * @author kiryaserg
 */

class ParserFactory {
    const TYPE_CSV_A = 1;
    const TYPE_XML_B = 2;
    private $csvTypeA;
    private $xmlTypeB;
    public function __construct(ParserInterface  $csvTypeA, ParserInterface  $xmlTypeB) {
        $this->csvTypeA = $csvTypeA;
        $this->xmlTypeB = $xmlTypeB;
    }
    
    public function get($type){
        $instance = null;
        switch ($type) {
            case self::TYPE_CSV_A:
                $instance = $this->csvTypeA;
                break;
            case  self::TYPE_XML_B:
                $instance = $this->xmlTypeB;
                break;
            default:
                throw new \Exception('Wrong parser type');
        }
        return $instance;
     }
}
