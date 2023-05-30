<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{

    public function index(Request $request)
    {
        $currentDate = Carbon::now()->format('l, d F Y');

        //join table cart
        $totalQuantity = 0;
        $carts = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->select('carts.id', 'products.product_id', 'products.product_name', 'products.product_price', 'products.product_category', 'products.product_cost', 'carts.quantity', 'carts.created_at', 'carts.payment_id')
            ->where('carts.payment_id', '!=', null)
            ->orderBy('carts.created_at', 'desc')
            ->get();

        foreach ($carts as $cart) {
            $cart->profit = ($cart->product_price * $cart->quantity) - ($cart->product_cost * $cart->quantity);
        }

        // dd($carts);

        $products = Product::select(
            'products.product_id',
            'products.product_brand',
            'products.product_category',
            'products.product_price',
            'products.product_cost',
            'products.product_quantity',
            DB::raw('COALESCE(SUM(carts.quantity), 0) as total_quantity_sold'),
            DB::raw('(COALESCE(SUM(carts.quantity), 0) * products.product_price) - (COALESCE(SUM(carts.quantity), 0) * products.product_cost) as profit'),

        )->leftJoin('carts', function ($join) {
            $join->on('products.id', '=', 'carts.product_id')
                ->whereBetween('carts.updated_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
        })
            ->groupBy(
                'products.product_id',
                'products.product_brand',
                'products.product_category',
                'products.product_price',
                'products.product_cost',
                'products.product_quantity'
            )
            ->get();

        if ($request['range'] == 'weekly' || $request['range'] == 'monthly' || $request['range'] == 'yearly') {
            $range = $request['range'];
        } else {
            $range = 'weekly';
        }

        // dd($products);

        return view('report.report')->with([
            'currentDate' => $currentDate,
            'carts' => $carts,
            'products' => $products,
            'range' => $range,
        ]);
    }


    public function exportCSV()
    {

        //join table cart
        $totalQuantity = 0;
        $carts = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->select('carts.id', 'products.product_id', 'products.product_name', 'products.product_price', 'products.product_category', 'products.product_cost', 'carts.quantity', 'carts.created_at', 'carts.payment_id')
            ->where('carts.payment_id', '!=', null)
            ->orderBy('carts.created_at', 'desc')
            ->get();

        foreach ($carts as $cart) {
            $cart->profit = ($cart->product_price * $cart->quantity) - ($cart->product_cost * $cart->quantity);
        }

        $data = [];
        foreach ($carts as $cart) {
            $row = [
                $cart->product_id,
                $cart->product_name,
                $cart->product_category,
                number_format($cart->product_price, 2),
                number_format($cart->product_cost, 2),
                $cart->quantity,
                $cart->profit,
            ];
            $data[] = $row;
        }

        // Create a temporary file path
        $tempFilePath = 'D:/PETAKOM_SalesData.csv';

        // Open the temporary file in write mode
        $file = fopen($tempFilePath, 'w');

        // Write the fields to the temporary file
        fputcsv($file, ['ITEM ID', 'NAME', 'CATEGORY', 'PRICE', 'COST', 'QUANTITY SOLD', 'TOTAL SALES']);

        // Iterate through the data and write it to the temporary file
        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        // Close the file
        fclose($file);

        // Create the response with the file contents
        $response = Response::make(file_get_contents($tempFilePath));

        // Set headers to force download
        $response->header('Content-Type', 'application/csv');
        $response->header('Content-Disposition', 'attachment; filename="PETAKOM_SalesData.csv"');
        $response->header('Pragma', 'no-cache');
        $response->header('Expires', '0');

        // Delete the temporary file
        unlink($tempFilePath);

        return $response;
    }


    public function getData($range)
    {
        $productData = [];

        switch ($range) {
            case 'weekly':
                $categories = Product::pluck('product_category')->unique();
                $weeks = [
                    'Week 1' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
                    'Week 2' => [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()],
                    'Week 3' => [Carbon::now()->startOfWeek()->subWeeks(2), Carbon::now()->endOfWeek()->subWeeks(2)],
                    'Week 4' => [Carbon::now()->startOfWeek()->subWeeks(3), Carbon::now()->endOfWeek()->subWeeks(3)],
                ];

                foreach ($weeks as $week => $weekRange) {
                    $weekData = [
                        'week' => $week,
                    ];

                    foreach ($categories as $category) {
                        $quantity = Cart::whereHas('product', function ($query) use ($category) {
                            $query->where('product_category', $category);
                        })->whereBetween('updated_at', $weekRange)->sum('quantity');

                        $weekData[$category] = $quantity;
                    }

                    $productData[] = $weekData;
                }

                break;
            case 'monthly':
                $categories = Product::pluck('product_category')->unique();
                $months = [
                    'Jan' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
                    'Feb' => [Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->endOfMonth()->subMonth()],
                    'Mar' => [Carbon::now()->startOfMonth()->subMonths(2), Carbon::now()->endOfMonth()->subMonths(2)],
                    'Apr' => [Carbon::now()->startOfMonth()->subMonths(3), Carbon::now()->endOfMonth()->subMonths(3)],
                    'May' => [Carbon::now()->startOfMonth()->subMonths(4), Carbon::now()->endOfMonth()->subMonths(4)],
                    'Jun' => [Carbon::now()->startOfMonth()->subMonths(5), Carbon::now()->endOfMonth()->subMonths(5)],
                    'Jul' => [Carbon::now()->startOfMonth()->subMonths(6), Carbon::now()->endOfMonth()->subMonths(6)],
                    'Aug' => [Carbon::now()->startOfMonth()->subMonths(7), Carbon::now()->endOfMonth()->subMonths(7)],
                    'Sep' => [Carbon::now()->startOfMonth()->subMonths(8), Carbon::now()->endOfMonth()->subMonths(8)],
                    'Oct' => [Carbon::now()->startOfMonth()->subMonths(9), Carbon::now()->endOfMonth()->subMonths(9)],
                    'Nov' => [Carbon::now()->startOfMonth()->subMonths(10), Carbon::now()->endOfMonth()->subMonths(10)],
                    'Dec' => [Carbon::now()->startOfMonth()->subMonths(11), Carbon::now()->endOfMonth()->subMonths(11)],

                ];

                foreach ($months as $month => $monthRange) {
                    $monthData = [
                        'month' => $month,
                    ];

                    foreach ($categories as $category) {
                        $quantity = Cart::whereHas('product', function ($query) use ($category) {
                            $query->where('product_category', $category);
                        })->whereBetween('updated_at', $monthRange)->sum('quantity');

                        $monthData[$category] = $quantity;
                    }

                    $productData[] = $monthData;
                }

                Log::debug('Product Data:', $productData);


                break;

            case 'yearly':
                $categories = Product::pluck('product_category')->unique();
                $years = [
                    'Year 1' => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
                    'Year 2' => [Carbon::now()->startOfYear()->subYear(), Carbon::now()->endOfYear()->subYear()],
                    'Year 3' => [Carbon::now()->startOfYear()->subYears(2), Carbon::now()->endOfYear()->subYears(2)],
                    // Add more years as needed
                ];

                foreach ($years as $year => $yearRange) {
                    $yearData = [
                        'year' => $year,
                    ];

                    foreach ($categories as $category) {
                        $quantity = Cart::whereHas('product', function ($query) use ($category) {
                            $query->where('product_category', $category);
                        })->whereBetween('updated_at', $yearRange)->sum('quantity');

                        $yearData[$category] = $quantity;
                    }

                    $productData[] = $yearData;
                }

                break;

            default:
                return response()->json(['error' => 'Invalid range']);
        }

        return response()->json($productData);
    }
}
