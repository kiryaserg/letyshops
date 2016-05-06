<?php

namespace Tests\ParserBundle\Parser;
use ParserBundle\Parser\CSVParserTypeA;
use ParserBundle\Reader\CsvFileReader;
class CSVParserTypeATest extends ParserBase {
    protected $object;
    protected function setUp() {
        parent::setUp();
        $this->fileReader = new CsvFileReader();
        $this->object = new CSVParserTypeA(
            $this->fileReader, $this->eventDispatcher);
    }
    /**
     * This provider is used by testCheckCorrectCountRowsParsedFromFile test
     * @return array
     */
    public function allRowsCorrect() {
        return [
            'empty string' => ['', 0],
            'only header' => [
                'Event Date	Posting Date	Event Type	Amount	Program Id	Program Name	Campaign Id	Campaign Name	Tool Id	Tool Name	Custom Id	Click Timestamp	eBay Item ID	eBay Leaf Category ID	eBay Quantity Sold	eBay Total Sale Amount	Item Site ID	Meta Category ID	Unique Transaction ID	User Frequency ID	Earnings	Traffic Type	Item Name            '
                , 0],
            'one row' => [
                'Event Date	Posting Date	Event Type	Amount	Program Id	Program Name	Campaign Id	Campaign Name	Tool Id	Tool Name	Custom Id	Click Timestamp	eBay Item ID	eBay Leaf Category ID	eBay Quantity Sold	eBay Total Sale Amount	Item Site ID	Meta Category ID	Unique Transaction ID	User Frequency ID	Earnings	Traffic Type	Item Name
            2016-02-06	2016-03-08	Winning Bid (Revenue)	-.03	1	eBay US	5337776397	Default campaign	10001	Link Generator	14459738:261429:1452795219_94.233.174.79_992	2016-02-06 09:47:58	281836452862	42425		3.00	15	15032	201608730000347852	3	.00	Classic	5ml UV Glue LOCA Liquid Optical Clear Adhesive Fo Cellphone LCD Glass Repair C75'
                , 1],
            'one row but not allowed' => [
                'Event Date	Posting Date	Event Type	Amount	Program Id	Program Name	Campaign Id	Campaign Name	Tool Id	Tool Name	Custom Id	Click Timestamp	eBay Item ID	eBay Leaf Category ID	eBay Quantity Sold	eBay Total Sale Amount	Item Site ID	Meta Category ID	Unique Transaction ID	User Frequency ID	Earnings	Traffic Type	Item Name
            2016-02-06	2016-03-08	not allowed	-.03	1	eBay US	5337776397	Default campaign	10001	Link Generator	14459738:261429:1452795219_94.233.174.79_992	2016-02-06 09:47:58	281836452862	42425		3.00	15	15032	201608730000347852	3	.00	Classic	5ml UV Glue LOCA Liquid Optical Clear Adhesive Fo Cellphone LCD Glass Repair C75'
                , 0],
            'two rows but only one allowed by data' => [
                'Event Date	Posting Date	Event Type	Amount	Program Id	Program Name	Campaign Id	Campaign Name	Tool Id	Tool Name	Custom Id	Click Timestamp	eBay Item ID	eBay Leaf Category ID	eBay Quantity Sold	eBay Total Sale Amount	Item Site ID	Meta Category ID	Unique Transaction ID	User Frequency ID	Earnings	Traffic Type	Item Name
            2016-02-06	2016-03-08	Winning Bid (Revenue)	-.09	1	eBay US	5337776397	Default campaign	10001	Link Generator	14459738:293502:1453633787_176.51.26.86_653	2016-02-06 09:47:58	201492651634	45230		3.00	0	11450	201608720000331143	3	-.01	Classic	New  Winter Fashion Women Devil Hat Cute Cat Ears Wool Bowler Cap             
            2016-02-06	2016-03-08	not allowed	-.03	1	eBay US	5337776397	Default campaign	10001	Link Generator	14459738:261429:1452795219_94.233.174.79_992	2016-02-06 09:47:58	281836452862	42425		3.00	15	15032	201608730000347852	3	.00	Classic	5ml UV Glue LOCA Liquid Optical Clear Adhesive Fo Cellphone LCD Glass Repair C75'
                , 1],
            'five rows' => [
                'Event Date	Posting Date	Event Type	Amount	Program Id	Program Name	Campaign Id	Campaign Name	Tool Id	Tool Name	Custom Id	Click Timestamp	eBay Item ID	eBay Leaf Category ID	eBay Quantity Sold	eBay Total Sale Amount	Item Site ID	Meta Category ID	Unique Transaction ID	User Frequency ID	Earnings	Traffic Type	Item Name
            2016-02-06	2016-03-08	Winning Bid (Revenue)	-.09	1	eBay US	5337776397	Default campaign	10001	Link Generator	14459738:293502:1453633787_176.51.26.86_653	2016-02-06 09:47:58	201492651634	45230		3.00	0	11450	201608720000331143	3	-.01	Classic	New  Winter Fashion Women Devil Hat Cute Cat Ears Wool Bowler Cap 
            2016-02-06	2016-03-08	Winning Bid (Revenue)	-.09	1	eBay US	5337776397	Default campaign	10001	Link Generator	14459738:293502:1453633787_176.51.26.86_653	2016-02-06 09:47:58	201492651634	45230		3.00	0	11450	201608720000331143	3	-.01	Classic	New  Winter Fashion Women Devil Hat Cute Cat Ears Wool Bowler Cap 
            2016-02-06	2016-03-08	Winning Bid (Revenue)	-.09	1	eBay US	5337776397	Default campaign	10001	Link Generator	14459738:293502:1453633787_176.51.26.86_653	2016-02-06 09:47:58	201492651634	45230		3.00	0	11450	201608720000331143	3	-.01	Classic	New  Winter Fashion Women Devil Hat Cute Cat Ears Wool Bowler Cap 
            2016-02-06	2016-03-08	Winning Bid (Revenue)	-.09	1	eBay US	5337776397	Default campaign	10001	Link Generator	14459738:293502:1453633787_176.51.26.86_653	2016-02-06 09:47:58	201492651634	45230		3.00	0	11450	201608720000331143	3	-.01	Classic	New  Winter Fashion Women Devil Hat Cute Cat Ears Wool Bowler Cap 
            2016-02-06	2016-03-08	Winning Bid (Revenue)	-.03	1	eBay US	5337776397	Default campaign	10001	Link Generator	14459738:261429:1452795219_94.233.174.79_992	2016-02-06 09:47:58	281836452862	42425		3.00	15	15032	201608730000347852	3	.00	Classic	5ml UV Glue LOCA Liquid Optical Clear Adhesive Fo Cellphone LCD Glass Repair C75'
                , 5],
        ];
    }
    
