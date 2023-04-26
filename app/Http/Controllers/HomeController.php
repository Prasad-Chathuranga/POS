<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\Payment;
use App\Models\ProductCategories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use stdClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getRevenueStats()
    {
        $data = [];
        $data['currentMonth'] = date('m');
        $data['previousMonth'] = date('m', strtotime("-1 month"));
        $data['previousYear'] = date('Y', strtotime("-1 year"));
        $data['currentYear'] = date('Y');

        $data['totalRevenue'] =
            Payment::whereActive(Payment::STATUS_ACTIVE)
            ->whereStatus(Payment::STATUS_OK)
            ->sum('amount');

        $data['currentMonthRevenue'] =
            Payment::whereActive(Payment::STATUS_ACTIVE)
            ->whereStatus(Payment::STATUS_OK)
            ->whereYear('date', '=', $data['currentYear'])
            ->whereMonth('date', '=', $data['currentMonth'])
            ->sum('amount');

        $data['previousMonthRevenue'] =
            Payment::whereActive(Payment::STATUS_ACTIVE)
            ->whereStatus(Payment::STATUS_OK)
            ->whereYear('date', '=', $data['currentYear'])
            ->whereMonth('date', '=', $data['previousMonth'])
            ->sum('amount');

        $data['currentYearRevenue'] =
            Payment::whereActive(Payment::STATUS_ACTIVE)
            ->whereStatus(Payment::STATUS_OK)
            ->whereYear('date', '=', $data['currentYear'])
            ->sum('amount');

        $data['previousYearRevenue'] =
            Payment::whereActive(Payment::STATUS_ACTIVE)
            ->whereStatus(Payment::STATUS_OK)
            ->whereYear('date', '=', $data['previousYear'])
            ->sum('amount');


        for ($i = 1; $i <= 12; $i++) {
            $data['monthlyRevenue'][] = Payment::whereActive(Payment::STATUS_ACTIVE)
                ->whereStatus(Payment::STATUS_OK)
                ->whereYear('date', '=', $data['currentYear'])
                ->whereMonth('date', '=', $i)
                ->sum('amount');
        }

        $numberOfWeeksInMonth = Carbon::createFromDate($data['currentYear'], $data['currentMonth'])->endOfMonth()->weekOfMonth;

        for ($i = 1; $i <= $numberOfWeeksInMonth; $i++) {
            $data['weeklyRevenue'][] = Payment::whereActive(Payment::STATUS_ACTIVE)
                ->whereStatus(Payment::STATUS_OK)
                ->whereYear('date', '=', $data['currentYear'])
                ->whereMonth('date', '=', $data['currentMonth'])
                ->whereRaw('WEEK(date, 3) - WEEK(date - INTERVAL DAY(date)-1 DAY, 3) + 1 =' . $i)
                ->sum('amount');
        }

        $data['averageOrderAmountCurrentYear'] =
            Orders::whereActive(Orders::ORDER_STATUS_ACTIVE)
            ->whereStatus(Orders::ORDER_STATUS_OK)
            ->whereYear('created_at', '=', $data['currentYear'])
            ->average('amount');

        $data['averageOrderAmountPreviousYear'] =
            Orders::whereActive(Orders::ORDER_STATUS_ACTIVE)
            ->whereStatus(Orders::ORDER_STATUS_OK)
            ->whereYear('created_at', '=', $data['previousYear'])
            ->average('amount');

        for ($i = 1; $i <= 12; $i++) {
            $data['monthlyOrders'][] = Orders::whereActive(Orders::ORDER_STATUS_ACTIVE)
                ->whereStatus(Orders::ORDER_STATUS_OK)
                ->whereYear('created_at', '=', $data['currentYear'])
                ->whereMonth('created_at', '=', $i)
                ->count();
        }

        //Month Revenue Precentage
        $month_diff = $data['currentMonthRevenue'] - $data['previousMonthRevenue'];
        $month_more_less = $month_diff > 0 ? 1 : 0;
        $month_diff = abs($month_diff);
        $month_percentChange = ($month_diff / intval($data['currentMonthRevenue'])) * 100;

        $data['revenueMonthPrecentage'] = number_format($month_percentChange) . '%';
        $data['revenueMonthPrecentageStatus'] = $month_more_less;

        //Year Revenue Precentage
        $year_diff = $data['currentYearRevenue'] - $data['previousYearRevenue'];
        $year_more_less = $year_diff > 0 ? 1 : 0;
        $year_diff = abs($year_diff);
        $year_percentChange = ($year_diff / intval($data['currentYearRevenue'])) * 100;

        $data['revenueYearPrecentage'] = number_format($year_percentChange) . '%';
        $data['revenueYearPrecentageStatus'] = $year_more_less;

        //Year Order Average Precentage
        $year_diff_order_avg = $data['averageOrderAmountCurrentYear'] - $data['averageOrderAmountPreviousYear'];
        $year_more_less_order_avg = $year_diff_order_avg > 0 ? 1 : 0;
        $year_diff_order_avg = abs($year_diff_order_avg);
        $year_percentChange_order_avg = ($year_diff_order_avg / intval($data['averageOrderAmountCurrentYear'])) * 100;

        $data['revenueYearPrecentageAverageOrder'] = number_format($year_percentChange_order_avg) . '%';
        $data['revenueYearPrecentageStatusAverageOrder'] = $year_more_less_order_avg;

        for ($i=0; $i <= 5; $i++) { 
            $data['lastFiveYears'][$i]['x'] = date('Y', strtotime('-'.$i.' year'));
            $data['lastFiveYears'][$i]['y']=Payment::whereActive(Payment::STATUS_ACTIVE)
            ->whereStatus(Payment::STATUS_OK)
            ->whereYear('date', '=', date('Y', strtotime('-'.$i.' year')))
            ->sum('amount');

        }

        $categories = ProductCategories::all();

        //Revenue Product Category
        foreach ($categories as $key => $value) {
            // $data['columns'][][]=$value->name;
            $data['columns'][]= [$value->name,Orders::with('order_item_details')
            ->whereHas('order_item_details',function($q1) use($value){
                $q1->where('product_category_id',$value->id);
            })
            ->whereActive(Orders::ORDER_STATUS_ACTIVE)
            ->whereStatus(Orders::ORDER_STATUS_OK)
            ->whereYear('created_at', '=', $data['currentYear'])
            ->count()];
        }
    
        return response()->json(['data' => $data]);
    }
}
