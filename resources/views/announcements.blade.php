<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Announcements') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">Latest Announcements</h3>
                    <p class="mb-4">This section will display the latest announcements and updates from the Navotas Polytechnic College - Integrated Computer Society.</p>
                    
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="text-red-700">Announcement listing functionality coming soon!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 