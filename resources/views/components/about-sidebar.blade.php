<div class="bg-white shadow-sm sm:rounded-lg p-6">
    <h3 class="text-lg font-semibold text-[#c21313] mb-4">CONTENTS</h3>
    <nav class="space-y-1">
        <a href="{{ route('aboutus') }}" 
           class="block px-3 py-2 text-sm {{ request()->routeIs('aboutus') ? 'text-[#c21313] font-medium' : 'text-gray-700 hover:text-[#c21313]' }} transition-colors">
            About ICS
        </a>
        <a href="{{ route('aboutus.vision-mission') }}" 
           class="block px-3 py-2 text-sm {{ request()->routeIs('aboutus.vision-mission') ? 'text-[#c21313] font-medium' : 'text-gray-700 hover:text-[#c21313]' }} transition-colors">
            Vision and Mission
        </a>
        <a href="{{ route('aboutus.history') }}" 
           class="block px-3 py-2 text-sm {{ request()->routeIs('aboutus.history') ? 'text-[#c21313] font-medium' : 'text-gray-700 hover:text-[#c21313]' }} transition-colors">
            History
        </a>
        <a href="{{ route('aboutus.logo-symbolism') }}" 
           class="block px-3 py-2 text-sm {{ request()->routeIs('aboutus.logo-symbolism') ? 'text-[#c21313] font-medium' : 'text-gray-700 hover:text-[#c21313]' }} transition-colors">
            Logo and Symbols
        </a>
        <a href="{{ route('aboutus.student-leaders') }}" 
           class="block px-3 py-2 text-sm {{ request()->routeIs('aboutus.student-leaders') ? 'text-[#c21313] font-medium' : 'text-gray-700 hover:text-[#c21313]' }} transition-colors">
            Student Leaders
        </a>
        <div class="border-t border-gray-200 my-2"></div>
        <a href="{{ route('aboutus.developers') }}" 
           class="block px-3 py-2 text-sm {{ request()->routeIs('aboutus.developers') ? 'text-[#c21313] font-medium' : 'text-gray-700 hover:text-[#c21313]' }} transition-colors">
            Developers
        </a>
        <a href="{{ route('aboutus.contact') }}" 
           class="block px-3 py-2 text-sm {{ request()->routeIs('aboutus.contact') ? 'text-[#c21313] font-medium' : 'text-gray-700 hover:text-[#c21313]' }} transition-colors">
            Contact Information
        </a>
    </nav>
</div> 