<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;


class ReportController extends Controller
{

    public function index()
    {
        $currentDate = Carbon::now()->format('l, d F Y');

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

        return view('report.report')->with([
            'currentDate' => $currentDate,
            'products' => $products,
        ]);
    }

    public function barChart()
    {
        // Get the product categories
        $categories = Product::pluck('product_category')->unique();

        // Initialize the product data array
        $productData = [];

        // Define the week range
        $weeks = [
            'week1' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'week2' => [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()],
            'week3' => [Carbon::now()->startOfWeek()->subWeeks(2), Carbon::now()->endOfWeek()->subWeeks(2)],
            'week4' => [Carbon::now()->startOfWeek()->subWeeks(3), Carbon::now()->endOfWeek()->subWeeks(3)],
        ];

        // Loop through the categories and calculate the total quantity sold by week
        foreach ($weeks as $week => $weekRange) {
            $weekData = [
                'week' => $week,
                // 'ProductSold' => 0,
            ];

            foreach ($categories as $category) {
                $quantity = Cart::whereHas('product', function ($query) use ($category) {
                    $query->where('product_category', $category);
                })->whereBetween('updated_at', $weekRange)->sum('quantity');

                $weekData[$category] = $quantity;
            }

            $productData[] = $weekData;
        }

        return response()->json($productData);
    }

    public function exportCSV()
    {
        $products = Product::select(
            'product_id',
            'product_brand',
            'product_category',
            'product_price',
            'product_cost',
            'product_quantity',
        )->get();

        $data = [];
        foreach ($products as $item) {
            $row = [
                $item->product_id,
                $item->product_brand,
                $item->product_category,
                number_format($item->product_price, 2),
                number_format($item->product_cost, 2),
                $item->product_quantity,
                $item->product_brand,
            ];
            $data[] = $row;
        }

        // Create a temporary file path
        $tempFilePath = 'D:/PETAKOM_SalesData.csv';

        // Open the temporary file in write mode
        $file = fopen($tempFilePath, 'w');

        // Write the fields to the temporary file
        fputcsv($file, ['ITEM ID', 'BRAND', 'CATEGORY', 'PRICE', 'COST', 'QUANTITY SOLD', 'TOTAL SALES']);

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

    public function weeklySlot()
    {
        // Get the product categories
        $categories = Product::pluck('product_category')->unique();

        // Initialize the product data array
        $productData = [];

        // Define the week range
        $weeks = [
            'week1' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'week2' => [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()],
            'week3' => [Carbon::now()->startOfWeek()->subWeeks(2), Carbon::now()->endOfWeek()->subWeeks(2)],
            'week4' => [Carbon::now()->startOfWeek()->subWeeks(3), Carbon::now()->endOfWeek()->subWeeks(3)],
        ];

        // Loop through the categories and calculate the total quantity sold by week
        foreach ($weeks as $week => $weekRange) {
            $weekData = [
                'week' => $week,
                // 'ProductSold' => 0,
            ];

            foreach ($categories as $category) {
                $quantity = Cart::whereHas('product', function ($query) use ($category) {
                    $query->where('product_category', $category);
                })->whereBetween('updated_at', $weekRange)->sum('quantity');

                $weekData[$category] = $quantity;
            }

            $productData[] = $weekData;
        }

        return response()->json($productData);
    }

    public function monthlySlot()
    {
        // Get the product categories
        $categories = Product::pluck('product_category')->unique();

        // Initialize the product data array
        $productData = [];

        // Define the month range
        $months = [
            'Jan' => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            'Feb' => [Carbon::now()->startOfMonth()->subMonth(), Carbon::now()->endOfMonth()->subMonth()],
            'Mar' => [Carbon::now()->startOfMonth()->subMonths(2), Carbon::now()->endOfMonth()->subMonths(2)],
            // Add more months as needed
        ];

        // Loop through the categories and calculate the total quantity sold by month
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

        return response()->json($productData);
    }

    public function yearlySlot()
    {
        // Logic to handle the yearly slot request
    }

    public function getData($range)
    {
        $productData = [];

        switch ($range) {
            case 'weekly':
                $categories = Product::pluck('product_category')->unique();
                $weeks = [
                    'week1' => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
                    'week2' => [Carbon::now()->startOfWeek()->subWeek(), Carbon::now()->endOfWeek()->subWeek()],
                    'week3' => [Carbon::now()->startOfWeek()->subWeeks(2), Carbon::now()->endOfWeek()->subWeeks(2)],
                    'week4' => [Carbon::now()->startOfWeek()->subWeeks(3), Carbon::now()->endOfWeek()->subWeeks(3)],
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