    /**
     * This provider is used by testCheckCorrectParsedItem test
     * @return array
     */
    public function itemProvider() {
        $createTimeStr = '2016-02-06 09:47:58';
        $createTimeTimestamp = strtotime($createTimeStr);

        return [
            'correct item' => [
                'Event Date	Posting Date	Event Type	Amount	Program Id	Program Name	Campaign Id	Campaign Name	Tool Id	Tool Name	Custom Id	Click Timestamp	eBay Item ID	eBay Leaf Category ID	eBay Quantity Sold	eBay Total Sale Amount	Item Site ID	Meta Category ID	Unique Transaction ID	User Frequency ID	Earnings	Traffic Type	Item Name
            2016-02-06	2016-03-08	Winning Bid (Revenue)	-.03	1	eBay US	5337776397	Default campaign	10001	Link Generator	14459738:261429:1452795219_94.233.174.79_992	' . $createTimeStr . '	281836452862	42425		3.00	15	15032	201608730000347852	3	.00	Classic	5ml UV Glue LOCA Liquid Optical Clear Adhesive Fo Cellphone LCD Glass Repair C75'
                ,
                ['importShopId' => '1',
                    'orderId' => '201608730000347852',
                    'state' => 'approved',
                    'orderPayment' => '3.00',
                    'currency' => 'USD',
                    'createdAt' => $createTimeTimestamp,
                ]
            ],
            'order payment starts from .99 should return 0.99' => [
                'Event Date	Posting Date	Event Type	Amount	Program Id	Program Name	Campaign Id	Campaign Name	Tool Id	Tool Name	Custom Id	Click Timestamp	eBay Item ID	eBay Leaf Category ID	eBay Quantity Sold	eBay Total Sale Amount	Item Site ID	Meta Category ID	Unique Transaction ID	User Frequency ID	Earnings	Traffic Type	Item Name
            2016-02-06	2016-03-08	Winning Bid (Revenue)	-.03	1	eBay US	5337776397	Default campaign	10001	Link Generator	14459738:261429:1452795219_94.233.174.79_992	' . $createTimeStr . '	281836452862	42425		.99	15	15032	201608730000347852	3	.00	Classic	5ml UV Glue LOCA Liquid Optical Clear Adhesive Fo Cellphone LCD Glass Repair C75'
                ,
                ['importShopId' => '1',
                    'orderId' => '201608730000347852',
                    'state' => 'approved',
                    'orderPayment' => '0.99',
                    'currency' => 'USD',
                    'createdAt' => $createTimeTimestamp,
                ]
            ],
            'dafauld values when there is no fields' => [
                'Event Date	Posting Date	Event Type	Amount
            2016-02-06	2016-03-08	Winning Bid (Revenue)	-.03'
                ,
                ['importShopId' => '1',
                    'orderId' => '',
                    'state' => 'approved',
                    'orderPayment' => '',
                    'currency' => 'USD',
                    'createdAt' => '',
                ]
            ],
        ];
    }

}
