<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Barcode Generator</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|inter:400,500,600" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .card {
                transition: all 0.3s ease;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            }
            .card:hover {
                box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
                transform: translateY(-2px);
            }
            .btn-primary {
                transition: all 0.2s ease;
            }
            .btn-primary:hover {
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .select-custom {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
                background-position: right 0.5rem center;
                background-repeat: no-repeat;
                background-size: 1.5em 1.5em;
                appearance: none;
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-200 font-inter flex items-center justify-center min-h-screen p-4">
        <div class="max-w-4xl w-full space-y-6">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Barcode Generator</h1>
            </div>

            <!-- Barcode Display -->
            <div class="card bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col items-center">
                <div class="bg-white p-4 rounded-lg mb-4">
                    <img src="{{ asset('path/to/default-barcode.png') }}" alt="Default Barcode" class="h-24 w-auto">
                </div>
                <span class="text-xl font-mono font-semibold bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-md">123456789012</span>
            </div>

            <!-- Form Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Item Selection -->
                <div class="card bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Item Selection</h2>
                    <select class="select-custom w-full mb-4 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        <option value="" disabled selected>Select Item</option>
                        <option value="item1">Item 1</option>
                        <option value="item2">Item 2</option>
                        <option value="item3">Item 3</option>
                    </select>
                    <button
                        class="btn-primary w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium"
                        onclick="openAddItemModal()">
                        <span class="flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add New Item
                        </span>
                    </button>
                </div>

                <!-- Buyer Selection -->
                <div class="card bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Buyer Selection</h2>
                    <select class="select-custom w-full mb-4 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                        <option value="" disabled selected>Select Buyer</option>
                        <option value="item1">Buyer 1</option>
                        <option value="item2">Buyer 2</option>
                        <option value="item3">Buyer 3</option>
                    </select>
                    <button
                        class="btn-primary w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium"
                        onclick="openAddBuyerModal()">
                        <span class="flex items-center justify-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add New Buyer
                        </span>
                    </button>
                </div>
            </div>

            <!-- Line Selection -->
            <div class="card bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Line Configuration</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Origin Line</label>
                        <select class="select-custom w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="" disabled selected>Select Origin Line</option>
                            <option value="item1">Line 1</option>
                            <option value="item2">Line 2</option>
                            <option value="item3">Line 3</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Code</label>
                        <select class="select-custom w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="" disabled selected>Select Code</option>
                            <option value="item1">Code 1</option>
                            <option value="item2">Code 2</option>
                            <option value="item3">Code 3</option>
                        </select>
                    </div>
                </div>
                <button
                    class="btn-primary w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium"
                    onclick="openAddLineModal()">
                    <span class="flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add New Line
                    </span>
                </button>
            </div>

            <!-- Generate Button -->
            <button class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold text-lg shadow-md transition-all duration-200 transform hover:scale-[1.01]">
                Generate Barcode
            </button>
        </div>
    </body>
</html>
