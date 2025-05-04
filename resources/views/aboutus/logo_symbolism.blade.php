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
                            <div class="prose max-w-none">
                                <div class="mb-8">
                                    <h3 class="text-2xl text-[#c21313] font-bold mb-3">Logo Symbolism</h3>
                                    <p class="text-[20px] text-[#c21313] font-bold">The ICS Logo</p>
                                    <p class="mb-4">
                                        <img class="mx-auto" src="{{ asset('img/ics-logo2.png') }}" alt="">
                                    </p>
                                    The ICS Organization proudly uses its official logo, which carries deep meaning and reflects who we are as a community. At the center is the shield, which stands for protection, security, and defense. This shows our commitment to providing a safe and supportive environment where members can grow and succeed, both in academics and in their future careers.                                    </p>
                                </div>

                                    <p class="mb-4">
                                        The <b>binary code</b>  in the logo represents the core of technology. Binary is the simplest and most basic language of computers, reminding us that all members start with the fundamentals before moving on to more advanced skills.                                    </p>
                                </div>

                                <div class="mb-8">
                                    <p class="mb-4">
                                        The <b>cog</b> symbolizes unity and teamwork. It shows that every member is important and plays a role in keeping the organization strong and active, just like each part of a machine works together to make it run smoothly.
                                        </p>
                                </div>
                                <div>
                                    <p class="mb-4">
                                        The <b> interconnected network symbol</b> stands for connection and collaboration. It reflects our belief that by working together and supporting one another, we build strong ties within the organization and extend those connections to the wider tech community.
                                        </p>
                                </div>

                                <div> 
                                    <p class="mb-4">
                                    Our official colors are <b>red (#c21313)</b> and <b>black (#000000)</b>. Red represents energy, passion, and determination—qualities we value as we face challenges and strive for success. Black stands for strength, professionalism, and excellence, reminding us to always aim high and maintain strong standards.
                                    </p>
                                </div>

                                <div> 
                                    <p class="mb-4">
                                        Altogether, the elements of the logo show that ICS is a united, passionate, and forward-thinking community, ready to grow and make a difference in the world of technology.                                    </p>
                                </div>
                               
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 