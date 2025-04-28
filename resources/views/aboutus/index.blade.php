@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Hero Section -->
        <div class="bg-indigo-700 rounded-xl shadow-xl overflow-hidden mb-8">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-r from-red-800 to-red-600 opacity-90"></div>
                <div class="relative px-8 py-16 sm:px-12 lg:px-16">
                    <div class="max-w-3xl">
                        <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">
                            About NPC-ICS
                        </h1>
                        <p class="mt-6 text-xl text-indigo-100 max-w-3xl">
                            The National Polytechnic College - Integrated Computer Society (NPC-ICS) is a premier student organization dedicated to advancing computing knowledge and fostering technological excellence.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mission, Vision, Values Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Mission -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <div class="bg-red-700 p-3 rounded-full border border-indigo-200 mr-4">
                        <i class="fas fa-bullseye text-xl text-indigo-600"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Our Mission</h2>
                </div>
                <p class="text-gray-600">
                    To empower students with the knowledge, skills, and resources needed to excel in the field of computing and information technology, while fostering a community of innovation, collaboration, and continuous learning.
                </p>
            </div>
            
            <!-- Vision -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <div class="bg-red-700 p-3 rounded-full border border-indigo-200 mr-4">
                        <i class="fas fa-eye text-xl text-indigo-600"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Our Vision</h2>
                </div>
                <p class="text-gray-600">
                    To be the leading student organization that bridges academic learning with industry practices, producing tech-savvy graduates who will contribute significantly to the advancement of the computing field in the Philippines.
                </p>
            </div>
            
            <!-- Values -->
            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                <div class="flex items-center mb-4">
                    <div class="bg-red-700 p-3 rounded-full border border-indigo-200 mr-4">
                        <i class="fas fa-heart text-xl text-indigo-600"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Our Core Values</h2>
                </div>
                <ul class="text-gray-600 space-y-2">
                    <li><i class="fas fa-check-circle text-indigo-500 mr-2"></i> Excellence in Technology</li>
                    <li><i class="fas fa-check-circle text-indigo-500 mr-2"></i> Innovation & Creativity</li>
                    <li><i class="fas fa-check-circle text-indigo-500 mr-2"></i> Integrity & Ethics</li>
                    <li><i class="fas fa-check-circle text-indigo-500 mr-2"></i> Collaboration & Teamwork</li>
                    <li><i class="fas fa-check-circle text-indigo-500 mr-2"></i> Continuous Learning</li>
                </ul>
            </div>
        </div>

        <!-- History Section -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-12">
            <div class="px-6 py-8 sm:p-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Our History</h2>
                
                <div class="prose max-w-none text-gray-600">
                    <p>
                        The National Polytechnic College - Integrated Computer Society (NPC-ICS) was established in 2005 by a group of passionate computer science students who saw the need for an organization that would supplement classroom learning with practical, hands-on experience in various computing disciplines.
                    </p>
                    <p class="mt-4">
                        What began as a small club of 15 members has now grown into one of the largest and most active student organizations in the college, with over 200 members across different computing-related programs. Throughout our history, we have organized numerous tech seminars, coding competitions, industry visits, and community outreach programs.
                    </p>
                    <p class="mt-4">
                        Our alumni have gone on to work in leading tech companies both locally and internationally, with many crediting their success to the skills and network they developed during their time with NPC-ICS.
                    </p>
                </div>
                
                <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-indigo-50 p-4 rounded-lg text-center">
                        <div class="text-3xl font-bold text-red-600">2005</div>
                        <div class="text-sm text-gray-600">Year Founded</div>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-lg text-center">
                        <div class="text-3xl font-bold text-red-600">200+</div>
                        <div class="text-sm text-gray-600">Active Members</div>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-lg text-center">
                        <div class="text-3xl font-bold text-red-600">50+</div>
                        <div class="text-sm text-gray-600">Annual Events</div>
                    </div>
                    <div class="bg-indigo-50 p-4 rounded-lg text-center">
                        <div class="text-3xl font-bold text-red-600">1000+</div>
                        <div class="text-sm text-gray-600">Alumni Network</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Leadership Team -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-12">
            <div class="px-6 py-8 sm:p-10">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Our Leadership Team</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- President -->
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm">
                        <div class="p-4 text-center">
                            <div class="w-24 h-24 rounded-full bg-red-600 mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                                JP
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Juan Dela Cruz</h3>
                            <p class="text-indigo-600 font-medium">President</p>
                            <p class="text-sm text-gray-600 mt-2">BS Computer Science</p>
                        </div>
                    </div>
                    
                    <!-- Vice President -->
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm">
                        <div class="p-4 text-center">
                            <div class="w-24 h-24 rounded-full bg-red-600 mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                                MS
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Maria Santos</h3>
                            <p class="text-indigo-600 font-medium">Vice President</p>
                            <p class="text-sm text-gray-600 mt-2">BS Information Technology</p>
                        </div>
                    </div>
                    
                    <!-- Secretary -->
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm">
                        <div class="p-4 text-center">
                            <div class="w-24 h-24 rounded-full bg-red-600 mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                                AR
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Anna Reyes</h3>
                            <p class="text-indigo-600 font-medium">Secretary</p>
                            <p class="text-sm text-gray-600 mt-2">BS Computer Engineering</p>
                        </div>
                    </div>
                    
                    <!-- Treasurer -->
                    <div class="bg-gray-50 rounded-lg overflow-hidden shadow-sm">
                        <div class="p-4 text-center">
                            <div class="w-24 h-24 rounded-full bg-red-600 mx-auto mb-4 flex items-center justify-center text-white text-2xl font-bold">
                                RL
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Robert Lim</h3>
                            <p class="text-indigo-600 font-medium">Treasurer</p>
                            <p class="text-sm text-gray-600 mt-2">BS Information Systems</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="bg-gray-900 rounded-xl shadow-xl overflow-hidden mb-6">
            <div class="px-6 py-8 sm:p-10">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-white mb-2">Get in Touch</h2>
                    <p class="text-gray-400 mb-6">Have questions or want to join our society?</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-8 max-w-3xl mx-auto">
                        <div class="bg-gray-800 rounded-lg p-4">
                            <div class="text-indigo-400 mb-2">
                                <i class="fas fa-envelope text-2xl"></i>
                            </div>
                            <h3 class="text-white font-medium">Email Us</h3>
                            <p class="text-gray-400 text-sm">npc.ics@example.edu.ph</p>
                        </div>
                        
                        <div class="bg-gray-800 rounded-lg p-4">
                            <div class="text-indigo-400 mb-2">
                                <i class="fas fa-map-marker-alt text-2xl"></i>
                            </div>
                            <h3 class="text-white font-medium">Visit Us</h3>
                            <p class="text-gray-400 text-sm">ICT Building, NPC Campus, Metro Manila</p>
                        </div>
                        
                        <div class="bg-gray-800 rounded-lg p-4">
                            <div class="text-indigo-400 mb-2">
                                <i class="fas fa-phone text-2xl"></i>
                            </div>
                            <h3 class="text-white font-medium">Call Us</h3>
                            <p class="text-gray-400 text-sm">(02) 8123-4567</p>
                        </div>
                    </div>
                    
                    <div class="mt-8">
                        <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-red-600 bg-white hover:bg-indigo-50 transition">
                            Join Our Community
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 