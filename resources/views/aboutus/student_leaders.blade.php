<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-6">
                <!-- Sidebar -->
                <div class="md:w-1/4">
                    <x-about-sidebar />
                </div>

                <!-- Main Content -->
                <div class="md:w-3/4">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <h3 class="text-2xl text-[#c21313] font-bold mb-4">ICS Student Leaders</h3>

                            <!-- SY 2024-2025 -->
                            <div class="mb-10">
                                <div class="text-center mb-6">
                                    <div class="flex justify-center mb-3">
                                        <img src="{{ asset('img/ics-logo.png') }}" alt="ICS Logo" class="h-20">
                                    </div>
                                    <h4 class="text-xl font-bold text-[#c21313]">Integrated Computer Society (ICS) SY 2024-2025</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- President -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/president.jpg') }}" alt="President" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">RICO P. ESCALICAS</h5>
                                                <p class="text-sm">PRESIDENT</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vice President -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/vice-president.jpg') }}" alt="Vice President" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">JOSHUA B. DELA CRUZ</h5>
                                                <p class="text-sm">VICE PRESIDENT</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Secretary -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/secretary.jpg') }}" alt="Secretary" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">KIRSTEN ABEGYLE A. MANGALI</h5>
                                                <p class="text-sm">SECRETARY</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Treasurer -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/treasurer.jpg') }}" alt="Treasurer" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">ERICA B. LUMUTAC</h5>
                                                <p class="text-sm">TREASURER</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Auditor -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/auditor.jpg') }}" alt="Auditor" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">JOAN P. FALCON</h5>
                                                <p class="text-sm">AUDITOR</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Business Manager -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/business-manager.jpg') }}" alt="Business Manager" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">LORENZ T. MAGDAEL</h5>
                                                <p class="text-sm">BUSINESS MANAGER</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PIO -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/business-manager.jpg') }}" alt="Business Manager" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">GEIROL M. CAMPOS</h5>
                                                <p class="text-sm">PIO</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SY 2023-2024 -->
                            <div class="mb-10">
                                <div class="text-center mb-6">
                                    <div class="flex justify-center mb-3">
                                        <img src="{{ asset('img/ics-logo.png') }}" alt="ICS Logo" class="h-20">
                                    </div>
                                    <h4 class="text-xl font-bold text-[#c21313]">Integrated Computer Society (ICS) SY 2022-2023</h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <!-- President -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/pres2023.png') }}" alt="President" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">ARC ANGEL MATITO</h5>
                                                <p class="text-sm">PRESIDENT</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vice President -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/vp2023.png') }}" alt="Vice President" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">JANZ VINCENT REYES</h5>
                                                <p class="text-sm">VICE PRESIDENT</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Secretary -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/sec2023.png') }}" alt="Secretary" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">MERELIZA ANIBAN</h5>
                                                <p class="text-sm">SECRETARY</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Treasurer -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/treasurer2023.png') }}" alt="Treasurer" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">REYBIE DELA CRUZ</h5>
                                                <p class="text-sm">TREASURER</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Auditor -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/auditor2023.png') }}" alt="Auditor" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">MICHERVIN FRIAS</h5>
                                                <p class="text-sm">AUDITOR</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Business Manager -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2023-2024/busman2023.png') }}" alt="Business Manager" class="w-full h-64 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold">JAYSON MARTINEZ</h5>
                                                <p class="text-sm">BUSINESS MANAGER</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SY 2022-2023 -->
                            <div class="mb-10">
                                <div class="text-center mb-6">
                                    <div class="flex justify-center mb-3">
                                        <img src="{{ asset('img/ics-logo.png') }}" alt="ICS Logo" class="h-20">
                                    </div>
                                    <h4 class="text-xl font-bold text-[#c21313]">Integrated Computer Society (ICS) SY 2022-2023</h4>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <!-- Adviser -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2022-2023/adviser.png') }}" alt="President" class="w-full h-48 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold text-sm">EDSAN C. MORENO</h5>
                                                <p class="text-xs">ADVISER</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- President -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2022-2023/pres2022.png') }}" alt="President" class="w-full h-48 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold text-sm">MICHAEL DENOSTA</h5>
                                                <p class="text-xs">PRESIDENT</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vice President -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2022-2023/vp2022.png') }}" alt="Vice President" class="w-full h-48 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold text-sm">DANICA REYES</h5>
                                                <p class="text-xs">VICE PRESIDENT</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Secretary -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2022-2023/sec2022.png') }}" alt="Secretary" class="w-full h-48 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold text-sm">RONA GUIMALAN</h5>
                                                <p class="text-xs">SECRETARY</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Treasurer -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2022-2023/treasurer2022.png') }}" alt="Treasurer" class="w-full h-48 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold text-sm">LOVELY NICOLE RICAFORTE</h5>
                                                <p class="text-xs">TREASURER</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Auditor -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2022-2023/auditor.png') }}" alt="Auditor" class="w-full h-48 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold text-sm">DANIELLA PACALA </h5>
                                                <p class="text-xs">AUDITOR</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Business Manager -->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2022-2023/busman.png') }}" alt="Business Manager" class="w-full h-48 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold text-sm">CARLA MAE LINDA</h5>
                                                <p class="text-xs">BUSINESS MANAGER</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- PIO-->
                                    <div class="bg-white rounded-lg overflow-hidden shadow-md border border-gray-200">
                                        <div class="relative">
                                            <img src="{{ asset('img/officers/2022-2023/pio.png') }}" alt="PRO" class="w-full h-48 object-cover">
                                            <div class="absolute bottom-0 left-0 right-0 bg-[#c21313] text-white p-2 text-center">
                                                <h5 class="font-bold text-sm">ALLEAH FUENTES</h5>
                                                <p class="text-xs">PIO</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Note about past officers -->
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 mt-6">
                                <p class="text-gray-700">
                                    <i class="fas fa-info-circle text-[#c21313] mr-2"></i>
                                    The ICS Organization honors all past officers who have contributed to the growth and success of our society.
                                    Their leadership and dedication have helped shape the organization into what it is today.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>