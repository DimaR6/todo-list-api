<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLuckyDrawRequest;
use App\Http\Requests\UpdateLuckyDrawRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\LuckyDrawRepository;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use App\Services\LuckyDrawService;

class LuckyDrawController extends AppBaseController
{
    /** @var LuckyDrawRepository $luckyDrawRepository*/
    private $luckyDrawRepository;
    private $luckyDrawService;

    public function __construct(LuckyDrawRepository $luckyDrawRepo, LuckyDrawService $luckyDrawService)
    {
        $this->luckyDrawRepository = $luckyDrawRepo;
        $this->luckyDrawService = $luckyDrawService;
    }

    /**
     * Display a listing of the LuckyDraw.
     */
    public function index(Request $request)
    {
        $luckyDraws = $this->luckyDrawRepository->latestThree(Auth::id());

        return view('lucky_draws.index', compact('luckyDraws'));
    }


    /**
     * Store a newly created LuckyDraw in storage.
     */
    public function store(Request $request)
    {
        $this->luckyDrawService->makeRoll();

        Flash::success('Roll The Dice result saved successfully.');

        return redirect(route('luckyDraws.index'));
    }

    /**
     * Display the specified LuckyDraw.
     */
    public function show($id)
    {
        $luckyDraw = $this->luckyDrawRepository->find($id);

        if (empty($luckyDraw)) {
            Flash::error('Lucky Draw not found');

            return redirect(route('luckyDraws.index'));
        }

        return view('lucky_draws.show')->with('luckyDraw', $luckyDraw);
    }
}
