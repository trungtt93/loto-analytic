<?php

namespace App\Crawlers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Http\Message\UriInterface;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Symfony\Component\DomCrawler\Crawler;

class Lottery extends CrawlObserver
{
    public function crawled(
        UriInterface $url,
        $response,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null
    ): void {
        $html = (string) $response->getBody();
        $crawler = new Crawler($html);

        if ($crawler->filter('tbody')->count() === 0) {
            return;
        }
        $path = $url->getPath();
        preg_match('/xsmb-(\d{1,2}-\d{1,2}-\d{4})\.html$/', $path, $matches);
        $dateString = $matches[1] ?? null;
        if ($dateString) {
            $data = [
                'db' => $this->getNumbers($crawler, '.v-gdb'),
                'g1' => $this->getNumbers($crawler, '.v-g1'),
                'g2' => $this->getNumbers($crawler, '.v-g2-0, .v-g2-1'),
                'g3' => $this->getNumbers($crawler, '.v-g3-0, .v-g3-1, .v-g3-2, .v-g3-3, .v-g3-4, .v-g3-5'),
                'g4' => $this->getNumbers($crawler, '.v-g4-0, .v-g4-1, .v-g4-2, .v-g4-3'),
                'g5' => $this->getNumbers($crawler, '.v-g5-0, .v-g5-1, .v-g5-2, .v-g5-3, .v-g5-4, .v-g5-5'),
                'g6' => $this->getNumbers($crawler, '.v-g6-0, .v-g6-1, .v-g6-2'),
                'g7' => $this->getNumbers($crawler, '.v-g7-0, .v-g7-1, .v-g7-2, .v-g7-3'),
            ];
            $date = Carbon::createFromFormat('d-m-Y', $dateString)->toDateString();
            \App\Models\Lottery::updateOrCreate(
                ['date' => $date],
                $data
            );
        }
    }

    function getNumbers(Crawler $crawler, string $selector): array
    {
        return $crawler->filter($selector)->each(fn ($node) => trim(Str::substr($node->text(), -2)));
    }

    public function crawlFailed(
        UriInterface $url,
        $requestException,
        ?UriInterface $foundOnUrl = null,
        ?string $linkText = null
    ): void {
        Log::info('Crawl failed', [
            'url' => (string) $url,
        ]);
    }
}
