<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Tests\ParserBundle\Parser;
use Symfony\Component\EventDispatcher\EventDispatcher;
use ParserBundle\Events\ParsedItemEvent;
use org\bovigo\vfs\vfsStream;
/**
 * Description of ParserBase
 *
 * @author kiryaserg
 */
class ParserBase extends \PHPUnit_Framework_TestCase  {
    protected $fileMock;
    protected $eventDispatcher;
    protected $fileReader;
    protected $file = 'test';
    protected function setUp() {
        $root = vfsStream::setup('home');
        $this->fileMock = vfsStream::newFile($this->file)
                ->at($root);
        $this->eventDispatcher = new EventDispatcher();
    }
    
     /**
     * @dataProvider allRowsCorrect
     */
    public function testCheckCorrectCountRowsParsedFromFile($content, $expect) {
        $eventCount = 0;
        $this->fileMock->setContent($content);
        
        $this->object->registerOnParseCallback(function ($e) use(&$eventCount) {
            $eventCount++;
        });
        
        $this->object->parse($this->fileMock->url());
        $this->assertEquals($expect, $eventCount);
    }
    
     /**
     * @dataProvider itemProvider
     */
    public function testCheckCorrectParsedItem($content, $expect) {
        $this->object->registerOnParseCallback( function ($event) use($expect) {
            $data = $event->getData();
            foreach ($expect as $key => $expetation) {
                $this->assertSame($expetation, $data[$key], "checked field: '$key'");
            }
        });
        $this->fileMock->setContent($content);
        $this->object->parse($this->fileMock->url());
    }
}
