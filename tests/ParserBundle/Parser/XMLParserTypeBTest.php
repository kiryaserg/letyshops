<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\ParserBundle\Parser;
use ParserBundle\Parser\XMLParserTypeB;
use ParserBundle\Reader\XmlFileReader;
/**
 * Description of XMLParserTypeBTest
 *
 * @author kiryaserg
 */
class XMLParserTypeBTest extends ParserBase {
    protected $object;
    protected function setUp() {
        parent::setUp();
        $this->fileReader = new XmlFileReader();
        $this->object = new XMLParserTypeB(
            $this->fileReader, $this->eventDispatcher);
    }
    
    public function allRowsCorrect() {
        return [
            'empy item'=>['<empty></empty>',0],
            'one empty item'=>['<stat></stat>',1],
            'two items'=>['<stats><stat><currency>USD</currency></stat><stat><currency>UAH</currency></stat></stats>',2],
            'five items'=>['<stats><stat></stat><stat></stat><stat></stat><stat></stat><stat></stat></stats>',5],
            'full item'=>['<stats><stat>
<comment/>
<currency>USD</currency>
<website_name>Letyshops.ru</website_name>
<status_updated>2016-03-01 23:59:12</status_updated>
<advcampaign_id>6115</advcampaign_id>
<subid1>-</subid1>
<subid3>-</subid3>
<subid2>2016-03-01_23:57:25</subid2>
<subid4>-</subid4>
<click_date>2016-03-01 23:57:35</click_date>
<action_id>48559075</action_id>
<status>pending</status>
<order_id>73367792104711</order_id>
<cart>1.40</cart>
<conversion_time>97</conversion_time>
<payment>0.17</payment>
<advcampaign_name>Aliexpress INT</advcampaign_name>
<tariff_id>1954</tariff_id>
<closing_date>2016-05-10</closing_date>
<subid>13366481:402781:1456864423_188.163.98.113_413</subid>
<action_date>2016-03-01 23:59:12</action_date>
<action>Оплаченный заказ</action>
</stat></stats>', 1]
        ];
    }
    
    public function itemProvider() {
        $createTimeStr = '2016-02-06 09:47:58';
        $createTimeTimestamp = strtotime($createTimeStr);
        return [
            'correct item' => [
                '<stats><stat>
<currency>USD</currency>
<advcampaign_id>6115</advcampaign_id>
<action_id>48559075</action_id>
<status>pending</status>
<order_id>73367792104711</order_id>
<cart>1.40</cart>
<action_date>'.$createTimeStr.'</action_date>
</stat></stats>'
                ,
                ['importShopId' => '6115',
                    'orderId' => '73367792104711',
                    'state' => 'pending',
                    'orderPayment' => '1.40',
                    'currency' => 'USD',
                    'createdAt' => $createTimeTimestamp,
                ]
            ],
            'dafauld values when there is no fields' => [
                '<stats><stat></stat></stats>'
                ,
                ['importShopId' => '1',
                    'orderId' => '',
                    'state' => 'approved',
                    'orderPayment' => '',
                    'currency' => 'USD',
                    'createdAt' => '',
                ]
            ],
            'order payment starts from .99 should return 0.99' => [
                '<stats><stat><cart>.99</cart><action_date>'.$createTimeStr.'</action_date></stat></stats>'
                ,
                ['importShopId' => '1',
                    'orderId' => '',
                    'state' => 'approved',
                    'orderPayment' => '0.99',
                    'currency' => 'USD',
                    'createdAt' => $createTimeTimestamp,
                ]
            ],
        ];
    }
}
