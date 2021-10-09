<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Tags\Url;
use Spatie\Crawler\Crawler;
use Spatie\Sitemap\SitemapGenerator;
use GuzzleHttp\Psr7\Response;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate {--i|ignore-robots}';      //-i or --ignore-robots

    protected $description = 'Generate the sitemap.';

    public function handle()
    {
        SitemapGenerator::create(config('app.site_url'))
            ->configureCrawler(function (Crawler $crawler) {
                if ($this->option('ignore-robots')) {
                    $crawler->ignoreRobots();
                }
            })
            ->hasCrawled(function (Url $url, Response $response) {
                if ($url->path() === "/" || $response->getStatusCode() >= 300) {
                    return null;
                }
                return $url;
            })
            ->getSitemap()
            ->writeToFile(storage_path('app/sitemap.xml'));
    }
}
