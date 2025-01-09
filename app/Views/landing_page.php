<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Services</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Welcome to Our Services</h1>
                <p class="text-lg text-gray-600">Choose which service you'd like to access</p>
            </div>
            
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Kerlyn's Service Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Tourism Service</h2>
                        <p class="text-gray-600 mb-6">Explore amazing tourist destinations and share your experiences</p>
                        <div class="mt-4">
                            <a href="/kerlyn" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition-colors duration-300">
                                Access Tourism Portal
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Ammar's Service Card -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Car Rental Service</h2>
                        <p class="text-gray-600 mb-6">Find and rent the perfect car for your journey</p>
                        <div class="mt-4">
                            <a href="/ammar" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors duration-300">
                                Access Car Rental Portal
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center text-gray-600">
                <p>© 2024 Your Company Name. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>