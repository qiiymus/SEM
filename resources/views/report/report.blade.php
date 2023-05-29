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
                top: 0;
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

    <div class="flex flex-col h-full">
        {{-- Title --}}
        <div class="font-extrabold text-xl mt-2">
            Report
        </div>

        {{-- Content --}}

        <div class="flex justify-end w-full mb-5 relative right-0">

            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                        <button
                            class="flex text-sm border-2 border-transparent rounded-full 
                            focus:outline-none focus:border-gray-300 transition">
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                                alt="{{ Auth::user()->name }}" />
                        </button>
                    @else
                        <button
                            class="inline-flex items-center p-2 mx-2 border border-transparent rounded-xl hover:text-gray-600"
                            style="background-color: #00AEA6;">
                            Select Range
                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                    @endif
                </x-slot>

                <x-slot name="content">

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Select Time Range') }}
                    </div>

                    <form action="{{ route('report') }}" method="post">
                        @csrf
                        <!-- Weekly Slot -->
                        <button type="submit" class="w-full">
                            <x-dropdown-link>
                                {{ __('Weekly') }}
                            </x-dropdown-link>
                            <input type="hidden" name="range" value="weekly">
                        </button>
                    </form>
                    
                    <form action="{{ route('report') }}" method="post">
                        @csrf
                        <!-- Monthly Slot -->
                        <button type="submit" class="w-full">
                            <x-dropdown-link>
                                {{ __('Monthly') }}
                            </x-dropdown-link>
                            <input type="hidden" name="range" value="monthly">
                        </button>
                    </form>

                    <form action="{{ route('report') }}" method="post">
                        @csrf
                        <!-- Yearly Slot -->
                        <button type="submit" class="w-full">
                            <x-dropdown-link>
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



            <a href="{{ route('csv') }}" class="p-2 mx-2 border border-transparent rounded-xl hover:text-gray-600"
                style="background-color: #00AEA6;">
                Export .csv
            </a>

            <a href class="p-2 mx-2 border border-transparent rounded-xl hover:text-gray-600"
                style="background-color: #00AEA6;" onclick="printPage()">
                Export .pdf
            </a>
        </div>

        <div id="printable-section1"class="flex flex-col bg-white border border-slate-300 rounded-xl px-5 py-3 gap-y-11 mt-10"
            style="min-height: 60%; max-height:  80%;">

            <div class="flex justify-between">
                <div class="font-bold text-lg">
                    Sales Overview
                </div>
                <div class="font-bold text-lg">
                    {{ $currentDate }}
                </div>
            </div>

            <div>
                <html>

                <head>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                        // var productDataUrl = '{{ route('report.barchart') }}';
                        // var productDataUrlMonthly = '{{ route('report.monthlySlot') }}';
                        // var productDataUrlYearly = '{{ route('report.yearlySlot') }}';
                        // var productDataUrlWeekly = '{{ route('report.data', 'weekly') }}';
                        // var productDataUrlMonthly = '{{ route('report.data', 'monthly') }}';
                        // var productDataUrlYearly = '{{ route('report.data', 'yearly') }}';
                        var productDataUrl = '{{ route('report.data', $range) }}';

                        google.charts.load('current', {
                            'packages': ['bar']
                        });
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = new google.visualization.DataTable();
                            data.addColumn('string', 'Time');

                            var options = {
                                chart: {
                                    title: 'PETAKOM Mart System',
                                    subtitle: 'Sales Report of Weekly, Monthly, Yearly',
                                }
                            };

                            function updateChart(range) {

                                var url = range;
                                // var url = '{{ route('report.data', ':range') }}';
                                // url = url.replace(':range', range);

                                $.get(url, function(productData) {
                                    var categories = Object.keys(productData[0]).filter(function(key) {
                                        return key !== 'week';
                                    });

                                    // Clear the existing chart data
                                    data = new google.visualization.DataTable();
                                    data.addColumn('string', 'Time');

                                    // Add columns for each category
                                    categories.forEach(function(category) {
                                        data.addColumn('number', category);
                                    });

                                    // Add rows for each week
                                    productData.forEach(function(timeData) {
                                        var row = [timeData.week];

                                        // Add quantity for each category
                                        categories.forEach(function(category) {
                                            var quantity = parseFloat(timeData[category]);
                                            row.push(quantity);
                                        });

                                        data.addRow(row);
                                    });

                                    var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
                                    chart.draw(data, google.charts.Bar.convertOptions(options));
                                });
                            }

                            updateChart(productDataUrl);
                        }
                    </script>
                </head>

                <body>
                    <div id="columnchart_material">
                    </div>
                </body>

                </html>

            </div>

        </div>

        <div id="printable-section2">
            <div class="font-bold text-lg">
                Product Sales
            </div>
            <div class="bg-white border border-slate-300 rounded-xl w-full p-4 overflow-y-auto h-4/5">
                <table class="table-auto w-full text-center">
                    <thead>
                        <tr>
                            <th class="py-2">ITEM ID</th>
                            <th class="py-2">BRAND</th>
                            <th class="py-2">CATEGORY</th>
                            <th class="py-2">PRICE</th>
                            <th class="py-2">COST</th>
                            <th class="py-2">QUANTITY SOLD</th>
                            <th class="py-2">TOTAL SALES</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $item)
                            <tr class="border-solid border-2 border-[#a1a1aa]">
                                <td class="py-2">{{ $item->product_id }}</td>
                                <td class="py-2">{{ $item->product_brand }}</td>
                                <td class="py-2">{{ $item->product_category }}</td>
                                <td class="py-2">{{ number_format($item->product_price, 2) }}</td>
                                <td class="py-2">{{ number_format($item->product_cost, 2) }}</td>
                                <td class="py-2">{{ $item->total_quantity_sold }}</td>
                                <td class="py-2">{{ number_format($item->profit, 2) }}</td>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>



</x-app-layout>
