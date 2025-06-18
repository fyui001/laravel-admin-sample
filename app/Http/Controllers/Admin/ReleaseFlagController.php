<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReleaseFlag\UpdateReleaseFlagRequest;
use App\Services\ReleaseFlagService;
use Domain\ReleaseFlag\ReleaseFlagName;
use Illuminate\View\View;

class ReleaseFlagController extends Controller
{
    public function __construct(
        private readonly ReleaseFlagService $releaseFlagService,
    ) {
        parent::__construct();
    }

    public function index(): View
    {
        $releaseFlagList = $this->releaseFlagService->getList();

        return view('release_flags.index', compact('releaseFlagList'));
    }

    public function edit($name): View
    {
        $releaseFlag = $this->releaseFlagService->get(ReleaseFlagName::tryFrom($name));

        return view('release_flags.edit', compact('releaseFlag'));
    }

    public function update(UpdateReleaseFlagRequest $request)
    {
        $this->releaseFlagService->upsert($request->toReleaseFlag());

        return redirect(route('admin.release_flags.index'))
            ->with('success', 'リリースフラグの変更が完了しました');
    }
}
