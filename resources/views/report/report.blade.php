<x-app-layout>


    {{-- Define printable object --}}
    <style>
        @media print {
            .print:last-child {
                page-break-after: auto;
            }

            html {
                height: auto;
            }

            body *,
            #afterTable,
            div {
                visibility: hidden;
            }

            #printable-section1,
            #printable-section1 * {
                visibility: visible;
                overflow: visible;
            }

            #printable-section1 {
                position: absolute;
                top: 15;
                margin: 0;
                padding: 5;
                right: 0;
                left: 0;
                height: 100%;

                /* max-width: 100%; */

            }

            #barchart {
                /* position: absolute; */
                height: 100%;
                top: 15;
                margin: 0;
                padding: 0;
                right: 0;
                left: 0;

            }

            #buttonP {
                display: none;
            }
        }
    </style>


    <div class="flex flex-col">
        {{-- Title --}}
        <div class="font-extrabold text-xl mt-2">
            Report
        </div>

        {{-- Content --}}

        <div class="flex justify-end w-full mb-5 relative right-0 items-center">

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">

                    <button
                        class="p-2 mx-2 inline-flex items-center border border-transparent rounded-xl hover:text-gray-600"
                        style="background-color: #00AEA6;">
                        Select Range
                        <svg class="ml-2 -mr-0.5 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>

                </x-slot>

                <x-slot name="content">

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Select Time Range') }}
                    </div>

                    <form action="{{ route('report') }}" method="post">
                        @csrf
                        <!-- Weekly Slot -->
                        <button type="submit" class="w-full">
                            <x-dropdown-link id="weeklySelect">
                                {{ __('Weekly') }}
                            </x-dropdown-link>
                            <input type="hidden" name="range" value="weekly">
                        </button>
                    </form>

                    <form action="{{ route('report') }}" method="post">
                        @csrf
                        <!-- Monthly Slot -->
                        <button type="submit" class="w-full">
                            <x-dropdown-link id="monthlySelect">
                                {{ __('Monthly') }}
                            </x-dropdown-link>
                            <input type="hidden" name="range" value="monthly">
                        </button>
                    </form>

                    <form action="{{ route('report') }}" method="post">
                        @csrf
                        <!-- Yearly Slot -->
                        <button type="submit" class="w-full">
                            <x-dropdown-link id="yearlySelect">
                                {{ __('Yearly') }}
                            </x-dropdown-link>
                            <input type="hidden" name="range" value="yearly">
                        </button>
                    </form>

                    <div class="border-t border-[#00AEA6]"></div>
                </x-slot>
            </x-dropdown>

            {{-- Buttons --}}
            {{-- Print dialog --}}
            <script>
                function printPage() {
                    window.print();
                }
            </script>



            <a href="{{ route('csv') }}"
                class="p-2 mx-2 inline-flex items-center border border-transparent rounded-xl hover:text-gray-600"
                style="background-color: #00AEA6;">
                Export .csv
                <img class="ml-1 hover:text-gray-600" src="{{ asset('images/Export CSV.svg') }}"
                    style="min-height: 40%; max-height:  65%;" /></a>

            <a href class="p-2 mx-2 inline-flex items-center border border-transparent rounded-xl hover:text-gray-600"
                style="background-color: #00AEA6;" onclick="printPage()">
                Export .pdf
                <img class="ml-1 hover:text-gray-600" src="{{ asset('images/Export Pdf.svg') }}"
                    style="min-height: 40%; max-height:  65%;" />
            </a>
        </div>

        <div id="printable-section1"class="flex flex-col justify-between bg-white border 
        border-slate-300 rounded-xl px-5 py-3 gap-y-11 mt-10 juj"
            style="min-height: 60%; max-height:  80%;">

            <div class="flex justify-between">
                <div class="font-bold text-lg">
                    Sales Overview
                </div>
                <div class="font-bold text-lg">
                    {{ $currentDate }}
                </div>
            </div>

            <div id="barchart" class="w-full h-full">


                <head>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                        var productDataUrl = '{{ route('report.data', $range) }}';

                        google.charts.load('current', {
                            'packages': ['bar']
                        });
                        google.charts.setOnLoadCallback(drawChart);

                        function updateChart(range) {
                            var url = '{{ route('report.data', ':range') }}';
                            url = url.replace(':range', range);

                            $.get(url, function(productData) {
                                console.log('Product Data:', productData); // Log the productData

                                if (!productData || productData.length === 0) {
                                    // Handle empty or undefined productData
                                    console.error('No data available.');
                                    return;
                                }

                                var categories = Object.keys(productData[0]).filter(function(key) {
                                    return key !== 'week';
                                });

                                var data = new google.visualization.DataTable();
                                data.addColumn('string', 'Time');

                                // Add columns for each category
                                categories.forEach(function(category) {
                                    data.addColumn('number', category);
                                });

                                // Add rows for each time period
                                productData.forEach(function(timeData) {
                                    var timeLabel = '';

                                    if (range === 'weekly') {
                                        timeLabel = timeData.week;
                                    } else if (range === 'monthly') {
                                        timeLabel = timeData.month;
                                    } else if (range === 'yearly') {
                                        timeLabel = timeData.year;
                                    }
                                    var row = [timeLabel];

                                    // Add quantity for each category
                                    categories.forEach(function(category) {
                                        var quantity = parseFloat(timeData[category]);
                                        row.push(quantity);
                                    });

                                    data.addRow(row);
                                });

                                var options = {
                                    chart: {
                                        title: 'PETAKOM Mart System',
                                        subtitle: 'Sales Report of Weekly, Monthly, Yearly',
                                    }
                                };

                                var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
                                chart.draw(data, google.charts.Bar.convertOptions(options));
                            }).fail(function() {
                                console.error('Failed to retrieve data.');
                            });
                        }

                        function drawChart() {
                            // Add an event listener to the range dropdown
                            $('#weeklySelect, #monthlySelect, #yearlySelect').on('click', function() {
                                event.preventDefault();

                                var selectedRange = $(this).siblings('input[name="range"]').val();
                                updateChart(selectedRange);
                            });

                            // Load the default chart using the initial range
                            var initialRange = $('#weeklySelect').siblings('input[name="range"]').val();
                            updateChart(initialRange);
                        }
                    </script>
                </head>

                <div id="columnchart_material" class="w-full h-full p">
                </div>


            </div>

        </div>


        <div id="printable-section2" class="mb-5">
            <div class="font-bold text-lg my-2">
                Product Sales
            </div>
            <div class="bg-white border border-slate-300 rounded-xl w-full px-4 overflow-y-auto h-4/5 max-h-80 mb-5">
                <table class="table-auto w-full text-center">
                    <thead class="sticky top-0 bg-white">
                        <tr>
                            <th class="py-4">ITEM ID</th>
                            <th class="py-4">BRAND</th>
                            <th class="py-4">CATEGORY</th>
                            <th class="py-4">PRICE</th>
                            <th class="py-4">COST</th>
                            <th class="py-4">QUANTITY SOLD</th>
                            <th class="py-4">TOTAL SALES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($carts as $cart)
                            <tr class="bg-gray-200 border-y-8 border-white">
                                <td class="py-2">{{ $cart->product_id }}</td>
                                <td class="py-2">{{ $cart->product_name }}</td>
                                <td class="py-2">{{ $cart->product_category }}</td>
                                <td class="py-2">{{ number_format($cart->product_price, 2) }}</td>
                                <td class="py-2">{{ number_format($cart->product_cost, 2) }}</td>
                                <td class="py-2">{{ $cart->quantity }}</td>
                                <td class="py-2">{{ number_format($cart->profit, 2) }}</td>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>



</x-app-layout>
