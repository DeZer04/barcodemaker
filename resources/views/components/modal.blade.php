@props([
    'id' => '',
    'title' => '',
    'formAction' => '',
    'formId' => '',
    'hasList' => false,
    'listTitle' => '',
    'listItems' => [],
])

<div id="{{ $id }}" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md mx-4 relative max-h-[90vh] overflow-y-auto">
        <!-- Modal Header -->
        <div class="sticky top-0 bg-white dark:bg-gray-800 p-6 pb-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                    <i class="fa-solid {{ $icon ?? 'fa-circle-plus' }} mr-2"></i>
                    {{ $title }}
                </h3>
                <button onclick="closeModal('{{ $id }}')"
                    class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 transition-colors duration-200 p-1 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>
        </div>

        <!-- Modal Content -->
        <div class="p-6">
            <!-- Form Section -->
            <form id="{{ $formId }}" class="space-y-5" method="POST" action="{{ $formAction }}">
                @csrf
                {{ $formFields ?? '' }}
                
                <div class="flex justify-end gap-3 pt-1">
                    <button type="button" onclick="closeModal('{{ $id }}')"
                        class="px-5 py-2.5 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200 font-medium">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition-colors duration-200 shadow-sm hover:shadow-md">
                        <i class="fa-solid fa-save mr-1"></i>
                        Save
                    </button>
                </div>
            </form>

            <!-- List Section (if needed) -->
            @if($hasList)
                <div class="mt-8">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-3 flex items-center">
                        <i class="fa-solid fa-list-check mr-2 text-blue-500"></i>
                        {{ $listTitle }}
                    </h4>
                    
                    <div id="{{ $id }}ListContainer">
                        @if(empty($listItems))
                            <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                                <i class="fa-solid fa-inbox text-2xl mb-2"></i>
                                <p>No items added yet</p>
                            </div>
                        @else
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                {{ $listItems }}
                            </ul>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>