<?php

namespace App\Services;

use App\Models\UrlShort;
use Illuminate\Support\Str;

class ShortUrlService {

    /**
     * Create UrlShort
     *
     * @param  $request
     * @return string
     */
    public function createShortUrl($request)
    {
        $urlShort = UrlShort::firstOrCreate(
            ['url' => $request['url']],
            ['short' => $this->generateSortUrl()]
        );

        return $urlShort->short;
    }

    /**
     * Generates string of seven characters
     *
     * @return string
     */
    private function generateSortUrl()
    {
        $shortUrl = Str::random(7);

        if(UrlShort::where('short', $shortUrl)->exists()){
           return $this->generateSortUrl(1);
        }

        return $shortUrl;
    }


}
