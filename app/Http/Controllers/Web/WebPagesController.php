<?php

namespace App\Http\Controllers\Web;

use App\Models\Common\GlobalSettings;
use App\Http\Controllers\Controller;
use App\Models\User\DepositActions;
use Illuminate\Http\Request;

class WebPagesController extends Controller
{
    public function home(Request $request)
    {
        $depositHistory = DepositActions::orderBy('created_at', 'DESC')->paginate(GlobalSettings::DEFAULT_PER_PAGES);

        return view('pages.common.home', [
            'depositHistory' => $depositHistory,
        ]);
    }
}
