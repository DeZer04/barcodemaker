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

<body
    class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 text-gray-800 dark:text-gray-200 font-inter flex items-center justify-center min-h-screen p-4">
    <div class="max-w-4xl w-full space-y-6">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Barcode Generator</h1>
        </div>

        <!-- Barcode Display -->
        <div
            class="card bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col items-center">
            <div class="bg-white p-4 rounded-lg mb-4">
                <img src="{{ asset('path/to/default-barcode.png') }}" alt="Default Barcode" class="h-24 w-auto">
            </div>
            <span
                class="text-xl font-mono font-semibold bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-md">123456789012</span>
        </div>

        <!-- Form Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Item Selection -->
            <div class="card bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Item Selection</h2>

                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Item</label>
                <div class="flex flex-row gap-2">
                    <select
                        class="select2 w-7/8 mb-4 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                        id="itemSelect">
                        <option value="" disabled selected>Select Item</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>

                    <script></script>

                    <button
                        class="btn-primary w-1/8 h-10 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium"
                        onclick="openModal('AddItemModal')">
                        <span class="flex items-center justify-center gap-2">
                            <i class="fa-solid fa-plus"></i>
                        </span>
                    </button>
                </div>

            </div>

            <!-- Buyer and Purchase Selection -->
            <div class="card bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Buyer and Purchases Selection
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Buyer
                            Selection</label>
                        <div class="flex flex-row gap-2">
                            <select
                                class="select-custom w-3/4 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                id="buyerSelect" onchange="filterPurchases()">
                                <option value="" disabled selected>Select Buyer</option>
                                @foreach ($buyers as $buyer)
                                    <option value="{{ $buyer->id }}">{{ $buyer->name }}</option>
                                @endforeach
                            </select>
                            <button
                                class="btn-primary w-1/4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium"
                                onclick="openModal('AddBuyerModal')">
                                <span class="flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Purchase
                            Selection</label>
                        <div class="flex flex-row gap-2">
                            <select
                                class="select-custom w-3/4 px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                                id="purchaseSelect">
                                <option value="" disabled selected>Select Purchase</option>
                                @foreach ($purchases as $purchase)
                                    <option value="{{ $purchase->id }}" data-buyer-id="{{ $purchase->buyer_id }}">
                                        {{ $purchase->name }}</option>
                                @endforeach
                            </select>
                            <button
                                class="btn-primary w-1/4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium"
                                onclick="openModal('AddPurchasesModal')">
                                <span class="flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-plus"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Line Selection -->
        <div class="card bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">Line Configuration</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Select Letter</label>
                    <div class="grid grid-cols-10 gap-2">
                        @foreach (range('A', 'Z') as $letter)
                            <button type="button"
                                class="letter-button text-black focus:text-black hover:text-black px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                                data-letter="{{ $letter }}" onclick="selectLetter(this)">
                                {{ $letter }}
                            </button>
                        @endforeach
                    </div>
                </div>
                <div class="col-span-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Selected
                        Letter</label>
                    <input type="text" id="selectedLetter"
                        class="w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                        readonly>
                </div>
            </div>

            <script></script>
            <button class="btn-primary w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium"
                onclick="openModal('AddLineModal')">
                <span class="flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus"></i>
                    Manage Line
                </span>
            </button>
        </div>

        <!-- Generate Button -->
        <button
            class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold text-lg shadow-md transition-all duration-200 transform hover:scale-[1.01]">
            Generate Barcode
        </button>
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
                        <select
                            class="select-custom w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                            id="jenisanyam_id" name="jenisanyam_id" required onchange="filterWarnaAnyam()">
                            <option value="" disabled selected>Select Jenis Anyam</option>
                            @foreach ($jenisanyams as $jenisanyam)
                                <option value="{{ $jenisanyam->id }}">{{ $jenisanyam->name_jenisanyam }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button
                        class="btn-primary h-10 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium flex items-center justify-center transition-colors duration-200"
                        onclick="openModal('addJenisAnyamModal')">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <div class="flex flex-row gap-2 items-end">
                    <div class="flex-1">
                        <label for="warnaanyam_id"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Warna Anyam</label>
                        <select
                            class="select-custom w-full px-3 py-2 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition duration-200"
                            id="warnaanyam_id" name="warnaanyam_id" required>
                            <option value="" disabled selected>Select Warna Anyam</option>
                            @foreach ($warnaanyams as $warnaanyam)
                                <option value="{{ $warnaanyam->id }}"
                                    data-jenisanyam-id="{{ $warnaanyam->jenisanyam_id }}">
                                    {{ $warnaanyam->name_warnaanyam }}</option>
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
        <div class="bg-white"></div>
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
                width: '100%'
            });
        });

        function selectLetter(button) {
            const selectedLetter = button.getAttribute('data-letter');
            document.getElementById('selectedLetter').value = selectedLetter;

            // Highlight selected button
            document.querySelectorAll('.letter-button').forEach(btn => {
                btn.classList.remove('bg-blue-500', 'text-black');
                btn.classList.add('bg-white', 'dark:bg-gray-700', 'text-black');
            });
            button.classList.add('bg-blue-500', 'text-black');
        }

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
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
                    closeAddJenisKayuModal();
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
                    // Add to select dropdown
                    const jenisAnyamSelect = document.getElementById('jenisanyam_id');
                    const newOption = document.createElement('option');
                    newOption.value = data.id;
                    newOption.textContent = data.name_jenisanyam;
                    newOption.selected = true;
                    jenisAnyamSelect.appendChild(newOption);

                    // Reset form and close modal
                    form.reset();
                    closeAddJenisAnyamModal();
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
                    closeAddGradeModal();
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
                    closeAddFinishingModal();
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
                    closeAddItemModal();

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
