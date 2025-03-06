<?php

namespace App\Http\Controllers\Frontend;

use App\Services\MaropostApi\MaropostApiService;
use App\Services\NotionApi\NotionApiService;

/**
 * Class HomeController.
 */
class HomeController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        // if (!auth()->check()) {
        //     return redirect()->route('frontend.auth.login');
        // }

        return view('frontend.index');
    }
}
