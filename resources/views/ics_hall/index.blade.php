@extends('layouts.app')
@section('content')
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fadeInUp {
        opacity: 0;
    }

    .animate-slideInRight {
        opacity: 0;
    }

    .animate-fadeInUp.visible {
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .animate-slideInRight.visible {
        animation: slideInRight 0.6s ease-out forwards;
    }

    .custom-btn {
        @apply bg-[#c21313] text-white px-6 py-2 text-sm rounded-lg transition-all duration-300 hover:bg-[#a11010] hover:shadow-md;
    }

    .outline-btn {
        @apply border border-[#c21313] text-[#c21313] px-6 py-2 text-sm rounded-lg transition-all duration-300;
        background-color: transparent;
    }

    .outline-btn::before {
        content: '';
        @apply absolute inset-0 bg-[#c21313] transition-all duration-500 transform scale-x-0 origin-left;
        z-index: -1;
    }

    .outline-btn::after {
        content: '';
        @apply absolute inset-0 bg-[#a11010] transition-all duration-500 transform scale-x-0 origin-right;
        z-index: -1;
    }

    .outline-btn:hover {
        @apply bg-[#c21313] text-white shadow-md;
    }

    .outline-btn:hover::before {
        @apply scale-x-100;
    }

    .outline-btn:hover::after {
        @apply scale-x-100;
    }

    .outline-btn span {
        @apply relative z-10 transition-transform duration-500;
    }

    .outline-btn:hover span {
        @apply transform translate-x-1;
    }

    .outline-btn.bg {
        @apply bg-[#c21313] text-white;
    }

    .outline-btn.bg:hover {
        @apply bg-[#a11010];
    }

    .custom-text {
        @apply text-[#c21313] transition-colors duration-300 hover:text-[#a11010];
    }

    .custom-link {
        @apply transition-all duration-300 hover:text-[#c21313];
    }

    .event-date {
        @apply text-right pr-5 border-r-2 border-[#c21313] w-24;
    }

    .event-month {
        @apply text-[#c21313] text-xl font-semibold leading-none;
    }

    .event-day {
        @apply text-3xl font-bold leading-none;
    }

    .event-title {
        @apply text-[#c21313] font-semibold mb-2 text-lg;
    }

    .event-description {
        @apply text-gray-600 text-sm;
    }

    .event-thumbnail {
        @apply w-32 h-24 object-cover mr-4 rounded-lg;
    }

    .news-card {
        @apply bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:bg-gray-50;
    }

    .news-image {
        @apply w-full h-64 object-cover transition-transform duration-500 hover:scale-105;
    }

    .event-card {
        @apply bg-white rounded-xl shadow-md p-6 hover:shadow-lg transition-all duration-300 hover:bg-gray-50;
    }
</style>

<!-- Hero Section -->
<div class="relative h-[80vh] bg-cover bg-center" style="background-image: url('{{ asset('img/homebg.jpg') }}');">
    <div class="absolute inset-0 bg-black/60"></div>
    <div class="relative z-10 flex items-center justify-center h-full text-center px-4">
        <div class="text-white max-w-4xl">
            <h1 class="font-marker text-5xl md:text-7xl animate-fadeInUp" style="animation-delay: 0.2s;">Welcome to ICS Hall!</h1>
            <p class="mt-6 text-xl md:text-2xl animate-fadeInUp" style="animation-delay: 0.4s;">A place where you code your path.</p>
            <div class="mt-8 animate-fadeInUp flex justify-center" style="animation-delay: 0.6s;">
                <a href="#news" class="border border-[#c21313] hover:bg-[#c21313] hover:text-white px-6 py-2 text-sm rounded-lg transition duration-300">
                    <span>Explore More</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- News Section -->
<div id="news" class="container mx-auto px-4 py-16">
    <h2 class="text-4xl font-bold mb-12 custom-text text-[#c21313] text-center animate-fadeInUp">Latest News & Announcements</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
        @foreach ([
            ['img' => 'news1.jpg', 'title' => 'Result shows new ICS officers', 'desc' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Lorem ipsum dolor sit amet.'],
            ['img' => 'news2.jpg', 'title' => 'ICS and EEC\'s "Digital Detox" event, a major success!', 'desc' => 'Lorem ipsum dolor sit amet, consectetur. Quisquam, quos.'],
            ['img' => 'news3.jpg', 'title' => 'ICS joins NPC Intramurals', 'desc' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos. Lorem ipsum dolor.']
        ] as $index => $news)
        <div class="news-card animate-fadeInUp" style="animation-delay: {{ 0.2 + $index * 0.2 }}s">
            <img src="{{ asset('img/' . $news['img']) }}" alt="{{ $news['title'] }}" class="news-image">
            <div class="p-6 flex flex-col h-full">
                <h3 class="text-xl font-semibold mb-3 custom-link">{{ $news['title'] }}</h3>
                <p class="text-gray-600 mb-4 flex-grow">{{ $news['desc'] }}</p>
                <div class="w-full flex items-center justify-center">
                    <button type="button" class="border border-[#c21313] hover:bg-[#c21313] hover:text-white px-6 py-2 text-sm rounded-lg transition duration-300 mx-auto">
                        <span>Read More</span>
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-12 animate-fadeInUp flex justify-center" style="animation-delay: 0.8s">
        <a href="{{ url('/announcements') }}" class="bg-[#c21313] text-white px-6 py-2 text-sm rounded-lg transition duration-300 hover:bg-[#a11010] shadow-md">
            See More News & Announcements
        </a>
    </div>
</div>

<!-- Events Section -->
<div class="container mx-auto px-4 py-16">
    <h2 class="text-4xl font-bold mb-12 text-[#c21313] text-center animate-fadeInUp">Upcoming Events</h2>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Featured Event -->
        <div class="lg:col-span-2 animate-fadeInUp">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="relative">
                    <img src="{{ asset('img/oathtaking.jpg') }}" alt="Oath Taking" class="w-full h-[450px] object-cover">
                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-8">
                        <div class="text-white text-lg font-semibold">May 5</div>
                        <h3 class="text-3xl font-bold mt-2 text-white">Oath Taking of New ICS Officers</h3>
                        <p class="mt-2 text-base text-gray-200">Yay, may papalit na sa amin.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Other Events -->
        <div class="space-y-6 animate-slideInRight">
            <div class="event-card">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('img/kiten.jpg') }}" alt="Birthday ni Kiten" class="w-20 h-20 object-cover rounded-full">
                    <div>
                        <div class="text-sm text-gray-500">May 11</div>
                        <h4 class="font-semibold text-lg text-[#c21313]">Birthday ni Kiten</h4>
                        <p class="text-sm text-gray-700">Happy birthday Kiten bebelabs! 🎉</p>
                    </div>
                </div>
            </div>
            <div class="event-card">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('img/kiten.jpg') }}" alt="Birthday ni Kiten" class="w-20 h-20 object-cover rounded-full">
                    <div>
                        <div class="text-sm text-gray-500">May 15</div>
                        <h4 class="font-semibold text-lg text-[#c21313]">Leadership Seminar</h4>
                        <p class="text-sm text-gray-700">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quos.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<br>
    <div class="w-full flex items-center justify-center mt-12 animate-fadeInUp">
        <a href="{{ url('omcms/events') }}" class="bg-[#c21313] text-white px-6 py-2 text-sm rounded-lg transition duration-300 hover:bg-[#a11010] shadow-md mx-auto">
            View All Events
        </a>
    </div>
</div>

<script>
    // Intersection Observer for animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1
    });

    // Observe all animated elements
    document.querySelectorAll('.animate-fadeInUp, .animate-slideInRight').forEach((el) => {
        observer.observe(el);
    });
</script>

@endsection