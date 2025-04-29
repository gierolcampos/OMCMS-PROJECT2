<style>
    .nav-hover-effect {
        transition: all 0.3s ease;
    }
    .nav-hover-effect:hover {
        color: #c21313;
    }
    .dropdown-hover:hover {
        background-color: #c21313;
        color: white;
    }
</style>

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('ics-hall') }}">
                    <x-application-logo class="block h-9 w-auto fill-current" style="color: #c21313;" />
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden space-x-8 sm:-my-px sm:flex sm:items-center sm:justify-center flex-1">
                <x-nav-link :href="route('ics-hall')" :active="request()->routeIs('ics-hall')">
                    {{ __('ICS Hall') }}
                </x-nav-link>
                <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-nav-link>
                <x-nav-link :href="route('members')" :active="request()->routeIs('members')">
                    {{ __('Members') }}
                </x-nav-link>
                <x-nav-link :href="route('events')" :active="request()->routeIs('events')">
                    {{ __('Events') }}
                </x-nav-link>
                <x-nav-link :href="route('announcements')" :active="request()->routeIs('announcements')">
                    {{ __('Announcements') }}
                </x-nav-link>
                <x-nav-link :href="route('payments')" :active="request()->routeIs('payments')">
                    {{ __('Payments') }}
                </x-nav-link>
                <x-nav-link :href="route('letters')" :active="request()->routeIs('letters')">
                    {{ __('Letters') }}
                </x-nav-link>
                <x-nav-link :href="route('aboutus')" :active="request()->routeIs('aboutus')">
                    {{ __('About Us') }}
                </x-nav-link>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="nav-hover-effect inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="dropdown-hover">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                    class="dropdown-hover">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="nav-hover-effect inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('ics-hall')" :active="request()->routeIs('ics-hall')">
                {{ __('ICS Hall') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('members')" :active="request()->routeIs('members')">
                {{ __('Members') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('events')" :active="request()->routeIs('events')">
                {{ __('Events') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('announcements')" :active="request()->routeIs('announcements')">
                {{ __('Announcements') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('payments')" :active="request()->routeIs('payments')">
                {{ __('Payments') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('letters')" :active="request()->routeIs('letters')">
                {{ __('Letters') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('aboutus')" :active="request()->routeIs('aboutus')">
                {{ __('About Us') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="nav-hover-effect">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();"
                            class="nav-hover-effect">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
