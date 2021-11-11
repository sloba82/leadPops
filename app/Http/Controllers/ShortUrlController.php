<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\CreateShortUrlRequest;
use App\Models\UrlShort;

use Exception;


use App\Services\ShortUrlService;

class ShortUrlController extends Controller
{

    protected $shortUrlService;

    public function __construct(ShortUrlService $shortUrlService)
    {
        $this->shortUrlService = $shortUrlService;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\CreateShortUrlRequest $request
     * @return \Illuminate\Http\Response
     */

    public function createShortUrl(CreateShortUrlRequest $request)
    {
        try{
            $shortUrl = $this->shortUrlService->createShortUrl($request->all());
        }
        catch(Exception $e){
            return response()->json(['message' => 'Something went wrong']);
        }

        return response()->json(['short_url' => url("/{$shortUrl}")]);
    }

     /**
     * Redirect to requested url
     *  if url not valid or not provided it will return home screen
     *
     * @param  string $url
     * @return \Illuminate\Http\Response
     */
    public function redirectToUrl($url)
    {
        try{
            if($urlRedirect = UrlShort::where('short', $url)->first()){
                return redirect()->to($urlRedirect->url);
            }
        }
        catch(Exception $e){
            return response()->json(['message' => 'Something went wrong']);
        }

        return view('welcome');;
    }

}
