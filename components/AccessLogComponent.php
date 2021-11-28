<?php

namespace app\components;

use app\models\Accesslog;
use Kassner\LogParser\LogParser;
use yii\base\Component;

class AccessLogComponent extends Component
{
// Fonction to log user access to the database
    public function registerAccessLog(){
        $parser = new LogParser();
        $parser->setFormat('%h %l %u %t "%r" %>s %O "%{Referer}i" \"%{User-Agent}i"');
        $filename = 'C:\laragon\bin\nginx\nginx-1.10.1\logs\access.log';
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $entry = $parser->parse($line);
        }

        // If the user reload the same page, not intersted to save log again
        if($entry->HeaderReferer !== "-"){
            $accesslog = new Accesslog();

            // IP adress
            $accesslog->ip_address = $entry->host;
            // Request datetime
            $accessdate = new \DateTime($entry->time);
            $accesslog->request_at = $accessdate->format('Y-m-d H:i:s');
            // Request url
            $accesslog->url = $entry->HeaderReferer;
            // User Agent
            $accesslog->user_agent = $entry->HeaderUserAgent;
            // Parsing user agent string
            $UserAgentarray = get_browser($entry->HeaderUserAgent, true);
            // OS
            $accesslog->os = $UserAgentarray['platform'];
            // Architecture
            $accesslog->architecture = $UserAgentarray['platform_bits'];
            // Browser
            $accesslog->browser = $UserAgentarray['browser'];

            $accesslog->save();
        }
    }
}