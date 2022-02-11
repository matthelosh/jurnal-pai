<?php

namespace App\Http\Middleware;

use App\Models\Guru;
use App\Models\Menu;
use App\Models\User;
use App\Models\Periode;
use App\Models\Sekolah;
use Inertia\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'user' => Auth::user() ? $this->user($request) : 'null',
            'menus' => $request->user() ? Menu::all() : null,
            'periode' => Periode::where('active',1)->first(),
        ]);
    }

    function user($request) {
        if ($request->user()->role == 'admin') {
            return $request->user();
        } else {
            return User::where('userable_id', $request->user()->userable_id)->with('userable.sekolah')->first();
            // return $request->user()->userable_id;
        }
    }

}
