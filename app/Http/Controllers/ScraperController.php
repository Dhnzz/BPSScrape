<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\{Target, Selector, Result, Keyword};
use Goutte\Client;

class ScraperController extends Controller
{
    public function index(Target $target)
    {
        $selectorCheck = $target->selector->where([['target_id', '=', $target->id], ['headline', '!=', null], ['date', '!=', null], ['link', '!=', null], ['content', '!=', null], ['cover', '!=', null], ['tags', '!=', null]])->count();
        if ($selectorCheck == 0) {
            return redirect()->route('target.index')->with('error', 'Silahkan isi selector dari target terlebih dahulu');
        }

        $keywords = Keyword::all();

        if ($keywords->count() == 0) {
            return redirect()->route('target.index')->with('error', 'Silahkan isi keyword dari terlebih dahulu');
        }

        foreach ($keywords as $item) {
            $key = Str::replace(' ', $target->connector, $item->slug);
            // Mengambil URL target yang disesuaikan dengan keyword
            $url = str_replace('keyword', $key, $target->url);
            $client = new Client();
            $targetUrl = $url;
            $crawler = $client->request('GET', $targetUrl);

            // Mengambil selector dari tabel selectors yang sesuai dengan target_id
            $selector = Selector::where('target_id', $target->id)->first();

            // Menggunakan selector secara dinamis untuk melakukan scraping
            $headlines = $crawler->filter($selector->headline)->each(function ($node) use ($key, $target, $selector) {
                $client = new Client();

                // Menyimpan data headline dan link
                $headline = [
                    'keyword' => Str::replace($target->connector, ' ', $key),
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
                if (count($date) > 1) {
                    $headline['date'] = $date[0];
                } else {
                    $headline['date'] = str_replace(['- '], '', implode(' ', $date));
                }

                $content = '';
                $content .= implode(
                    ' ',
                    $crawler->filter($selector->content)->each(function ($node) {
                        return $node->text();
                    }),
                );

                while (true) {
                    $nextPageLink = $crawler->filter('a:contains("Selanjutnya")');

                    if ($nextPageLink->count() == 0) {
                        break;
                    }

                    try {
                        $nextPageLink = $nextPageLink->link();
                        $crawler = $client->click($nextPageLink);

                        $content .= implode(
                            ' ',
                            $crawler->filter($selector->content)->each(function ($node) {
                                return $node->text();
                            }),
                        );
                    } catch (\Exception $e) {
                        //throw $th;
                        break;
                    }
                }
                $headline['content'] = $content;

                // Mengambil gambar cover menggunakan selector cover
                $cover = $crawler->filter($selector->cover)->each(function ($node) {
                    return $node->attr('data-src');
                });
                if ($cover[0] == null) {
                    $cover = $crawler->filter($selector->cover)->each(function ($node) {
                        return $node->attr('src');
                    });
                    $headline['cover'] = !empty($cover) ? $cover[0] : null;
                } else {
                    $headline['cover'] = !empty($cover) ? $cover[0] : null;
                }

                // Mengambil tags artikel menggunakan selector tags
                $tags = $crawler->filter($selector->tags)->each(function ($node) {
                    return $node->text();
                });
                $headline['tags'] = json_encode($tags);

                // Simpan ke database (periksa jika sudah ada, maka update; jika tidak, buat baru)
                $existingResult = Result::where('target_id', $target->id)
                    ->where('keyword', $headline['keyword'])
                    ->where('headline', $headline['headline'])
                    ->first();

                if ($existingResult) {
                    // Jika data sudah ada, update berita terbaru
                    $existingResult->update([
                        'keyword' => $headline['keyword'],
                        'headline' => $headline['headline'],
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
                        'date' => $headline['date'],
                        'link' => $headline['link'],
                        'content' => $headline['content'],
                        'cover' => $headline['cover'],
                        'tags' => $headline['tags'],
                    ]);
                }

                // dump($headline);
            });
        }

        return redirect()
            ->route('result.index', $target->id)
            ->with('success', 'Berhasil mendapatkan hasil scrape');
    }

    public function test(Target $target)
    {
        $selectorCheck = $target->selector->where([['target_id', '=', $target->id], ['headline', '!=', null], ['date', '!=', null], ['link', '!=', null], ['content', '!=', null], ['cover', '!=', null], ['tags', '!=', null]])->count();

        if ($selectorCheck == 0) {
            return redirect()->route('target.index')->with('error', 'Silahkan isi selector dari target terlebih dahulu');
        }

        $keywords = Keyword::all();
        if ($keywords->count() == 0) {
            return redirect()->route('target.index')->with('error', 'Silahkan isi keyword terlebih dahulu');
        }

        foreach ($keywords as $item) {
            $key = Str::replace(' ', $target->connector, $item->slug);
            // Mengambil URL target yang disesuaikan dengan keyword
            $url = str_replace('keyword', $key, $target->url);
            $client = new Client();
            $targetUrl = $url;
            $crawler = $client->request('GET', $targetUrl);

            // Mengambil selector dari tabel selectors yang sesuai dengan target_id
            $selector = Selector::where('target_id', $target->id)->first();

            // Counter untuk membatasi jumlah halaman
            $pageCounter = 0;

            // Loop untuk scraping halaman-halaman berikutnya, terbatas hanya 2 halaman
            while ($pageCounter < 2) {
                // Mengambil headlines di halaman saat ini
                $headlines = $crawler->filter($selector->headline)->each(function ($node) use ($key, $target, $selector) {
                    $client = new Client();

                    // Menyimpan data headline dan link
                    $headline = [
                        'keyword' => Str::replace($target->connector, ' ', $key),
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
                    $headline['date'] = count($date) > 1 ? $date[0] : str_replace(['- '], '', implode(' ', $date));

                    // Mengambil isi artikel menggunakan selector content
                    $content = '';
                    $content .= implode(
                        ' ',
                        $crawler->filter($selector->content)->each(function ($node) {
                            return $node->text();
                        }),
                    );

                    // Menangani jika artikel memiliki halaman lanjutan
                    while (true) {
                        $nextPageLink = $crawler->filter('a:contains("Selanjutnya")');

                        if ($nextPageLink->count() == 0) {
                            break;
                        }

                        try {
                            $nextPageLink = $nextPageLink->link();
                            $crawler = $client->click($nextPageLink);

                            $content .= implode(
                                ' ',
                                $crawler->filter($selector->content)->each(function ($node) {
                                    return $node->text();
                                }),
                            );
                        } catch (\Exception $e) {
                            break;
                        }
                    }
                    $headline['content'] = $content;

                    // Mengambil gambar cover menggunakan selector cover
                    $cover = $crawler->filter($selector->cover)->each(function ($node) {
                        return $node->attr('data-src') ?: $node->attr('src');
                    });
                    $headline['cover'] = !empty($cover) ? $cover[0] : null;

                    // Mengambil tags artikel menggunakan selector tags
                    $tags = $crawler->filter($selector->tags)->each(function ($node) {
                        return $node->text();
                    });
                    $headline['tags'] = json_encode($tags);

                    dump($headline);
                });

                // Cek apakah ada halaman berikutnya
                $nextPageLink = $crawler->filter('a:contains("Next")');

                if ($nextPageLink->count() > 0) {
                    // Jika ada, navigasi ke halaman berikutnya
                    $nextPageLink = $nextPageLink->link();
                    $crawler = $client->click($nextPageLink);
                    $pageCounter++; // Menambah counter halaman
                } else {
                    // Jika tidak ada halaman berikutnya, keluar dari loop
                    break;
                }
            }
        }

        dd('done');
    }
}
