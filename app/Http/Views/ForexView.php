<?php

namespace App\Http\Views;

use App\Http\Controllers\Controller;
use App\Models\ForexCost;
use Illuminate\Http\Request;

class ForexView extends Controller
{
    public function mainPage(Request $request)
    {
        $queryParams = $request->toArray();
        $currencies = ForexCost::query()->latest()->first();

        return view('main_page', [
            "currencies" => $currencies
        ]);
    }
}