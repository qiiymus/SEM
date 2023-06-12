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

        $totalQuantity = 0;
        $carts = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->select('carts.id', 'products.product_id', 'products.product_name', 'products.product_price', 'products.product_category', 'products.product_cost', 'carts.quantity', 'carts.created_at', 'carts.payment_id')
            ->where('carts.payment_id', '!=', null)
            ->orderBy('carts.created_at', 'desc')
            ->get();

        foreach ($carts as $cart) {
            $cart->profit = ($cart->product_price * $cart->quantity) - ($cart->product_cost * $cart->quantity);
        }

        $products = Product::select(
            'products.product_id',
            'products.product_brand',
            'products.product_category',
            'products.product_price',
            'products.product_cost',
            'products.product_quantity',
            DB::raw('COALESCE(SUM(carts.quantity), 0) as total_quantity_sold'),
            DB::raw('(COALESCE(SUM(carts.quantity), 0) * products.product_price) - (COALESCE(SUM(carts.quantity), 0) * products.product_cost) as profit')
        )->leftJoin('carts', function ($join) use ($request) {
            $join->on('products.id', '=', 'carts.product_id')
                ->whereBetween('carts.updated_at', $this->getDateRange($request['range']));
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

        return view('report.report')->with([
            'currentDate' => $currentDate,
            'carts' => $carts,
            'products' => $products,
            'range' => $range,
        ]);
    }

    private function getDateRange($range)
    {
        $now = Carbon::now();

        switch ($range) {
            case 'weekly':
                return [
                    $now->startOfWeek(),
                    $now->endOfWeek(),
                ];
            case 'monthly':
                return [
                    $now->startOfMonth(),
                    $now->endOfMonth(),
                ];
            case 'yearly':
                return [
                    $now->startOfYear(),
                    $now->endOfYear(),
                ];
            default:
                return [
                    $now->startOfWeek(),
                    $now->endOfWeek(),
                ];
        }
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
                $currentWeek = Carbon::now()->weekOfYear;

                for ($i = 0; $i < 4; $i++) {
                    $weekData = [
                        'week' => 'Week ' . ($i + 1),
                    ];

                    foreach ($categories as $category) {
                        $quantity = Cart::whereHas('product', function ($query) use ($category) {
                            $query->where('product_category', $category);
                        })->where('updated_at', '>=', Carbon::now()->startOfWeek()->subWeeks($i + 1))
                            ->where('updated_at', '<', Carbon::now()->startOfWeek()->subWeeks($i)->endOfWeek())
                            ->sum('quantity');

                        $weekData[$category] = $quantity;
                    }

                    $productData[] = $weekData;
                }

                break;

            case 'monthly':
                $categories = Product::pluck('product_category')->unique();
                $currentMonth = Carbon::now()->month;

                for ($i = 0; $i < 12; $i++) {
                    $monthData = [
                        'month' => Carbon::now()->subMonths($i)->format('M'),
                    ];

                    foreach ($categories as $category) {
                        $quantity = Cart::whereHas('product', function ($query) use ($category) {
                            $query->where('product_category', $category);
                        })->whereMonth('updated_at', '=', $currentMonth - $i)->sum('quantity');

                        $monthData[$category] = $quantity;
                    }

                    $productData[] = $monthData;
                }

                break;

            case 'yearly':
                $categories = Product::pluck('product_category')->unique();
                $currentYear = Carbon::now()->year;

                for ($i = 0; $i < 3; $i++) {
                    $yearData = [
                        'year' => 'Year ' . ($i + 1),
                    ];

                    foreach ($categories as $category) {
                        $quantity = Cart::whereHas('product', function ($query) use ($category) {
                            $query->where('product_category', $category);
                        })->whereYear('updated_at', '=', $currentYear - $i)->sum('quantity');

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
