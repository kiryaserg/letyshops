#!/usr/bin/env php
<?php

require __DIR__.'/../vendor/autoload.php';

use AppBundle\Console\ParserStart;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new ParserStart());
$application->run();