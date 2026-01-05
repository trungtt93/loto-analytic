<?php

namespace App\Services;
use App\Crawlers\Lottery;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Spatie\Crawler\Crawler;

class CrawlerService extends BaseService
{


    public function fetchData($days): array
    {
        $res = [];
        $domain = 'https://xsmn.mobi/';
        $today = Carbon::today();
        for($i = 1; $i <= $days; $i++) {
            $date = $today->copy()->subDays($i);
            $formattedDate = $date->format('j-n-Y');
            $endpoint = "xsmb-{$formattedDate}.html";
            $url = $domain . $endpoint;
            $res[] = "Doing crawl for date: {$formattedDate} at URL: {$url}";
            Crawler::create()
                ->setCrawlObserver(new Lottery())
                ->setTotalCrawlLimit(1)
                ->startCrawling($url);
        }
        return $res;
    }
}
