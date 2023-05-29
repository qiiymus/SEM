<?php

// $delimiter = ",";
// $filename = "sales-data_" , ".csv";

// $file = fopen('php://memory', 'w');

// $fields = array('ITEM ID', 'CATEGORY', 'PRICE', 'QUANTITY SOLD', 'COST', 'TOTAL SALES')
// fputcsv($file, $fields， $delimiter);

// foreach ($products as $item)

// fseek($file, 0);

// header('Content-Type: text/csv');
// header('Content-Disposition: attachment; filename="' . $filename .'";');

// fpassthru($file);

// $fields = array('ITEM ID', 'CATEGORY', 'PRICE', 'QUANTITY SOLD', 'COST', 'TOTAL SALES')

// $data = [];
// foreach ($products as $item) {
//     $row = [
//         $item->product_id,
//         $item->product_category,
//         number_format($item->product_price, 2),
//         $item->product_quantity,
//         number_format($item->product_cost, 2),
//         $item->product_brand,
//     ];
//     $data[] = $row;
// }

// // $data = [['Name', 'Email', 'Phone'], ['John Doe', 'johndoe@example.com', '1234567890'], ['Jane Smith', 'janesmith@example.com', '0987654321']];

// // Create a temporary file path
// $tempFilePath = 'D:/file.csv';

// // Open the temporary file in write mode
// $file = fopen($tempFilePath, 'w');

// // Iterate through the data and write it to the temporary file
// foreach ($data as $row) {
//     fputcsv($file, $row);
// }

// // Close the file
// fclose($file);

// // Set headers to force download
// header('Content-Type: application/csv');
// header('Content-Disposition: attachment; filename="file.csv"');
// header('Pragma: no-cache');
// header('Expires: 0');

// // Send the file to the browser
// readfile($tempFilePath);

// // Delete the temporary file
// unlink($tempFilePath);
?>
