<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\OrdersProducts;
use App\Models\PharmacyBranches;
use App\Models\User;
use App\Models\Views;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class AdminStatisticsController extends Controller
{
    private $timeRange;

    /**
     * returns the Views statistics of the day
     * @author @OxSama
     * @return Response status 200 with json in the form of:
     * data:{
     *   views:{
     *       counter: number_of_views int,
     *       previous_counter: number_of_previous_views int,
     *   },
     *   orders:{
     *       counter: number_of_orders int,
     *       previous_counter: number_of_previous_orders int,
     *   },
     *   pharmacies:{
     *       counter: number_new_pharmacies int,
     *   },
     *   users:{
     *       counter: number_of_new_users,
     *   }
     * }
     *
     */
    public function views()
    {

        $startOfToday = DateTime::createFromFormat('Y-M-D',date('Y-M-D'))->setTime(0,0);
        $yesterdayTimestamp = date('Y-m-d H:i:s',strtotime('-1 day', $startOfToday->getTimestamp()));
        $startOfTodayTimestamp = $startOfToday->format('Y-m-d H:i:s');
        $endOfToday = new DateTime('tomorrow');
        $endOfTodayTimestamp = $endOfToday->format('Y-m-d H:i:s');
        $todayViews = Views::whereBetween(
            'viewed_at',
            [$startOfTodayTimestamp , $endOfTodayTimestamp]
            )->count();
        /******************* */
        // DB::enableQueryLog();
        // get executed query
        // dd(DB::getQueryLog());
        /****************** */
        $yesterdayViews = Views::whereBetween(
            'viewed_at',
            [$yesterdayTimestamp , $startOfTodayTimestamp]
            )->count();

        $todayOrders = Orders::where(
            'type' , '=' , 'online'
            )->whereBetween(
                'created_at',
                [$startOfTodayTimestamp , $endOfTodayTimestamp]
                )->count();

        $yesterdayOrders = Orders::where(
            'type' , '=' , 'online'
            )->whereBetween(
                'created_at',
                [$yesterdayTimestamp , $startOfTodayTimestamp]
                )->count();

        $todayPharmacies = PharmacyBranches::where(
            'status' , '=' , 'active'
            )->count();

        $todayUsers = User::where(
            'status' , '=' , 'activated'
            )->count();

        return response([
            'data' => [
                'views' => [
                    'counter' => $todayViews,
                    'previous_counter' => $yesterdayViews,
                ],
                'orders' => [
                    'counter' => $todayOrders,
                    'previous_counter' => $yesterdayOrders
                ],
                'pharmacies' => [
                    'counter' => $todayPharmacies
                ],
                'users' => [
                    'counter' => $todayUsers
                ]
            ]
        ],200)->header('Content-Type' , 'application/json');

    }

    /**
     * This method returns statistics about sales for admin
     * ==========================================
     * @author @OxSama
     * @return \Illuminate\Http\Response status 200 with json
     * ==========================================
     * {
     *      'data' => {
     *          'sales' => {
     *              'counter' => number_of_sales int,
     *              'previous_counter' => number_of_previous_sales, int
     *          },
     *          'orders' => {
     *              'counter' => number_of_orders int,
     *              'previous_counter' => number_of_previous_orders int
     *          },
     *          'profits' => {
     *              'counter' => profits int,
     *              'previous_counter' => previous_profits int
     *          },
     *          'sold_products' => {
     *              'counter' => sold_products int,
     *              'previous_counter' => previous_sold_products int
     *          }
     *      }
     *  }
     *
     */
    public function sales()
    {
        //===================
        //sales
        $sales = OrdersProducts::with(
            [
                'order' => function($query)
                {
                    $query->whereBetween(
                        'created_at' ,
                        $this->getTimestamps('day')
                    );
                }
            ]
        )->get();
        $previousSales = OrdersProducts::with(
            [
                'order' => function($query)
                {
                    $query->whereBetween(
                        'created_at' ,
                        $this->getTimestamps('yesterday')
                    );
                }
            ]
        )->get();
        //sales end
        //====================

        //=========================
        //Orders
       $orders = Orders::whereBetween(
            'created_at',
            $this->getTimestamps('day')
        )->count();


        $previousOrders = Orders::whereBetween(
            'created_at',
            $this->getTimestamps('yesterday')
        )->count();
        //orders End
        //=============

        //================
        //profits
        $ordersProducts = OrdersProducts::with(
            [
                'order' => function($query)
                {
                    $query->whereBetween(
                        'created_at' ,
                        $this->getTimestamps('day')
                    );
                }
            ]
        )->get();

        $previousOrdersProducts = OrdersProducts::with(
            [
                'order' => function($query)
                {
                    $query->whereBetween(
                        'created_at' ,
                        $this->getTimestamps('yesterday')
                    );
                }
            ]
        )->get();
        // profits end
        //===================


        //===================
        //productsSold
        $soldProducts = Orders::whereBetween(
            'created_at',
            $this->getTimestamps('day')
        )->get('products_amount');

        $previousSoldProducts = Orders::whereBetween(
            'created_at',
            $this->getTimestamps('yesterday')
        )->get('products_amount');
        //sold sold end
        //====================


        return response([
            'data' => [
                'sales' => [
                    'counter' => $this->calculate($sales , 'sales'),
                    'previous_counter' => $this->calculate($previousSales , 'sales'),
                ],
                'orders' => [
                    'counter' => $orders,
                    'previous_counter' => $previousOrders
                ],
                'profits' => [
                    'counter' => $this->calculate($ordersProducts , 'profit'),
                    'previous_counter' => $this->calculate($previousOrdersProducts,'profit')
                ],
                'sold_products' => [
                    'counter' => $this->getSoldProducts($soldProducts),
                    'previous_counter' => $this->getSoldProducts($previousSoldProducts)
                ]
            ]
        ],200)->header('Content-Type' , 'application/json');
    }

    /**
     * returns sum of sold products
     * ==========================================
     * @author @OxSam
     * @param Collection $soldProducts
     * @return int $soldProducts->sum()
     * ==========================================
     */
    private function getSoldProducts($soldProducts){
        foreach($soldProducts as $key => $value){
            $soldProducts[$key] = $value->products_amount;
        }
        return $soldProducts->sum();
    }

    /**
     * calculate the operation and return sum
     * ==========================================
     * @author @OxSam
     * @param Collection $ordersProducts
     * @param String $operation
     * @return int $operationValues->sum()
     * ==========================================
     */
    private function calculate($ordersProducts , $operation){
        foreach($ordersProducts as $key =>$value){
            if($ordersProducts[$key]->order == null){
                $ordersProducts->forget($key);
            }
        }
        $operationAssign=0;
        switch($operation){
            case 'profit' :
                $operationAssign = $ordersProducts->each(
                    function($object,$key){
                        $profit = $object->price - $object->cost;
                        $profit = $profit * $object->quantity;
                        $object['operation'] = $profit;
                    }
                );
                break;
            case 'sales' :
                $operationAssign = $ordersProducts->each(
                    function($object,$key){
                        $sale = $object->price * $object->quantity;
                        $object['operation'] = $sale;
                    }
                );
                break;
            default:
            return response(['Message'=>'Internal Error'],500);
            break;
        }
        $operationValues = collect();
        foreach($operationAssign as $key => $value){
            $operationValues->put($key , $value->operation);
        }
        return $operationValues->sum();
    }

    /**
     * returns collection of online orders statistics during the selected $time period
     * ==========================================
     * @author @OxSam
     * @param String $time
     * @return \Illuminate\Http\Response
     * ==========================================
     * the response data is in form
     * [ finishedOrders , pendingOrders , confirmedOrders , canceledOrders ]
     */
    public function getOnlineOrdersStatistics($time)
    {
        if(!($this->getTimestamps($time))){
            return response(['message' => 'Request is badly formed'],400);
        }else{

            $finishedOrders = Orders::where([
                ['type' , '=' , 'online'],
                ['status' , '=' , 'finished']
            ])->whereBetween(
                'created_at',
                $this->getTimestamps($time)
            )->count();

            $pendingOrders = Orders::where([
                ['type' , '=' , 'online'],
                ['status' , '=' , 'pending']
            ])->whereBetween(
                'created_at',
                $this->getTimestamps($time)
            )->count();

            $confirmedOrders = Orders::where([
                ['type' , '=' , 'online'],
                ['status' , '=' , 'payment_confrimed']
            ])->whereBetween(
                'created_at',
                $this->getTimestamps($time)
            )->count();

            $canceledOrders =  Orders::where([
                ['type' , '=' , 'online'],
                ['status' , '=' , 'rejected']
            ])->whereBetween(
                'created_at',
                $this->getTimestamps($time)
            )->count();

            return response(
                collect([
                    $finishedOrders,
                    $pendingOrders,
                    $confirmedOrders,
                    $canceledOrders
                ]),
                200,
                ['Content-Type' , 'application/json']
            );
        }
    }

    /**
     * This method returns array of startTime and End time
     * ==========================================
     * @author @OxSama
     * @param String $time
     * @return array[ String startTimestamp , String endTimestamp ]
     * ==========================================
     */
    private function getTimestamps($time)
    {
        $startOfToday = DateTime::createFromFormat('Y-M-D',date('Y-M-D'))->setTime(0,0);
        $startOfTodayTimestamp = $startOfToday->format('Y-m-d H:i:s');
        switch($time){
            case $time == 'day':
                isset($this->timeRange)? '': $this->setTimeRange($time);
                // dd($this->timeRange);
                $endOfToday = new DateTime('tomorrow');
                $endOfTodayTimestamp = $endOfToday->format('Y-m-d H:i:s');
                return [$startOfTodayTimestamp , $endOfTodayTimestamp];
                break;
            case $time == 'week':
                isset($this->timeRange)? '': $this->setTimeRange($time);
                // dd($this->timeRange);
                $lastWeekTimestamp = date(
                    'Y-m-d H:i:s',
                    strtotime('-1 week',$startOfToday->getTimestamp())
                );
                return [$lastWeekTimestamp , $startOfToday->format('Y-m-d 23:59:59')];
                break;
            case $time == 'month':
                isset($this->timeRange)? '': $this->setTimeRange($time);
                // dd($this->timeRange);
                return [date('Y-m-01 00:00:00') , date('Y-m-d 23:59:59')];
                break;
            case $time == 'year':
                isset($this->timeRange)? : $this->setTimeRange($time);
                // dd($this->timeRange);
                return [date('Y-01-01 00:00:00') , date('Y-m-d 23:59:59')];
                break;
            default :
                switch($time){
                    case $time == 'yesterday':
                        return [(new Carbon('yesterday'))->format('Y-m-d 00:00:00') , (new Carbon('yesterday'))->format('Y-m-d 23:59:59') ];
                        break;
                    default :
                        return false;
                        break;
                }
        }
    }

    /**
     * This method returns statistics about views for admin
     * ==========================================
     * @author @OxSama
     * @param String $time
     * @return \Illuminate\Http\Response
     * ==========================================
     */
    public function getViewsStatistics($time)
    {
        //check $time is valid
        if(!($this->getTimestamps($time))){
            return response(['message' => 'Request is badly formed'],400);
        }else{
            //check if its day
            if(($this->getTimestamps($time)[0] == Carbon::today('CAT')->format('Y-m-d 00:00:00')
                && $this->getTimestamps($time)[1] == Carbon::tomorrow('CAT')->format('Y-m-d 00:00:00'))
            ){
                $views = Views::whereBetween(
                    'viewed_at',
                    $this->getTimestamps($time)
                )->get()->groupBy(
                    function($date) {
                        return Carbon::parse($date->viewed_at)->format('h'); // grouping by hours
                    }
                );
                $views = $this->prepareData($views);
                return isset($this->timeRange)? $this->buildResponseForViews($views): response(['Message'=>'Internal Error'],500);
            }
            //check if it a month
            elseif($this->getTimestamps($time)[0] == (new Carbon('first day of this month'))->format('Y-m-d 00:00:00')
            && $this->getTimestamps($time)[1] == (new Carbon('now'))->format('Y-m-d 23:59:59')){
                $views = Views::whereBetween(
                    'viewed_at',
                    $this->getTimestamps($time)
                )->get()->groupBy(
                    function($date) {
                        return Carbon::parse($date->viewed_at)->format('d'); // grouping by days
                    }
                );
                $views = $this->prepareData($views);
               return isset($this->timeRange)? $this->buildResponseForViews($views): response(['Message'=>'Internal Error'],500);
            }
            //check if its a year
            elseif($this->getTimestamps($time)[0] == (new Carbon('first day of january'))->format('Y-m-d 00:00:00')
            && $this->getTimestamps($time)[1] == (new Carbon('now'))->format('Y-m-d 23:59:59')){
                $views = Views::whereBetween(
                    'viewed_at',
                    $this->getTimestamps($time)
                )->get()->groupBy(
                    function($date) {
                        return Carbon::parse($date->viewed_at)->format('m'); // grouping by months
                    }
                );
                $views = $this->prepareData($views);
                return isset($this->timeRange)? $this->buildResponseForViews($views): response(['Message'=>'Internal Error'],500);
            }
            //check if its a week
            elseif($this->getTimestamps($time)[0] == Carbon::now('CAT')->subDays(7)->format('Y-m-d 00:00:00')
            && $this->getTimestamps($time)[1] == (new Carbon('now'))->format('Y-m-d 23:59:59')){
                $views = Views::whereBetween(
                    'viewed_at',
                    $this->getTimestamps($time)
                )->get()->groupBy(
                    function($date) {
                        return Carbon::parse($date->viewed_at)->format('d'); // grouping by days of the week
                    }
                );
                $views = $this->prepareData($views);
                return isset($this->timeRange)? $this->buildResponseForViews($views): response(['Message'=>'Internal Error'],500);
            }else{
                return response(['Message' => 'Request is badly formed'],400);
            }
        }
    }
    /**
     * This method returns statistics about orders for admin
     * ==========================================
     * @author @OxSama
     * @param String $time
     * @return \Illuminate\Http\Response
     * ==========================================
     */
    public function getOrdersLineStatistics($time)
    {
        //check $time is valid
        if(!($this->getTimestamps($time))){
            return response(['message' => 'Request is badly formed'],400);
        }else{
            //check if its day
            if(($this->getTimestamps($time)[0] == Carbon::today('CAT')->format('Y-m-d 00:00:00')
                && $this->getTimestamps($time)[1] == Carbon::tomorrow('CAT')->format('Y-m-d 00:00:00'))
            ){
                $orders = Orders::whereBetween(
                    'created_at',
                    $this->getTimestamps($time)
                )->get()->groupBy(
                    function($date) {
                        return Carbon::parse($date->created_at)->format('h'); // grouping by hours
                    }
                );
                $orders = $this->prepareData($orders);
                return isset($this->timeRange)? $this->buildResponseForViews($orders): response(['Message'=>'Internal Error'],500);;
            }
            //check if it a month
            elseif($this->getTimestamps($time)[0] == (new Carbon('first day of this month'))->format('Y-m-d 00:00:00')
            && $this->getTimestamps($time)[1] == (new Carbon('now'))->format('Y-m-d 23:59:59')){
                $orders = Orders::whereBetween(
                    'created_at',
                    $this->getTimestamps($time)
                )->get()->groupBy(
                    function($date) {
                        return Carbon::parse($date->created_at)->format('d'); // grouping by days
                    }
                );
                $orders = $this->prepareData($orders);
               return isset($this->timeRange)? $this->buildResponseForViews($orders): response(['Message'=>'Internal Error'],500);
            }
            //check if its a year
            elseif($this->getTimestamps($time)[0] == (new Carbon('first day of january'))->format('Y-m-d 00:00:00')
            && $this->getTimestamps($time)[1] == (new Carbon('now'))->format('Y-m-d 23:59:59')){
                $orders = Orders::whereBetween(
                    'created_at',
                    $this->getTimestamps($time)
                )->get()->groupBy(
                    function($date) {
                        return Carbon::parse($date->created_at)->format('m'); // grouping by months
                    }
                );
                $orders = $this->prepareData($orders);
                return isset($this->timeRange)? $this->buildResponseForViews($orders): response(['Message'=>'Internal Error'],500);
            }
            //check if its a week
            elseif($this->getTimestamps($time)[0] == Carbon::now('CAT')->subDays(7)->format('Y-m-d 00:00:00')
            && $this->getTimestamps($time)[1] == (new Carbon('now'))->format('Y-m-d 23:59:59')){
                $orders = Orders::whereBetween(
                    'created_at',
                    $this->getTimestamps($time)
                )->get()->groupBy(
                    function($date) {
                        return Carbon::parse($date->created_at)->format('d'); // grouping by days of the week
                    }
                );
                $orders = $this->prepareData($orders);
                return isset($this->timeRange)? $this->buildResponseForViews($orders): response(['Message'=>'Internal Error'],500);
            }else{
                return response(['Message' => 'Request is badly formed'],400);
            }
        }
    }
    /**
     * This method builds responses for charts.js charts and add default values
     * ==========================================
     * @author @OxSama
     * @param Array $data
     * @return \Illuminate\Http\Response
     * ==========================================
     */
    private function buildResponseForViews($data)
    {
        $response = collect();
        for ($i=$this->timeRange[0]; $i <= $this->timeRange[1] ; $i++) {
            if(!isset($data[$i])){
                $data->put($i,0);
            }
            $response->push($data[$i]);
        }
        return response($response,200,['Content-Type' , 'application/json']);
    }

    /**
     * This method delete string keys and add integer ones
     * ==========================================
     * @author @OxSama
     * @param Array $data
     * @return \Illuminate\Http\Response
     * ==========================================
     */
    private function prepareData($views)
    {
        //count the data
        foreach($views as $key => $viewOfTimeSlot){
            $key = (int)$key;
            $views[$key] = $viewOfTimeSlot->count();
       }
       // delete strings
       foreach($views as $key => $viewOfTimeSlot){
           if(is_string($key)){
               $views->forget($key);
           }
       }
       return $views;
    }

    /**
     * This method sets $timeRange with array of two integers depending on the $time
     * ==========================================
     * @author @OxSama
     * @param String $time
     * ==========================================
     */
    private function setTimeRange($time)
    {
        switch($time){
            case 'day':
                $this->timeRange = [Carbon::now('CAT')->startOfDay()->hour , Carbon::now('CAT')->hour ];
                break;
            case 'week':
                $this->timeRange = [(Carbon::now()->subDays(6))->day , Carbon::now('CAT')->day ];
                break;
            case 'month':
                $this->timeRange = [(new Carbon('first day of this month'))->day , Carbon::now('CAT')->day ];
                break;
            case 'year':
                $this->timeRange = [(new Carbon('first day of january'))->month , Carbon::now('CAT')->month ];
                break;
        }
    }

}
