<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MagicLinkRepository;

class HomeController extends Controller
{
    
    private $magicLinkRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MagicLinkRepository $magicLinkRepository)
    {
        $this->magicLinkRepository = $magicLinkRepository;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $magicLink = $this->magicLinkRepository->getFirtsActiveMagicLinkByUserId(auth()->id());
        $hash = $magicLink ? $magicLink->hash : null;

        return view('home', compact('hash'));
    }
}
