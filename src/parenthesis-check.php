#!/usr/bin/php
<?php

require_once("../vendor/autoload.php");

use Commands\ParenthesisCheckCommand;
use Library\ParenthesisChecker;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new ParenthesisCheckCommand(new ParenthesisChecker()));

$application->run();