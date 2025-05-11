<x-layouts.public>
    <div class="filament-card rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="p-6">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row items-center mb-8">
                <div class="md:w-1/2 p-4">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">About Us</h1>
                    <p class="text-lg text-gray-600 dark:text-gray-300 mb-6">
                        Welcome to our blog platform! We're dedicated to providing high-quality content and insights on various topics that matter to our community.
                    </p>
                </div>
                <div class="md:w-1/2 p-4">
                    <img src="{{ asset('img/placeholder.webp') }}" alt="About Us" class="w-full h-auto rounded-lg shadow-md">
                </div>
            </div>

            <!-- Mission Section -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Mission</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Our mission is to create a platform where knowledge can be shared freely and openly. We believe in the power of information and aim to make it accessible to everyone.
                </p>
                <p class="text-gray-600 dark:text-gray-300">
                    Through our blog, we strive to educate, inspire, and engage with our readers on topics ranging from technology and science to art and culture.
                </p>
            </div>

            <!-- Team Section -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Our Team</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center filament-card p-4 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                        <img src="{{ asset('img/placeholder.webp') }}" alt="Team Member 1" class="w-32 h-32 object-cover rounded-full mx-auto mb-4 border-4 border-white dark:border-gray-800 shadow">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Jane Doe</h3>
                        <p class="text-gray-600 dark:text-gray-300">Founder & Editor</p>
                    </div>
                    <div class="text-center filament-card p-4 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                        <img src="{{ asset('img/placeholder.webp') }}" alt="Team Member 2" class="w-32 h-32 object-cover rounded-full mx-auto mb-4 border-4 border-white dark:border-gray-800 shadow">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">John Smith</h3>
                        <p class="text-gray-600 dark:text-gray-300">Content Manager</p>
                    </div>
                    <div class="text-center filament-card p-4 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                        <img src="{{ asset('img/placeholder.webp') }}" alt="Team Member 3" class="w-32 h-32 object-cover rounded-full mx-auto mb-4 border-4 border-white dark:border-gray-800 shadow">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Alex Johnson</h3>
                        <p class="text-gray-600 dark:text-gray-300">Lead Developer</p>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Contact Us</h2>
                <p class="text-gray-600 dark:text-gray-300 mb-4">
                    Have questions, suggestions, or want to collaborate with us? We'd love to hear from you!
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="filament-card p-4 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-3">
                                <div class="flex items-center justify-center w-10 h-10 rounded-md bg-amber-500/10 text-amber-600 dark:text-amber-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Email</h3>
                                <p class="text-gray-600 dark:text-gray-300">info@example.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="filament-card p-4 rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 mr-3">
                                <div class="flex items-center justify-center w-10 h-10 rounded-md bg-amber-500/10 text-amber-600 dark:text-amber-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1">Phone</h3>
                                <p class="text-gray-600 dark:text-gray-300">+1 (555) 123-4567</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>