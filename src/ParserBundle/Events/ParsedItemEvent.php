<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ParserBundle\Events;
use Symfony\Component\EventDispatcher\Event;

/**
 * Description of ParsedCsvItemEvent
 *
 * @author kiryaserg
 */
class ParsedItemEvent  extends Event {
    const NAME = 'item.parsed';
    public function __construct($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
        
    }

}
