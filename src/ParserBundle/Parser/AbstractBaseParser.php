<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ParserBundle\Parser;
use ParserBundle\Events\ParsedItemEvent;
/**
 * Description of AbstractBaseParser
 *
 * @author kiryaserg
 */
abstract class AbstractBaseParser implements ParserInterface {
    
    protected $fileReader;
    protected $eventDispatcher;
    private $moneyDecimals = 2;
    private $priceDecimalDelimer = '.';
    /**
     * Set defaults if parser don't find that field in parsed file  
     * @var array 
     */
    protected $defaultItemData = [
       'importShopId'=> '1',
       'orderId'=>'',
       'state'=> 'approved',
       'orderPayment'=>'',
       'currency'=>'USD',
       'createdAt'=>'',
   ];
    /**
     * Common method do parse data from file
     * @param string $file
     */
     public function parse($file){
        $this->fileReader->open($file);
        $this->registerCallback();
        $this->fileReader->parse($file);
        $this->fileReader->close($file);
    }
    
    /**
     * Sets shop id to defaults because there is no
     * shop id in file and we need to send our shop id 
     * via message
     * @param integer $id
     * @return \ParserBundle\Parser\AbstractBaseParser
     */
    public function setShopId($id) {
        $this->defaultItemData['shopId'] = $id;
        return $this;
    }
    
    /**
     * Should implement how to register callback
     */
    abstract protected function registerCallback();
    
    /**
     * Sends message with formated data somebody will recive and process
     * @param array $data
     */
    protected function dispatchEventItemIsParsed($data){
       $this->byCallback($data);
    }
    
    private function byCallback($data){
        call_user_func($this->callback, new ParsedItemEvent($data));
    }
    
    private function byEventDispatcher($data){
        $this->eventDispatcher->dispatch(
         ParsedItemEvent::NAME,
         new ParsedItemEvent($data));
    }
    
    protected function formatPrice($price){
        return number_format(
                floatval($price),
                $this->moneyDecimals,
                $this->priceDecimalDelimer,
                ""
            );
    }
    
    protected function formatItem($item) {
        $ret = $this->defaultItemData;
        foreach ($this->formatRule as $destKey => $geterMethod) {
            $value = $this->{$geterMethod}($item);
            if ($value !== false) {
                $ret[$destKey] = $value;
            }
        }
        return $ret;
    }
    protected $callback;
    
    public function registerOnParseCallback($callback){
        if (isset($this->callback)) {
            throw new Exception("Already exists callback");
        }
        if (!is_callable($callback)) {
            throw new Exception("Not callable callback");
        }
        $this->callback = $callback;
        return $this;
    }
}
