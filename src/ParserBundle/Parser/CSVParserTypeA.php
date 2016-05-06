<?php

namespace ParserBundle\Parser;

use ParserBundle\Reader\CsvFileReader;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CSVParserTypeA
 * @DI\Service("app.csv.parser")
 * @author kiryaserg
 */
class CSVParserTypeA extends AbstractBaseParser {

    private $validItemRule = [
        'Event Type' => 'Winning Bid (Revenue)',
    ];
    private $head = [];
    protected $formatRule = [
        'importShopId' => 'getFalse',
        'orderId' => 'getOrderId',
        'state' => 'getFalse',
        'orderPayment' => 'getOrderPayment',
        'currency' => 'getFalse',
        'createdAt' => 'getCreatedAt',
    ];
    private $orderIdField = 'Unique Transaction ID';
    private $orderPaymentField = 'eBay Total Sale Amount';
    private $createdAtField = 'Click Timestamp';
    protected $delimer = "\t";
    private $firstLine = true;

    public function __construct(CsvFileReader $fileReader, $eventDispatcher) {
        $this->fileReader = $fileReader;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Implements callback registration
     */
    protected function registerCallback() {
        $this->fileReader->registerCallback($this->delimer, [$this, 'onParsedItem']);
    }

    /**
     * Callback will be called when recieve parsed item
     * @param array $data
     */
    public function onParsedItem($data) {
        if ($this->firstLine) {
            $this->firstLine = false;
            $this->head = $data;
        } elseif ($this->needToExport($assocData = $this->getAsAssociativeArray($data))) {
            $this->dispatchEventItemIsParsed($this->formatItem($assocData));
        }
    }

    protected function getAsAssociativeArray($row) {
        $ret = [];
        foreach ($this->head as $key => $value) {
            $ret[$value] = $row[$key];
        }
        return $ret;
    }

    private function needToExport($item) {
        foreach ($this->validItemRule as $key => $value) {
            if (!isset($item[$key]) || $item[$key] !== $value) {
                return false;
            }
        }
        return true;
    }

    protected function getCreatedAt($item) {
        return (isset($item[$this->createdAtField])) ? strtotime($item[$this->createdAtField]) : false;
    }

    protected  function getFalse() {
        return false;
    }

    protected  function getOrderId($item) {
        return (isset($item[$this->orderIdField])) ? $item[$this->orderIdField] : false;
    }

    protected  function getOrderPayment($item) {
        if (isset($item[$this->orderPaymentField])) {
            return $this->formatPrice($item[$this->orderPaymentField]) ;
        } else {
            return false;
        }
    }
    

}
