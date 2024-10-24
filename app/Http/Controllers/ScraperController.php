<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte;

class ScraperController extends Controller
{
    public function index()
    {
        // $client = new Client();

        $website = Goutte::request('GET', 'https://www.hulondalo.id/search?q=BPS&sort=latest&page=1');

        $headlines = $website->filter('h2.latest__title a')->each(function ($node){
            return $node->text();
        });
        return $headlines;

    }
}
