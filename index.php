<?php

use App\Commands\DataDictCommand;
use Symfony\Component\Console\Application;

require __DIR__ . "/vendor/autoload.php";

$application = new Application("Data Dict", "0.1");

$command = new DataDictCommand();

$application->add($command);

$application->setDefaultCommand($command->getName(), true);

$application->run();
