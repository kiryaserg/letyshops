<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ParserBundle\Reader;

/**
 * Description of Filereader
 * @DI\Service("app.file.reader")
 * @author kiryaserg
 */
class CsvFileReader implements StreamFileReaderInterface {
    const MAX_LINE_LENGTH  = 100000;
    private $handle = false;
    private $callback;
    private $delimer;
    
    public function parse() {
        if ($this->handle !== false){
            while (($data = $this->readLine()) !== FALSE) {
                call_user_func($this->callback, $data);
            }
        }
    }
    
    public function open($file) {
        if(empty($file)){
            throw new Exception("Empty file name");
        }
        if(!is_string($file)){
            throw new Exception("File should be a string");
        }
        $this->handle = fopen($file, "r");
        return $this;
    }
    
    public function close() {
        if($this->handle!==false){
            $this->handle = fclose($this->handle);
            $this->handle = false;
        }
        return $this;
    }
    
    private function readLine() {
        if ($this->handle){
            return fgetcsv($this->handle, self::MAX_LINE_LENGTH, $this->delimer);
        }
        else{
            return false;
        }
    }
    
    public function registerCallback($delimer, $callback){
        if (isset($this->callback)) {
            throw new Exception("Already exists callback");
        }
        if (!is_callable($callback)) {
            throw new Exception("Not callable callback");
        }
        $this->delimer = $delimer;
        $this->callback = $callback;
    }
}
