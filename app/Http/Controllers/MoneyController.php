<?php

namespace App\Http\Controllers;


use App\Models\ForexCost;
use App\Service\Converter\Conversion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class MoneyController extends Controller
{

    public function mainPage() {
        $forexCost = json_decode(ForexCost::query()->latest()->first()['forex_cost_array'], true);
        /** @var array $forexCost */
        return view('main', data: [
            "title" => 'Конвертер валют',
            "currencies" => $forexCost,
            "result" => 0,
        ]);
    }

    public function getResult(Request $request, Conversion $conversion) {
        $requestData = $request->toArray();
        $forexCost = json_decode(ForexCost::query()->latest()->first()['forex_cost_array'], true);
        $result = $conversion->convertForex($requestData['from'], $requestData['to'], $requestData['count']);
        return view('main', data: [
            "title" => 'Конвертер валют',
            "currencies" => $forexCost,
            "result" => $result,
        ]);    }
}
