<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vision and Mission') }}
        </h2>
    </x-slot>

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
                            <div class="prose max-w-none">
                                <div class="mb-8">
                                    <h3 class="text-2xl font-bold mb-4">Vision</h3>
                                    <p class="mb-4">
                                        The Institute of Computer Studies envisions itself as a leading center of excellence in computer education, research, and technology innovation in the Philippines.
                                    </p>
                                </div>

                                <div class="mb-8">
                                    <h3 class="text-2xl font-bold mb-4">Mission</h3>
                                    <p class="mb-4">
                                        To provide quality education and training in computer studies that will produce competent and ethical IT professionals who will contribute to the development of the nation.
                                    </p>
                                </div>

                                <div>
                                    <h3 class="text-2xl font-bold mb-4">Core Values</h3>
                                    <ul class="list-disc pl-6 space-y-2">
                                        <li>Excellence in Teaching and Learning</li>
                                        <li>Innovation and Creativity</li>
                                        <li>Professional Ethics and Integrity</li>
                                        <li>Social Responsibility</li>
                                        <li>Continuous Improvement</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 