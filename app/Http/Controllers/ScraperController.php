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

            $allHeadlines = []; // Variabel untuk menyimpan semua data headlines

            $pageCounter = 0;

            // Loop untuk scraping halaman berikutnya
            while ($pageCounter < 2) {
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
                    return $headline;
                });

                $allHeadlines = array_merge($allHeadlines, $headlines);

                // Cari link ke halaman berikutnya
                $nextPageLink = $crawler->filter('a:contains("Next")');

                if ($nextPageLink->count() > 0) {
                    try {
                        // Arahkan ke halaman berikutnya
                        $crawler = $client->click($nextPageLink->link());
                        $pageCounter++; // Tambah jumlah halaman yang sudah diproses
                    } catch (\Exception $e) {
                        break; // Jika ada error, keluar dari loop
                    }
                } else {
                    break; // Jika tidak ada link "Next", hentikan loop
                }
            }
            foreach ($allHeadlines as $item) {
                // Simpan ke database (periksa jika sudah ada, maka update; jika tidak, buat baru)
                $existingResult = Result::where('target_id', $target->id)
                    ->where('keyword', $item['keyword'])
                    ->where('headline', $item['headline'])
                    ->first();

                if ($existingResult) {
                    // Jika data sudah ada, update berita terbaru
                    $existingResult->update([
                        'keyword' => $item['keyword'],
                        'headline' => $item['headline'],
                        'date' => $item['date'],
                        'content' => $item['content'],
                        'cover' => $item['cover'],
                        'tags' => $item['tags'],
                        'link' => $item['link'],
                    ]);
                } else {
                    // Jika data tidak ada, buat entri baru
                    Result::create([
                        'target_id' => $target->id,
                        'keyword' => $item['keyword'],
                        'headline' => $item['headline'],
                        'date' => $item['date'],
                        'link' => $item['link'],
                        'content' => $item['content'],
                        'cover' => $item['cover'],
                        'tags' => $item['tags'],
                    ]);
                }
            }
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

            $allHeadlines = []; // Variabel untuk menyimpan semua data headlines

            $pageCounter = 0;

            // Loop untuk scraping halaman berikutnya
            while ($pageCounter < 2) {
                // Sesuaikan batas halaman
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

                    // Navigasi ke artikel untuk mengambil detail
                    $link = $node->link();
                    $crawler = $client->click($link);

                    // Mengambil tanggal
                    $date = $crawler->filter($selector->date)->each(function ($node) {
                        return $node->text();
                    });
                    $headline['date'] = count($date) > 1 ? $date[0] : str_replace(['- '], '', implode(' ', $date));

                    // Mengambil isi artikel
                    $content = implode(
                        ' ',
                        $crawler->filter($selector->content)->each(function ($node) {
                            return $node->text();
                        }),
                    );
                    $headline['content'] = $content;

                    // Mengambil cover
                    $cover = $crawler->filter($selector->cover)->each(function ($node) {
                        return $node->attr('data-src') ?: $node->attr('src');
                    });
                    $headline['cover'] = !empty($cover) ? $cover[0] : null;

                    // Mengambil tags
                    $tags = $crawler->filter($selector->tags)->each(function ($node) {
                        return $node->text();
                    });
                    $headline['tags'] = json_encode($tags);

                    return $headline;
                });

                // Tambahkan hasil dari halaman ini ke variabel global
                $allHeadlines = array_merge($allHeadlines, $headlines);

                // Cari link ke halaman berikutnya
                $nextPageLink = $crawler->filter('a:contains("Next")');

                if ($nextPageLink->count() > 0) {
                    try {
                        // Arahkan ke halaman berikutnya
                        $crawler = $client->click($nextPageLink->link());
                        $pageCounter++; // Tambah jumlah halaman yang sudah diproses
                    } catch (\Exception $e) {
                        break; // Jika ada error, keluar dari loop
                    }
                } else {
                    break; // Jika tidak ada link "Next", hentikan loop
                }
            }

            // Debug jumlah total data
            foreach ($allHeadlines as $item) {
                dump($item); // Total data dari semua halaman
            }
            dd('done');
        }
    }
}
