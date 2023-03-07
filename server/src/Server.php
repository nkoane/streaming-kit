<?php

namespace Rebirth\Stream;

class Server
{
    private string $timezone = "Africa/Johannesburg";
    private string $cacheControl = "no-store";
    private string $contentType = "text/event-stream";

    private int $duration = 60;

    private int $counter;

    public function __construct()
    {
        date_default_timezone_set($this->timezone);
        header("Cache-Control: {$this->cacheControl}");
        header("Content-Type: {$this->contentType}");

        $duration = null;

        if (isset($_SERVER['argv']) && count($_SERVER['argv']) > 1) {
            $duration = (int) $_SERVER['argv'][1];
        } elseif (isset($_GET["duration"])) {
            $duration = (int) $_GET["duration"];
        } elseif (isset($_POST["duration"])) {
            $duration = (int) $_POST["duration"];
        }

        $this->duration = $duration ?? $this->duration;
    }

    private function getDiff(): string
    {
        return round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]);
    }

    private function getDuration(): int
    {
        return $this->duration;
    }

    private function generateCounter(): int
    {
        $this->counter = rand(1, 2);

        return $this->counter--;
    }

    public function run(?int $duration = null): void
    {

        $this->duration = $duration ?? $this->duration;

        while (true) {

            if (microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"] > $this->duration) {
                echo "data: [DONE]\n\n";
                break;
            }

            $micro = mt_rand(0, 2000000);
            $curDate = date(DATE_ATOM);

            if ($this->generateCounter() > 0) {
                echo "data: This is a message at time {$curDate}, duration: {$this->getDuration()}, diff: {$this->getDiff()}, micro: {$micro}, \n\n";
            }

            echo "event: ping\n";
            echo "data: {\"time\": \"{$curDate}\", \"counter\": \"{$this->counter}\", \"duration\": \"{$this->getDuration()}\" ,\"diff\": \"{$this->getDiff()}\",  \"micro\": \"{$micro}\"}";
            echo "\n\n";

            // Send a simple message at random intervals.
            if (ob_get_contents()) ob_end_flush();
            flush();

            // Break the loop if the client aborted the connection (closed the page)
            if (connection_aborted()) break;

            usleep($micro);
        }
    }
}
