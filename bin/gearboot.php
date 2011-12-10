#!/usr/local/php/bin/php
<?php

function gearboot_help($e=0) {
    $o = <<<EOT
Simple bootstrap for a gearman worker.

-d          Script directory (default: .)
-f          Gearman worker function
-s          Gearman worker script (default: \$function . ".php")
-h          This help message
-H          Gearman server (default: localhost)
-p          Gearman port (default: 4730)
EOT;

    echo "{$o}\n\n";
    exit($e);
}

function gearboot_logger($msg)
{
    echo "{$msg}", PHP_EOL;
}


$options = getopt('d:f:s:H:p:');

if (array_key_exists('h', $options)) {
    gearboot_help();
}

if (!array_key_exists('d', $options)) {
    $options['d'] = '.';
}


if (!array_key_exists('f', $options)) {
    gearboot_help(1);
}

if (!array_key_exists('H', $options)) {
    $options['H'] = '127.0.0.1';
}

if (!array_key_exists('p', $options)) {
        $options['p'] = 4730;
}

$function = $options['f'];
$dir = $options['d'];
$host = $options['H'];
$port = $options['p'];

if (!array_key_exists('s', $options)) {
    $script = "{$function}.php";
} else {
    $script = $options['s'];
}

$file = "{$dir}/{$script}";

require $file;

$worker = new GearmanWorker;
gearboot_logger("Gearman worker running... press Ctrl-c to stop");
$worker->addServer($host, $port);

$worker->addFunction($function, function ($job) use ($function) {

    $handle = $job->handle();
    gearboot_logger("Received job: {$handle}");

    $result = $function($job);

    gearboot_logger("Finished job: {$handle}");

    return $result;
});

gearboot_logger("Listening for function: {$function}");

while($worker->work()) {
    if ($worker->returnCode() != GEARMAN_SUCCESS) {
        gearboot_logger("return_code: ", $worker->returnCode());
        break;
    }
}
