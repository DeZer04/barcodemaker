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

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://kit.fontawesome.com/5ac6c6fc32.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>



    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .select-custom {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            appearance: none;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br  from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-200 font-inter flex items-center justify-center min-h-screen p-4">
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header -->
        <div class="text-center">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Barcode Generator</h1>
            <p class="text-gray-600 dark:text-gray-400">Create and manage product barcodes efficiently</p>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Item Selection Card -->
                <div
                    class="card bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Item Selection</h2>
                        <div class="flex space-x-2">
                            <button onclick="openModal('AddItemModal')"
                                class="p-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button onclick="openModal('ManageItemModal')"
                                class="p-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fa-solid fa-list"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select
                                Item</label>
                            <select id="itemSelect" onchange="updateItem()"
                                class="w-full px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                <option value="" disabled selected>Choose an item...</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->namaitem }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Line Configuration Card -->
                <div
                    class="card bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Line Configuration</h2>
                        <div class="flex space-x-2">
                            <button onclick="openModal('AddLineModal')"
                                class="p-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            <button onclick="openModal('LineManageModal')"
                                class="p-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                                <i class="fa-solid fa-industry"></i>
                            </button>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Select
                                Line</label>
                            <div class="grid grid-cols-5 gap-2">
                                @foreach (range('A', 'Z') as $letter)
                                    <button type="button"
                                        class="letter-button px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 border border-gray-200 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
                                        data-letter="{{ $letter }}" onclick="selectLetter(this)">
                                        {{ $letter }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Buyer/Purchase/Container Card -->
                <div
                    class="card bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Order Information</h2>

                    <div class="space-y-4">
                        <!-- Buyer Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buyer</label>
                            <div class="flex space-x-2">
                                <select id="buyerSelect"
                                    onchange="updateBuyer(); filterPurchases(); filterContainers();"
                                    class="flex-1 px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="" disabled selected>Select buyer...</option>
                                    @foreach ($buyers as $buyer)
                                        <option value="{{ $buyer->id }}">{{ $buyer->name }}</option>
                                    @endforeach
                                </select>
                                <button onclick="openModal('AddBuyerModal')"
                                    class="px-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Purchase Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Purchase
                                Order</label>
                            <div class="flex space-x-2">
                                <select id="purchaseSelect" onchange="updatePurchase()"
                                    class="flex-1 px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="" disabled selected>Select purchase order...</option>
                                    @foreach ($purchases as $purchase)
                                        <option value="{{ $purchase->id }}" data-buyer-id="{{ $purchase->buyer_id }}">
                                            {{ $purchase->purchaseindex }}</option>
                                    @endforeach
                                </select>
                                <button onclick="openModal('AddPurchasesModal')"
                                    class="px-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Container Selection -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Container</label>
                            <div class="flex space-x-2">
                                <select id="containerSelect" onchange="updateContainer()"
                                    class="flex-1 px-4 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                                    <option value="" disabled selected>Select container...</option>
                                    @foreach ($containers as $container)
                                        <option value="{{ $container->id }}"
                                            data-buyer-id="{{ $container->buyer_id }}">
                                            {{ $container->containerindex }}</option>
                                    @endforeach
                                </select>
                                <button onclick="openModal('AddContainerModal')"
                                    class="px-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Barcode Display Card -->
                <div
                    class="card bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Barcode Preview</h2>
                        <button onclick="printBarcode()"
                            class="text-sm bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                            <i class="fa-solid fa-print mr-2"></i> Print
                        </button>
                    </div>

                    <div class="space-y-4">
                        <!-- Barcode Image -->
                        <div
                            class="bg-white dark:bg-gray-700 p-4 rounded-lg border border-gray-200 dark:border-gray-600 flex justify-center">
                            <img id="barcodeImage" src="{{ asset('path/to/default-barcode.png') }}"
                                alt="Generated Barcode" class="h-32 w-auto">
                        </div>

                        <!-- Barcode Text -->
                        <div id="barcodeText"
                            class="text-center font-mono text-xl font-semibold bg-gray-100 dark:bg-gray-700 px-4 py-3 rounded-lg hidden">
                            0000.0.00.00.000
                        </div>

                        <!-- Search Barcode -->
                        <div class="flex space-x-2">
                            <input type="text" id="searchBarcodeInput"
                                placeholder="Search barcode (e.g. 0000.0.00.00.000)"
                                class="flex-1 px-4 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200">
                            <button onclick="searchBarcode()"
                                class="px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                                <i class="fa-solid fa-search"></i>
                            </button>
                        </div>

                        <!-- Results Area -->
                        <div id="resultArea"
                            class="text-sm text-gray-600 dark:text-gray-400 p-2 rounded bg-gray-50 dark:bg-gray-700/50">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Generate Button -->
        <div class="pt-2">
            <button onclick="generateBarcode()"
                class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-6 py-3.5 rounded-xl font-semibold text-lg shadow-md transition-all duration-200 transform hover:scale-[1.01] active:scale-95">
                Generate Barcode
            </button>
        </div>
    </div>

    <!-- Modal for show line -->
    <div id="LineManageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button onclick="closeModal('LineManageModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fa-solid fa-x"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Manage Line</h3>
            <table class="w-full text-sm text-left text-gray-700 dark:text-gray-200 border">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-3 py-2 border">#</th>
                        <th class="px-3 py-2 border">Nama Line</th>
                        <th class="px-3 py-2 border">Kode Line</th>
                        <th class="px-3 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="lineTableBody">
                    @foreach ($origins as $index => $line)
                        <tr>
                            <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-3 py-2 border" id="lineName-{{ $line->id }}">{{ $line->name_origin }}
                            </td>
                            <td class="px-3 py-2 border">
                                @php
                                    $kode = $line->kode_origin;
                                    if (is_string($kode)) {
                                        $parsed = json_decode($kode, true);
                                        if (json_last_error() === JSON_ERROR_NONE && is_array($parsed)) {
                                            echo implode('/', $parsed);
                                        } else {
                                            echo e($kode);
                                        }
                                    } elseif (is_array($kode)) {
                                        echo implode('/', $kode);
                                    } else {
                                        echo e((string) $kode);
                                    }
                                @endphp
                            </td>
                            <td class="px-3 py-2 border text-center">
                                <button class="text-red-600 hover:underline"
                                    onclick="deleteLine({{ $line->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Managing Item -->
    <div class="fixed inset-0 z-50 flex w-full items-center justify-center bg-black/40 hidden" id="ManageItemModal">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-2xl p-6 relative">
            <button onclick="closeModal('ManageItemModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fa-solid fa-x"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Manage Item</h3>
            <!-- Search Input -->
            <div class="mb-4">
                <input type="text" id="searchItemInput" onkeyup="searchItemTable()"
                    placeholder="Search item name..."
                    class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200">
            </div>
            <table class="w-l text-sm text-left text-gray-700 dark:text-gray-200 border">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                    <tr>
                        <th class="px-3 py-2 border">#</th>
                        <th class="px-3 py-2 border">Nama Item</th>
                        <th class="px-3 py-2 border text-center">Jenis Kayu</th>
                        <th class="px-3 py-2 border text-center">Grade Kayu</th>
                        <th class="px-3 py-2 border text-center">Finishing</th>
                        <th class="px-3 py-2 border text-center">Jenis Anyam</th>
                        <th class="px-3 py-2 border text-center">Warna Anyam</th>
                        <th class="px-3 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="manageItemTableBody">
                    @foreach ($items as $index => $item)
                        <tr>
                            <td class="px-3 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-3 py-2 border" id="itemName-{{ $item->id }}">{{ $item->name_item }}
                            </td>
                            <td class="px-3 py-2 border text-center" id="itemJenisKayu-{{ $item->id }}">
                                {{ $item->jeniskayu->name_jeniskayu ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border text-center" id="itemGrade-{{ $item->id }}">
                                {{ $item->grade->name_grade ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border text-center" id="itemFinishing-{{ $item->id }}">
                                {{ $item->finishing->name_finishing ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border text-center" id="itemJenisAnyam-{{ $item->id }}">
                                {{ $item->jenisanyam->name_jenisanyam ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border text-center" id="itemWarnaAnyam-{{ $item->id }}">
                                {{ $item->warnaanyam->name_warnaanyam ?? '-' }}
                            </td>
                            <td class="px-3 py-2 border text-center">
                                <button class="text-red-600 hover:underline"
                                    onclick="deleteItem({{ $item->id }})">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding New Buyer -->
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden" id="AddBuyerModal">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button onclick="closeModal('AddBuyerModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fa-solid fa-x"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Add New Buyer</h3>
            <form id="addBuyerForm" class="space-y-4" method="POST" action="{{ route('barcode.buyers.store') }}">
                @csrf
                <div>
                    <label for="name"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buyer Name</label>
                    <input type="text" id="name" name="name"
                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        placeholder="Enter buyer name" required>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('AddBuyerModal')"
                        class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Adding New Purchases -->
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden" id="AddPurchasesModal">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button onclick="closeModal('AddPurchasesModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fa-solid fa-x"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Add New Purchases</h3>
            <form id="addPurchasesForm" class="space-y-4" method="POST"
                action="{{ route('barcode.purchases.store') }}">
                @csrf
                <div>
                    <label for="buyer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nam
                        Buyer</label>
                    <select
                        class="select-custom w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        id="buyer_id" name="buyer_id" required>
                        <option value="" disabled selected>Select Buyer</option>
                        @foreach ($buyers as $buyer)
                            <option value="{{ $buyer->id }}">{{ $buyer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="purchaseindex"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Purchases Name</label>
                    <input type="text" id="purchaseindex" name="purchaseindex"
                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        placeholder="Enter purchases name" required>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('AddPurchasesModal')"
                        class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Adding New Container -->
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden" id="AddContainerModal">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button onclick="closeModal('AddContainerModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fa-solid fa-x"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Add New Container</h3>
            <form id="addContainerForm" class="space-y-4" method="POST"
                action="{{ route('barcode.containers.store') }}">
                @csrf
                <div>
                    <label for="buyer_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nam
                        Buyer</label>
                    <select
                        class="select-custom w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        id="buyer_id" name="buyer_id" required>
                        <option value="" disabled selected>Select Buyer</option>
                        @foreach ($buyers as $buyer)
                            <option value="{{ $buyer->id }}">{{ $buyer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="containerindex"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Container Name</label>
                    <input type="text" id="containerindex" name="containerindex"
                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        placeholder="Enter container name" required>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('AddContainerModal')"
                        class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Adding New Line -->
    <div id="AddLineModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <form class="bg-white rounded-lg w-full max-w-md p-6" method="POST"
            action="{{ route('barcode.origins.store') }}">
            @csrf
            <div class="mb-4">
                <h2 class="text-xl font-semibold mb-2">Add Origin Line</h2>
                <label for="name_origin" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" id="name_origin" name="name_origin"
                    class="w-full mt-1 border rounded px-3 py-2" />
            </div>

            <div class="placeholder">Letter: </div>
            <input type="hidden" name="letters" id="lettersInput">

            <div class="mb-4">
                <p class="text-sm font-medium text-gray-700 mb-2">Choose up to 3 Letters:</p>
                <div class="grid grid-cols-8 gap-1 max-h-40 overflow-y-auto" id="letter-container">
                    @foreach (range('A', 'Z') as $letter)
                        <button type="button"
                            class="letter-button text-black focus:bg-blue-600 focus:text-white hover:bg-blue-600 hover:text-white px-2 py-1 bg-white border border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                            data-letter="{{ $letter }}" onclick="toggleLetter(this)">
                            {{ $letter }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <button onclick="closeModal('AddLineModal')"
                    class="px-4 py-2 border rounded text-gray-600">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            </div>
        </form>
    </div>

    <!-- Modal for Adding New Item -->
    <div id="AddItemModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-2xl p-6 relative">
            <button onclick="closeModal('AddItemModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fa-solid fa-x"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Add New Item</h3>
            <form id="addItemForm" class="space-y-4 grid grid-cols-2 gap-4" method="POST"
                action="{{ route('barcode.items.store') }}">
                @csrf
                <div class="">
                    <label for="name_item"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Item Name</label>
                    <input type="text" id="name_item" name="name_item"
                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        placeholder="Enter item name" required>
                </div>
                <div class="flex flex-row gap-2 items-end">
                    <div class="flex-1">
                        <label for="jeniskayu_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kayu</label>
                        <select
                            class="select-custom w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                            id="jeniskayu_id" name="jeniskayu_id" required>
                            <option value="" disabled selected>Select Jenis Kayu</option>
                            @foreach ($jeniskayus as $jeniskayu)
                                <option value="{{ $jeniskayu->id }}">{{ $jeniskayu->name_jeniskayu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button"
                        class="btn-primary h-10 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center justify-center transition-colors duration-200"
                        onclick="openModal('AddJenisKayuModal')" title="Add Jenis Kayu">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <div class="flex flex-row gap-2 items-end">
                    <div class="flex-1">
                        <label for="grade_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Item Grade</label>
                        <select
                            class="select-custom w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                            id="grade_id" name="grade_id" required>
                            <option value="" disabled selected>Select Item Grade</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->id }}">{{ $grade->name_grade }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button"
                        class="btn-primary h-10 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center justify-center transition-colors duration-200"
                        onclick="openModal('AddGradeModal')" title="Add Grade">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>

                <div class="flex flex-row gap-2 items-end">
                    <div class="flex-1">
                        <label for="finishing_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Finishing</label>
                        <select
                            class="select-custom w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                            id="finishing_id" name="finishing_id" required>
                            <option value="" disabled selected>Select Finishing</option>
                            @foreach ($finishings as $finishing)
                                <option value="{{ $finishing->id }}">{{ $finishing->name_finishing }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button"
                        class="btn-primary h-10 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center justify-center transition-colors duration-200"
                        onclick="openModal('AddFinishingModal')" title="Add Finishing">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <div class="flex flex-row gap-2 items-end">
                    <div class="flex-1">
                        <label for="jenisanyam_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Anyam</label>
                        <!-- Dropdown Jenis Anyam -->
                        <select
                            class="select-custom w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                            id="jenisanyam_id" name="jenisanyam_id" onchange="filterWarnaAnyam(this);">
                            <option value="" disabled selected>Pilih Jenis Anyam</option>
                            @foreach ($jenisanyams as $jenisanyam)
                                <option value="{{ $jenisanyam->id }}">{{ $jenisanyam->name_jenisanyam }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button"
                        class="btn-primary h-10 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center justify-center transition-colors duration-200"
                        onclick="openModal('AddJenisAnyamModal')">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>

                <div class="flex flex-row gap-2 items-end">
                    <div class="flex-1">
                        <label for="warnaanyam_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Warna Anyam</label>
                        <select
                            class="select-custom w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                            id="warnaanyam_id" name="warnaanyam_id">
                            <option value="" disabled selected>Pilih Warna Anyam</option>
                            @foreach ($warnaanyams as $warnaanyam)
                                <option value="{{ $warnaanyam->id }}"
                                    data-jenisanyam-id="{{ $warnaanyam->jenisanyam_id }}">
                                    {{ $warnaanyam->name_warnaanyam }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="button"
                        class="btn-primary h-10 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center justify-center transition-colors duration-200"
                        onclick="openModal('AddWarnaAnyamModal')" title="Add Warna Anyam">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <div class="flex justify-end gap-2 pt-2 col-span-2">
                    <button type="button" onclick="closeModal('AddItemModal')"
                        class="px-4 py-2 rounded-lg bg-red-500 dark:bg-gray-700 text-white dark:text-white hover:bg-red-600 dark:hover:bg-gray-600 transition-colors duration-200">
                        Close
                    </button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200">
                        <i class="fa-solid fa-floppy-disk"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Adding New Jenis Kayu -->
    <div id="AddJenisKayuModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button onclick="closeModal('AddJenisKayuModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fa-solid fa-x"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Add New Jenis Kayu</h3>
            <form id="addJenisKayuForm" class="space-y-4" method="POST"
                action="{{ route('barcode.jeniskayus.store') }}">
                @csrf
                <div>
                    <label for="name_jeniskayu"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Kayu Name</label>
                    <input type="text" id="name_jeniskayu" name="name_jeniskayu"
                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        placeholder="Enter jenis kayu name" required>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('AddJenisKayuModal')"
                        class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Adding New Jenis Anyam -->
    <div id="AddJenisAnyamModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button onclick="closeModal('AddJenisAnyamModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fa-solid fa-x"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">
                Add New Jenis Anyam
            </h3>
            <form id="addJenisAnyamForm" class="space-y-4" method="POST"
                action="{{ route('barcode.jenisanyams.store') }}">
                @csrf
                <div>
                    <label for="name_jenisanyam"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Anyam
                        Name</label>
                    <input type="text" id="name_jenisanyam" name="name_jenisanyam"
                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        placeholder="Enter jenis anyam name" required>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('AddJenisAnyamModal')"
                        class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Adding New Warna Anyam -->
    <div id="AddWarnaAnyamModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button onclick="closeModal('AddWarnaAnyamModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fa-solid fa-x"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Add New Warna Anyam</h3>
            <form id="addWarnaAnyamForm" class="space-y-4" method="POST"
                action="{{ route('barcode.warnaanyams.store') }}">
                @csrf
                <div>
                    <label for="jenisanyam_id"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jenis Anyam</label>
                    <select
                        class="select-custom w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        id="jenisanyam_id" name="jenisanyam_id" required>
                        <option value="" disabled selected>Select Jenis Anyam</option>
                        @foreach ($jenisanyams as $jenisanyam)
                            <option value="{{ $jenisanyam->id }}">{{ $jenisanyam->name_jenisanyam }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="name_warnaanyam"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Warna Anyam
                        Name</label>
                    <input type="text" id="name_warnaanyam" name="name_warnaanyam"
                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        placeholder="Enter warna anyam name" required>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('AddWarnaAnyamModal')"
                        class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200">Save</button>
                </div>
            </form>
            <div class="my-4 border-t border-gray-300 dark:border-gray-600"></div>
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Warna Anyam List</h3>
            <ul id="warnaanyamList" class="space-y-2">
                @foreach ($warnaanyams as $warnaanyam)
                    <li class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-2 rounded-lg"
                        data-id="{{ $warnaanyam->id }}">
                        <span>
                            {{ $warnaanyam->name_warnaanyam }}
                            <span class="text-xs text-gray-500 ml-2">
                                (@php
                                    $jenis = $jenisanyams->firstWhere('id', $warnaanyam->jenisanyam_id);
                                @endphp
                                {{ $jenis ? $jenis->name_jenisanyam : 'Unknown' }})
                            </span>
                        </span>
                        <button type="button" onclick="deleteWarnaAnyam('{{ $warnaanyam->id }}')"
                            class="text-red-600 hover:text-red-800 transition-colors duration-200">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Modal for Adding New Finishing -->
    <div id="AddFinishingModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button onclick="closeModal('AddFinishingModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fa-solid fa-x"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Add New Finishing</h3>
            <form id="addFinishingForm" class="space-y-4" method="POST"
                action="{{ route('barcode.finishings.store') }}">
                @csrf
                <div>
                    <label for="name_finishing"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Finishing Name</label>
                    <input type="text" id="name_finishing" name="name_finishing"
                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        placeholder="Enter finishing name" required>
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('AddFinishingModal')"
                        class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200">Save</button>
                </div>
            </form>
            <div class="my-4 border-t border-gray-300 dark:border-gray-600"></div>
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Finishing List</h3>
            <ul id="finishingList" class="space-y-2">
                @foreach ($finishings as $finishing)
                    <li class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-2 rounded-lg"
                        data-id="{{ $finishing->id }}">
                        <span>{{ $finishing->name_finishing }}</span>
                        <button type="button" onclick="deleteFinishing('{{ $finishing->id }}')"
                            class="text-red-600 hover:text-red-800 transition-colors duration-200">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Modal for Adding New Grade -->
    <div id="AddGradeModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-md p-6 relative">
            <button onclick="closeModal('AddGradeModal')"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors duration-200">
                <i class="fa-solid fa-x"></i>
            </button>
            <h3 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">Add New Grade</h3>
            <form id="addGradeForm" class="space-y-0 flex items-center gap-2 w-full" method="POST"
                action="{{ route('barcode.grades.store') }}">
                @csrf
                <div class="flex-1">
                    <input type="text" id="name_grade" name="name_grade"
                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        placeholder="Enter grade name" required>
                </div>
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200 flex items-center justify-center">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Save
                </button>
            </form>
            <div class="my-4 border-t border-gray-300 dark:border-gray-600"></div>
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Grade List</h3>
            <ul id="gradeList" class="space-y-2">
                @foreach ($grades as $grade)
                    <li class="flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-2 rounded-lg"
                        data-id="{{ $grade->id }}">
                        <span class="ml-4">{{ $grade->name_grade }}</span>
                        <button type="button" onclick="deleteGrade('{{ $grade->id }}')"
                            class="text-red-600 hover:text-red-800 transition-colors duration-200">
                            <i class="fa-solid fa-trash mr-4"></i>
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="flex flex-row justify-end mt-5">
                <button type="button" onclick="closeModal('AddGradeModal')"
                    class="px-4 py-2 rounded-lg bg-red-500 dark:bg-red-700 text-white dark:text-white hover:bg-red-600 dark:hover:bg-red-400 transition-colors duration-200">
                    Cancel
                </button>
            </div>
        </div>

    </div>

    <div id="SuccessModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-sm p-6 relative text-center">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white" id="successModalMessage"></h3>
            <button onclick="closeModal('SuccessModal')"
                class="mt-4 px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition-colors duration-200">
                OK
            </button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#itemSelect').select2({
                placeholder: "Select Item",
                allowClear: true,
                height: 100,
            });
        });

        function searchBarcode() {
            const input = document.getElementById('searchBarcodeInput');
            const barcodeText = input.value.trim();
            if (!barcodeText) {
                alert('Masukkan kode barcode yang ingin dicari!');
                return;
            }

            fetch(`/barcode/reverse-search?barcode=${barcodeText}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    // Tampilkan data hasil reverse search
                    let resultHTML = `
                            <p><strong>Item:</strong> ${data.item?.name_item || '-'}</p>
                            <p><strong>Origin:</strong> ${data.origin?.name_origin || '-'}</p>
                            <p><strong>Buyer:</strong> ${data.buyer?.name || '-'}</p>
                            <p><strong>Purchase Index:</strong> ${data.purchase?.purchaseindex || '-'}</p>
                            <p><strong>Container Index:</strong> ${data.container?.containerindex || '-'}</p>
                        `;
                    document.getElementById('resultArea').innerHTML = resultHTML;

                    // Opsional: tampilkan juga barcode-nya
                    document.getElementById('barcodeText').textContent = barcodeText;
                    generateBarcode();
                })
                .catch(err => {
                    console.error(err);
                    alert('Terjadi kesalahan saat mencari barcode.');
                });
        }

        function generateBarcode() {
            const barcodeTextSpan = document.getElementById('barcodeText');
            const rawCode = barcodeTextSpan.textContent.trim();
            const code = rawCode.replace(/\./g, ''); // Hilangkan titik

            // Buat elemen SVG sementara
            const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");

            // Buat barcode ke SVG
            JsBarcode(svg, code, {
                format: "CODE128",
                displayValue: true,
                fontSize: 25,
                height: 80
            });

            // Convert SVG ke image base64 dan tampilkan
            const serializer = new XMLSerializer();
            const svgString = serializer.serializeToString(svg);
            const encodedData = 'data:image/svg+xml;base64,' + btoa(svgString);

            const img = document.getElementById('barcodeImage');
            img.src = encodedData;
        }

        // Generate barcode saat halaman pertama kali terbuka
        document.addEventListener('DOMContentLoaded', function() {
            generateBarcode();
        });

        function printBarcode() {
            const barcodeImg = document.getElementById('barcodeImage');
            const printWindow = window.open('', '_blank', 'width=500,height=300');
            printWindow.document.write(`
            <html>
            <head>
                <title>Print Barcode</title>
                <style>
                @media print {
                    html, body { margin: 0 !important; padding: 0 !important; }
                    body { width: 100vw; height: 100vh; }
                }
                html, body {
                    margin: 0 !important;
                    padding: 0 !important;
                    width: 100vw;
                    height: 100vh;
                }
                body {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    height: 100vh;
                    width: 100vw;
                    background: #fff;
                }
                .barcode-img {
                    height: 2cm;
                    width: 5cm;
                    object-fit: contain;
                    display: block;
                }
                </style>
            </head>
            <body>
                <img src="${barcodeImg.src}" class="barcode-img" />
                <script>
                window.onload = function() { window.print(); window.close(); }
                <\/script>
            </body>
            </html>
            `);
            printWindow.document.close();
        }

        function searchItemTable() {
            var input = document.getElementById("searchItemInput");
            var filter = input.value.toLowerCase();
            var table = document.getElementById("manageItemTableBody");
            var tr = table.getElementsByTagName("tr");
            for (var i = 0; i < tr.length; i++) {
                var td = tr[i].getElementsByTagName("td")[1]; // Nama Item column
                if (td) {
                    var txtValue = td.textContent || td.innerText;
                    tr[i].style.display = txtValue.toLowerCase().indexOf(filter) > -1 ? "" : "none";
                }
            }
        }

        let selectedLetters = [];

        function toggleLetter(btn) {
            const letter = btn.dataset.letter;
            const index = selectedLetters.indexOf(letter);

            if (index > -1) {
                selectedLetters.splice(index, 1);
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-white', 'text-black');
            } else if (selectedLetters.length < 3) {
                selectedLetters.push(letter);
                btn.classList.remove('bg-white', 'text-black');
                btn.classList.add('bg-blue-600', 'text-white');
            } else {
                showModalMessage('You can only select up to 3 letters.');
            }

            // Update the Letter: ... placeholder with separator
            const placeholderDiv = document.querySelector('.placeholder');
            if (placeholderDiv) {
                placeholderDiv.textContent = selectedLetters.length ?
                    'Letter: ' + selectedLetters.join('/') :
                    'Letter: /';
            }

            // Update hidden input
            document.getElementById('lettersInput').value = selectedLetters.join(',');
        }

        // form line handling
        document.getElementById('addLineForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || "Failed to add line");
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Add to select dropdown
                    const lineSelect = document.getElementById('lineSelect');
                    const newOption = document.createElement('option');
                    newOption.value = data.id;
                    newOption.textContent = data.name;
                    lineSelect.appendChild(newOption);

                    // Reset form and close modal
                    form.reset();
                    closeModal('AddLineModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while adding the line');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalButtonText;
                });
        });

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        };

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        };

        function updateBarcodePart(index, value, length) {
            const barcodeSpan = document.getElementById('barcodeText');
            let parts = barcodeSpan.textContent.trim().split('.');

            // Pastikan array cukup panjang
            while (parts.length < 5) parts.push('00');

            parts[index] = value.toString().padStart(length, '0');
            barcodeSpan.textContent = parts.join('.');
        }

        function updateItem() {
            const itemSelect = document.getElementById('itemSelect');
            const itemId = itemSelect.value;
            if (itemId) updateBarcodePart(0, itemId, 4); // item di index ke-0
        }

        function updateBuyer() {
            const buyerSelect = document.getElementById('buyerSelect');
            const buyerId = buyerSelect.value;
            if (buyerId) updateBarcodePart(2, buyerId, 2); // buyer di index ke-2
        }

        function selectLetter(button) {
            const selectedLetter = button.getAttribute('data-letter');
            updateBarcodePart(1, selectedLetter, 1); // index ke-1 adalah bagian 'line'
        }

        function updatePurchase() {
            const purchaseSelect = document.getElementById('purchaseSelect');
            const selectedOption = purchaseSelect.options[purchaseSelect.selectedIndex];
            const purchaseIndex = selectedOption.textContent.trim(); // This is the displayed text (purchaseindex)

            if (purchaseIndex) updateBarcodePart(3, purchaseIndex, 2); // index 3 for purchase
        }

        function updateContainer() {
            const containerSelect = document.getElementById('containerSelect');
            const selectedOption = containerSelect.options[containerSelect.selectedIndex];
            const containerIndex = selectedOption.textContent.trim(); // This is the displayed text (containerindex)

            if (containerIndex) updateBarcodePart(4, containerIndex, 2); // index 4 for container
        }

        function filterPurchases() {
            const buyerSelect = document.getElementById('buyerSelect');
            const selectedBuyerId = buyerSelect.value;
            const purchaseSelect = document.getElementById('purchaseSelect');

            // Reset pilihan Purchase ke default
            purchaseSelect.value = "";

            // Tampilkan semua opsi dulu
            Array.from(purchaseSelect.options).forEach(option => {
                if (option.value === "") {
                    option.hidden = false; // Biarkan placeholder terlihat
                } else {
                    option.hidden = true; // Sembunyikan dulu semua
                }
            });

            // Tampilkan hanya opsi Purchase dengan buyer_id yang sesuai
            Array.from(purchaseSelect.options).forEach(option => {
                if (option.dataset.buyerId === selectedBuyerId) {
                    option.hidden = false;
                }
            });
        }

        function filterContainers() {
            const buyerSelect = document.getElementById('buyerSelect');
            const containerSelect = document.getElementById('containerSelect');
            const selectedBuyerId = buyerSelect.value;

            // Reset selected value
            containerSelect.value = "";

            // Tampilkan semua opsi dahulu
            Array.from(containerSelect.options).forEach(option => {
                const buyerId = option.getAttribute('data-buyer-id');

                if (!buyerId || buyerId === selectedBuyerId) {
                    option.hidden = false;
                } else {
                    option.hidden = true;
                }
            });
        }

        // Buyer Form Handling
        document.getElementById('addBuyerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || "Failed to add buyer");
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Add to select dropdown
                    const buyerSelect = document.getElementById('buyerSelect');
                    const newOption = document.createElement('option');
                    newOption.value = data.id;
                    newOption.textContent = data.name;
                    newOption.selected = true;
                    buyerSelect.appendChild(newOption);

                    // Reset form and close modal
                    form.reset();
                    closeModal('AddBuyerModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while adding the buyer');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalButtonText;
                });
        });

        // Purchases Form Handling
        document.getElementById('addPurchasesForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || "Failed to add purchases");
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Add to select dropdown
                    const purchaseSelect = document.getElementById('purchaseSelect');
                    const newOption = document.createElement('option');
                    newOption.value = data.id;
                    newOption.textContent = data.purchaseindex;
                    newOption.dataset.buyerId = data.buyer_id; // Set buyer_id as a data attribute
                    newOption.selected = true;
                    purchaseSelect.appendChild(newOption);

                    // Reset form and close modal
                    form.reset();
                    closeModal('AddPurchasesModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while adding the purchases');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalButtonText;
                });
        });

        // Container Form Handling
        document.getElementById('addContainerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || "Failed to add container");
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Add to select dropdown
                    const containerSelect = document.getElementById('container_id');
                    const newOption = document.createElement('option');
                    newOption.value = data.id;
                    newOption.textContent = data.name_container;
                    newOption.selected = true;
                    containerSelect.appendChild(newOption);

                    // Reset form and close modal
                    form.reset();
                    closeModal('AddContainerModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while adding the container');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalButtonText;
                });
        });

        // Warna Anyam Form Handling
        document.getElementById('addWarnaAnyamForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || "Failed to add warna anyam");
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Add to select dropdown
                    const warnaAnyamSelect = document.getElementById('warnaanyam_id');
                    const newOption = document.createElement('option');
                    newOption.value = data.id;
                    newOption.textContent = data.name_warnaanyam;
                    newOption.selected = true;
                    warnaAnyamSelect.appendChild(newOption);

                    // Reset form and close modal
                    form.reset();
                    closeModal('AddWarnaAnyamModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while adding the warna anyam');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalButtonText;
                });
        });

        // Filter Warna Anyam based on Jenis Anyam
        function filterWarnaAnyam(selectElement) {
            const selectedJenisAnyamId = selectElement.value;
            const warnaAnyamSelect = document.getElementById('warnaanyam_id');

            if (!selectedJenisAnyamId) {
                console.log('Belum ada Jenis Anyam yang dipilih.');
                return;
            }

            console.log('Jenis Anyam selected:', selectedJenisAnyamId);

            // Reset dropdown Warna Anyam
            warnaAnyamSelect.value = "";

            // Sembunyikan semua opsi
            Array.from(warnaAnyamSelect.options).forEach(option => {
                if (option.value === "") {
                    option.style.display = 'block'; // biarkan default
                } else {
                    option.style.display = 'none';
                }
            });

            // Tampilkan yang sesuai
            Array.from(warnaAnyamSelect.options).forEach(option => {
                if (option.dataset.jenisanyamId === selectedJenisAnyamId) {
                    option.style.display = 'block';
                }
            });
        }

        //delete warna anyam
        function deleteWarnaAnyam(id) {
            // Show confirmation modal instead of confirm()
            const confirmModal = document.createElement('div');
            confirmModal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/40';
            confirmModal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-sm p-6 relative text-center">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Are you sure you want to delete this warna anyam?</h3>
                    <div class="flex justify-center gap-4">
                        <button id="cancelDeleteWarnaAnyam" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">Cancel</button>
                        <button id="confirmDeleteWarnaAnyam" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors duration-200">Delete</button>
                    </div>
                </div>
            `;
            document.body.appendChild(confirmModal);
            document.body.classList.add('overflow-hidden');

            document.getElementById('cancelDeleteWarnaAnyam').onclick = function() {
                document.body.removeChild(confirmModal);
                document.body.classList.remove('overflow-hidden');
            };

            document.getElementById('confirmDeleteWarnaAnyam').onclick = function() {
                fetch(`/barcode/warnaanyam/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Failed to delete warna anyam");
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Remove from select dropdown
                        const warnaAnyamSelect = document.getElementById('warnaanyam_id');
                        const optionToRemove = warnaAnyamSelect.querySelector(`option[value="${id}"]`);
                        if (optionToRemove) {
                            warnaAnyamSelect.removeChild(optionToRemove);
                        }

                        // Remove from list
                        const listItem = document
                            .querySelector(`li[data-id="${id}"]`);
                        if (listItem) {
                            listItem.parentNode.removeChild(listItem);
                        }
                        // Close confirmation modal
                        document.body.removeChild(confirmModal);
                        document.body.classList.remove('overflow-hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message || 'An error occurred while deleting the warna anyam');
                    });
            };
        }

        // Jenis Kayu Form Handling
        document.getElementById('addJenisKayuForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || "Failed to add jenis kayu");
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Add to select dropdown
                    const jenisKayuSelect = document.getElementById('jeniskayu_id');
                    const newOption = document.createElement('option');
                    newOption.value = data.id;
                    newOption.textContent = data.name_jeniskayu;
                    newOption.selected = true;
                    jenisKayuSelect.appendChild(newOption);

                    // Reset form and close modal
                    form.reset();
                    closeModal('AddJenisKayuModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while adding the jenis kayu');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalButtonText;
                });
        });

        // delete Jenis Kayu
        function deleteJenisKayu(id) {
            // Show confirmation modal instead of confirm()
            const confirmModal = document.createElement('div');
            confirmModal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/40';
            confirmModal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-sm p-6 relative text-center">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Are you sure you want to delete this jenis kayu?</h3>
                    <div class="flex justify-center gap-4">
                        <button id="cancelDeleteJenisKayu" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">Cancel</button>
                        <button id="confirmDeleteJenisKayu" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors duration-200">Delete</button>
                    </div>
                </div>
            `;
            document.body.appendChild(confirmModal);
            document.body.classList.add('overflow-hidden');

            document.getElementById('cancelDeleteJenisKayu').onclick = function() {
                document.body.removeChild(confirmModal);
                document.body.classList.remove('overflow-hidden');
            };

            document.getElementById('confirmDeleteJenisKayu').onclick = function() {
                fetch(`/barcode/jeniskayu/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                'content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Failed to delete jenis kayu");
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Remove from select dropdown
                        const jenisKayuSelect = document.getElementById('jeniskayu_id');
                        const optionToRemove = jenisKayuSelect.querySelector(`option[value="${id}"]`);
                        if (optionToRemove) {
                            jenisKayuSelect.removeChild(optionToRemove);
                        }

                        // Remove from list
                        const listItem = document.querySelector(`li[data-id="${id}"]`);
                        if (listItem) {
                            listItem.parentNode.removeChild(listItem);
                        }
                        // Close confirmation modal
                        document.body.removeChild(confirmModal);
                        document.body.classList.remove('overflow-hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message || 'An error occurred while deleting the jenis kayu');
                    });
            };
        }

        // Jenis Anyam Form Handling
        document.getElementById('addJenisAnyamForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || "Failed to add jenis anyam");
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    const jenisAnyamSelect = document.getElementById('jenisanyam_id');

                    // Buat dan tambahkan opsi baru
                    const newOption = document.createElement('option');
                    newOption.value = data.id;
                    newOption.textContent = data.name_jenisanyam;
                    newOption.selected = true;

                    // Tambahkan ke dropdown
                    jenisAnyamSelect.appendChild(newOption);

                    // Hapus atribut "selected" dari opsi default jika ada
                    const defaultOption = jenisAnyamSelect.querySelector('option[value=""]');
                    if (defaultOption) {
                        defaultOption.selected = false;
                    }

                    // Trigger event onchange untuk update warna anyam
                    filterWarnaAnyam(jenisAnyamSelect);

                    // Reset form dan tutup modal
                    form.reset();
                    closeModal('AddJenisAnyamModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while adding the jenis anyam');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalButtonText;
                });
        });

        // delete Jenis Anyam
        function deleteJenisAnyam(id) {
            // Show confirmation modal instead of confirm()
            const confirmModal = document.createElement('div');
            confirmModal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/40';
            confirmModal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-sm p-6 relative text-center">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Are you sure you want to delete this jenis anyam?</h3>
                    <div class="flex justify-center gap-4">
                        <button id="cancelDeleteJenisAnyam" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">Cancel</button>
                        <button id="confirmDeleteJenisAnyam" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors duration-200">Delete</button>
                    </div>
                </div>
            `;
            document.body.appendChild(confirmModal);
            document.body.classList.add('overflow-hidden');

            document.getElementById('cancelDeleteJenisAnyam').onclick = function() {
                document.body.removeChild(confirmModal);
                document.body.classList.remove('overflow-hidden');
            };

            document.getElementById('confirmDeleteJenisAnyam').onclick = function() {
                fetch(`/barcode/jenisanyam/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || "Failed to delete jenis anyam");
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Remove from select dropdown
                        const jenisAnyamSelect = document.getElementById('jenisanyam_id');
                        const optionToRemove = jenisAnyamSelect.querySelector(`option[value="${id}"]`);
                        if (optionToRemove) {
                            jenisAnyamSelect.removeChild(optionToRemove);
                        }

                        // Remove from list
                        const listItem = document.querySelector(`li[data-id="${id}"]`);
                        if (listItem) {
                            listItem.parentNode.removeChild(listItem);
                        }
                        // Close confirmation modal
                        document.body.removeChild(confirmModal);
                        document.body.classList.remove('overflow-hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message || 'An error occurred while deleting the jenis anyam');
                    });
            };
        }

        // Grade Form Handling
        document.getElementById('addGradeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || "Failed to add grade");
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Add to select dropdown
                    const gradeSelect = document.getElementById('grade_id');
                    const newOption = document.createElement('option');
                    newOption.value = data.id;
                    newOption.textContent = data.name_grade;
                    newOption.selected = true;
                    gradeSelect.appendChild(newOption);

                    // Add to list
                    const gradeList = document.getElementById('gradeList');
                    const li = document.createElement('li');
                    li.className =
                        'flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-2 rounded-lg';
                    li.dataset.id = data.id;

                    const span = document.createElement('span');
                    span.className = 'ml-4';
                    span.textContent = data.name_grade;

                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'text-red-600 hover:text-red-800 transition-colors duration-200';
                    button.innerHTML = '<i class="fa-solid fa-trash mr-4"></i>';
                    button.onclick = function() {
                        deleteGrade(data.id);
                    };

                    li.appendChild(span);
                    li.appendChild(button);
                    gradeList.appendChild(li);

                    // Reset form and close modal
                    form.reset();
                    closeModal('AddGradeModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while adding the grade');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalButtonText;
                });
        });

        function deleteGrade(id) {
            // Show confirmation modal instead of confirm()
            const confirmModal = document.createElement('div');
            confirmModal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/40';
            confirmModal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-sm p-6 relative text-center">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Are you sure you want to delete this finishing?</h3>
                    <div class="flex justify-center gap-4">
                        <button id="cancelDeleteFinishing" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">Cancel</button>
                        <button id="confirmDeleteFinishing" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors duration-200">Delete</button>
                    </div>
                </div>
            `;
            document.body.appendChild(confirmModal);
            document.body.classList.add('overflow-hidden');

            document.getElementById('cancelDeleteFinishing').onclick = function() {
                document.body.removeChild(confirmModal);
                document.body.classList.remove('overflow-hidden');
            };


            document.getElementById('confirmDeleteFinishing').onclick = function() {
                fetch(`/barcode/grade/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || "Failed to delete grade");
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Remove from select dropdown
                        const gradeSelect = document.getElementById('grade_id');
                        const optionToRemove = Array.from(gradeSelect.options).find(option => option.value == id);
                        if (optionToRemove) gradeSelect.removeChild(optionToRemove);

                        // Remove from list
                        const listItem = document.querySelector(`#gradeList li[data-id="${id}"]`);
                        if (listItem) listItem.remove();

                        // Show success modal
                        showModalMessage('Grade deleted successfully');

                        //close confirmation modal
                        document.body.removeChild(confirmModal);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message || 'An error occurred while deleting the grade');
                    });
            }
        }

        function showModalMessage(message) {
            document.getElementById('successModalMessage').textContent = message;
            document.getElementById('successModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeSuccessModal() {
            document.getElementById('successModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        // Finishing Form Handling
        document.getElementById('addFinishingForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || "Failed to add finishing");
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Add to select dropdown
                    const finishingSelect = document.getElementById('finishing_id');
                    const newOption = document.createElement('option');
                    newOption.value = data.id;
                    newOption.textContent = data.name_finishing;
                    newOption.selected = true;
                    finishingSelect.appendChild(newOption);

                    // Add to list
                    const finishingList = document.getElementById('finishingList');
                    const li = document.createElement('li');
                    li.className =
                        'flex justify-between items-center bg-gray-100 dark:bg-gray-700 p-2 rounded-lg';
                    li.dataset.id = data.id;

                    const span = document.createElement('span');
                    span.textContent = data.name_finishing;

                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = 'text-red-600 hover:text-red-800 transition-colors duration-200';
                    button.innerHTML = '<i class="fa-solid fa-trash"></i>';
                    button.onclick = function() {
                        deleteFinishing(data.id);
                    };

                    li.appendChild(span);
                    li.appendChild(button);
                    finishingList.appendChild(li);

                    // Reset form and close modal
                    form.reset();
                    closeModal('AddFinishingModal');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while adding the finishing');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalButtonText;
                });
        });

        function deleteFinishing(id) {
            // Show confirmation modal instead of confirm()
            const confirmModal = document.createElement('div');
            confirmModal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/40';
            confirmModal.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg w-full max-w-sm p-6 relative text-center">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Are you sure you want to delete this finishing?</h3>
                    <div class="flex justify-center gap-4">
                        <button id="cancelDeleteFinishing" class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors duration-200">Cancel</button>
                        <button id="confirmDeleteFinishing" class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold transition-colors duration-200">Delete</button>
                    </div>
                </div>
            `;
            document.body.appendChild(confirmModal);
            document.body.classList.add('overflow-hidden');

            document.getElementById('cancelDeleteFinishing').onclick = function() {
                document.body.removeChild(confirmModal);
                document.body.classList.remove('overflow-hidden');
            };
            document.getElementById('confirmDeleteFinishing').onclick = function() {
                fetch(`/barcode/finishing/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || "Failed to delete finishing");
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Remove from select dropdown
                        const finishingSelect = document.getElementById('finishing_id');
                        const optionToRemove = Array.from(finishingSelect.options).find(option => option.value ==
                            id);
                        if (optionToRemove) finishingSelect.removeChild(optionToRemove);

                        // Remove from list
                        const listItem = document.querySelector(`#finishingList li[data-id="${id}"]`);
                        if (listItem) listItem.remove();

                        // Show success modal
                        showModalMessage('Finishing deleted successfully');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message || 'An error occurred while deleting the finishing');
                    })
                    .finally(() => {
                        document.body.removeChild(confirmModal);
                        document.body.classList.remove('overflow-hidden');
                    });
            };
        }

        // Item Form Handling
        document.getElementById('addItemForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.textContent;

            // Show loading state
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Processing...';

            fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || "Failed to add item");
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Handle success (you might want to refresh the items list or show a success message)
                    alert('Item added successfully');
                    form.reset();
                    closeModal('AddItemModal');

                    // Optionally refresh the page or update the items list
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'An error occurred while adding the item');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = originalButtonText;
                });
        });
    </script>
</body>

</html>
