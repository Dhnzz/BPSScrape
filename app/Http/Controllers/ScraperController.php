<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Target, Selector, Result};
use Goutte\Client;

class ScraperController extends Controller
{
    public function index(Request $request, Target $target)
    {
        // Mengambil URL target yang disesuaikan dengan keyword
        $url = str_replace('keyword', $request->keyword, $target->url);
        $client = new Client();
        $targetUrl = $url;
        $crawler = $client->request('GET', $targetUrl);

        // Mengambil selector dari tabel selectors yang sesuai dengan target_id
        $selector = Selector::where('target_id', $target->id)->first();

        if (!$selector) {
            return response()->json(['error' => 'Selector not found for this target'], 404);
        }

        // Menggunakan selector secara dinamis untuk melakukan scraping
        $headlines = $crawler->filter($selector->headline)->each(function ($node) use ($request, $target, $selector) {
            $client = new Client();

            // Menyimpan data headline dan link
            $headline = [
                'keyword' => $request->keyword,
                'target_id' => $target->id,
                'headline' => $node->text(),
                'link' => $node->attr('href'),
            ];

            // Navigasi ke artikel untuk mengambil detail menggunakan link yang diambil
            $link = $node->link();
            $crawler = $client->click($link);

            // Mengambil tanggal publikasi menggunakan selector date
            $date = $crawler->filter($selector->date)->each(function ($node) {
                return $node->text();
            });
            $headline['date'] = str_replace(['- '], '', implode(' ', $date));

            // Mengambil isi artikel menggunakan selector content
            $content = $crawler->filter($selector->content)->each(function ($node) {
                return $node->text();
            });
            $headline['content'] = implode(' ', $content);

            // Mengambil gambar cover menggunakan selector cover
            $cover = $crawler->filter($selector->cover)->each(function ($node) {
                return $node->attr('src');
            });
            $headline['cover'] = !empty($cover) ? $cover[0] : null;

            // Mengambil tags artikel menggunakan selector tags
            $tags = $crawler->filter($selector->tags)->each(function ($node) {
                return $node->text();
            });
            $headline['tags'] = json_encode($tags);

            // Simpan ke database (periksa jika sudah ada, maka update; jika tidak, buat baru)
            $existingResult = Result::where('target_id', $target->id)
                ->where('keyword', $request->keyword)
                ->where('headline', $headline['headline'])
                ->first();

            if ($existingResult) {
                // Jika data sudah ada, update berita terbaru
                $existingResult->update([
                    'date' => $headline['date'],
                    'content' => $headline['content'],
                    'cover' => $headline['cover'],
                    'tags' => $headline['tags'],
                    'link' => $headline['link'],
                ]);
            } else {
                // Jika data tidak ada, buat entri baru
                Result::create([
                    'target_id' => $target->id,
                    'keyword' => $headline['keyword'],
                    'headline' => $headline['headline'],
                    'date' => $headline['date'] ? date('Y-m-d', strtotime($headline['date'])) : null,
                    'link' => $headline['link'],
                    'content' => $headline['content'],
                    'cover' => $headline['cover'],
                    'tags' => $headline['tags'],
                ]);
            }

            return $headline;
        });

        return redirect()->route('result.index')->with('success','Berhasil mendapatkan hasil scrape');
    }
}
