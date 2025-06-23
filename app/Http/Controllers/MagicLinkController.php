<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMagicLinkRequest;
use App\Http\Requests\UpdateMagicLinkRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\MagicLinkRepository;
use Illuminate\Http\Request;
use Flash;
use App\Services\MagicLinkService;
use Illuminate\Support\Facades\Auth;

class MagicLinkController extends AppBaseController
{
    /** @var MagicLinkRepository $magicLinkRepository*/
    private $magicLinkRepository;
    private $magicLinkService;

    public function __construct(MagicLinkRepository $magicLinkRepo, MagicLinkService $magicLinkService)
    {
        $this->magicLinkRepository = $magicLinkRepo;
        $this->magicLinkService = $magicLinkService;
    }

    /**
     * Display a listing of the MagicLink.
     */
    public function index(Request $request)
    {
        $magicLinks = $this->magicLinkRepository->getMagicLinksByUserId(Auth::id());

        return view('magic_links.index')
            ->with('magicLinks', $magicLinks);
    }

    /**
     * Show the form for creating a new MagicLink.
     */
    public function create()
    {
        return view('magic_links.create');
    }

    /**
     * Store a newly created MagicLink in storage.
     */
    public function store(CreateMagicLinkRequest $request)
    {
        $isActive = $request->get('is_active');
        $user = Auth::user();

        $this->magicLinkService->createMagicLink([
            'is_active' => $isActive,
            'user_id' => $user->id,
        ]);

        Flash::success('Magic Link saved successfully.');

        return redirect(route('magicLinks.index'));
    }

    /**
     * Display the specified MagicLink.
     */
    public function show($id)
    {
        $magicLink = $this->magicLinkRepository->find($id);

        if (empty($magicLink)) {
            Flash::error('Magic Link not found');

            return redirect(route('magicLinks.index'));
        }

        return view('magic_links.show')->with('magicLink', $magicLink);
    }

    /**
     * Show the form for editing the specified MagicLink.
     */
    public function edit($id)
    {
        $magicLink = $this->magicLinkRepository->find($id);

        if (empty($magicLink)) {
            Flash::error('Magic Link not found');

            return redirect(route('magicLinks.index'));
        }

        return view('magic_links.edit')->with('magicLink', $magicLink);
    }

    /**
     * Update the specified MagicLink in storage.
     */
    public function update($id, UpdateMagicLinkRequest $request)
    {
        $magicLink = $this->magicLinkRepository->find($id);

        if (empty($magicLink)) {
            Flash::error('Magic Link not found');

            return redirect(route('magicLinks.index'));
        }

        $magicLink = $this->magicLinkRepository->update($request->all(), $id);

        Flash::success('Magic Link updated successfully.');

        return redirect(route('magicLinks.index'));
    }

    /**
     * Remove the specified MagicLink from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $magicLink = $this->magicLinkRepository->find($id);

        if (empty($magicLink)) {
            Flash::error('Magic Link not found');

            return redirect(route('magicLinks.index'));
        }

        $this->magicLinkRepository->delete($id);

        Flash::success('Magic Link deleted successfully.');

        return redirect(route('magicLinks.index'));
    }
}
