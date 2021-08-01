<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartsController extends Controller
{
    public function chart_formulaires() {
        $formulaires  = Form::select(DB::raw('COUNT(*) as count') , DB::raw('Month(created_at) as month'))
                        ->whereYear('created_at',date('Y'))
                        ->groupBy(DB::raw('Month(created_at)'))
                        ->pluck('count','month');

        foreach ($formulaires->keys() as $month_number) {
           $labels[] = date('F' , mktime(0, 0, 0, $month_number , 1));
        }

        $chart['labels'] = $labels;
        $chart['dataset'][0]['name'] = 'Formulaires';
        $chart['dataset'][0]['values'] = $formulaires->values()->toArray();

        return response()->json($chart);
    }
}
