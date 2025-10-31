<?php

namespace App\Http\Controllers\Web;

use App\Models\Common\GlobalSettings;
use App\Models\User\Deposit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebPagesController extends Controller
{
    public function home(Request $request)
    {
        $depositHistory = Deposit::paginate(GlobalSettings::DEFAULT_PER_PAGES);

        return view('pages.common.home', [
            'depositHistory' => $depositHistory,
        ]);
    }
}
