<?php

date_default_timezone_set("Africa/Johannesburg");
header("Cache-Control: no-store");
header("Content-Type: text/event-stream");

$counter = rand(1, 10);
$diff = 0;

while (true) {
    // Every second, send a "ping" event.

    $micro = mt_rand(0, 2000000);

    echo "event: ping\n";
    $curDate = date(DATE_ATOM);
    // echo 'data: {"time": "' . $curDate . '", "micro": "' . $micro . ', "diff": "' . $diff . '"}';
    echo "data: {\"time\": \"{$curDate}\", \"micro\": \"{$micro}\", \"diff\": \"{$diff}\"}";
    echo "\n\n";

    // Send a simple message at random intervals.

    $counter--;

    if (!$counter) {
        echo "data: This is a message at time {$curDate}, micro: {$micro}, diff: $diff\n\n";
        $counter = rand(1, 10);
    }

    if (ob_get_contents()) ob_end_flush();
    flush();

    // Break the loop if the client aborted the connection (closed the page)

    if (connection_aborted()) break;


    usleep($micro);

    $diff = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
}
