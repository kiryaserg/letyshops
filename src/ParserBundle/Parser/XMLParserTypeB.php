<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ParserBundle\Parser;
use ParserBundle\Reader\XmlFileReader;

/**
 * Description of XMLParserTypeB
 *
 * @author kiryaserg
 */
class XMLParserTypeB extends AbstractBaseParser {
    protected $node = 'stat';
    protected $formatRule = [
        'importShopId' => 'getImportShopId',
        'orderId' => 'getOrderId',
        'state' => 'getState',
        'orderPayment' => 'getOrderPayment',
        'currency' => 'getCurrency',
        'createdAt' => 'getCreatedAt',
    ];
    public function __construct(XmlFileReader $fileReader, $eventDispatcher) {
        $this->fileReader = $fileReader;
        $this->eventDispatcher = $eventDispatcher;
    }
    
    protected function registerCallback() {
        $this->fileReader->registerCallback($this->node, [$this, 'onParsedItem']);
    }
     /**
     * <advcampaign_id> - id магазина
<order_id> - id заказа в магазине
<status> - статус заказа
<cart> - сумма заказа
<currency> - валюта
<action_date> - время создания заказа
     */
    public function onParsedItem($xmlItem){
        $this->dispatchEventItemIsParsed($this->formatItem($xmlItem->expandSimpleXml()));
        return true;
    }
    
    protected  function getImportShopId($item){
        return (isset($item->advcampaign_id))?(string)$item->advcampaign_id:false;
    }
    
    protected  function getOrderId($item){
        return (isset($item->order_id))?(string)$item->order_id:false;
    }
    
    protected  function getState($item){
        return (isset($item->status))?(string)$item->status:false;
    }
    
    protected  function getOrderPayment($item){
        return (isset($item->cart))?$this->formatPrice((string)$item->cart):false;
    }
    
    protected  function getCurrency($item){
        return (isset($item->currency))?(string)$item->currency:false;
    }
    
    protected  function getCreatedAt($item){
        return (isset($item->action_date))?strtotime((string)$item->action_date):false;
    }
    
}
