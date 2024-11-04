<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Target};
use Goutte\Client;

class ScraperController extends Controller
{
    public function index(Request $request, Target $target)
    {
        $url = str_replace('keyword',$request['keyword'],$target->url);
        $client = new Client();
        $targetUrl = $url;
        $crawler = $client->request('GET', $targetUrl);

        $headlines = $crawler->filter('h2.latest__title a')->each(function ($node) {
            $client = new Client();

            $headline = [
                'title' => $node->text(),
                'link' => $node->attr('href'),
            ];
            $link = $node->selectLink($node->text())->link();
            $crawler = $client->click($link);

            $date = $crawler->filter('div.read__info__date')->each(function ($node) {
                return $node->text();
            });
            $headline['date'] = implode(' ', $date);
            $headline['date'] = str_replace(['- '], '', $headline['date']);

            $content = $crawler->filter('article.read__content.clearfix p')->each(function ($node) {
                return $node->text();
            });
            $headline['content'] = implode(' ', $content);

            $cover = $crawler->filter('div.photo div.photo__img img')->each(function ($node){
                return $node->attr('src');
            });
            $headline['cover'] = implode(' ',$cover);

            $tags = $crawler->filter('ul.tag__list li h4 a')->each(function($node){
                return $node->text();
            });
            $headline['tags'] = $tags;

            return $headline;
        });

        // $link = $website->filter('h2.latest__title a.latest__link')->each(function ($node){
        //     return $node->attr('href');
        // });
        return $headlines;
    }
}
