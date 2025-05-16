<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> {{ $title ?? 'Page Title' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <x-toaster-hub />
    <style>
        .transition-all {
            transition: all 0.3s ease;
        }

        .sidebar {
            transition: transform 0.3s ease;
        }

        .sidebar-left {
            transform: translateX(-100%);
        }

        .sidebar-right {
            transform: translateX(100%);
        }

        .sidebar-left.open {
            transform: translateX(0);
        }

        .sidebar-right.open {
            transform: translateX(0);
        }

        @media (min-width: 640px) {
            .sidebar-left {
                transform: translateX(0);
            }

            .sidebar-right {
                transform: translateX(0);
            }
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05), 0 1px 0 rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }


        .navbar-container {
            width: calc(100% - 15rem);

            right: 15rem;

        }

        @media (max-width: 639px) {
            .navbar-container {
                width: 100%;
                right: 0;
            }
        }
    </style>
</head>

<body class="bg-base-200 min-h-screen">




    <main class="flex-1 pt-16 sm:ml-64 sm:mr-80 overflow-auto bg-white">
        {{ $slot }}

    </main>


    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Toggle Right Sidebar
            const toggleRightSidebar = document.getElementById('toggle-right-sidebar');
            const rightSidebar = document.getElementById('right-sidebar');

            // Overlay for mobile
            const overlay = document.createElement('div');
            overlay.className = 'fixed inset-0 dark:bg-gray-900 opacity-50 z-30 hidden';
            document.body.appendChild(overlay);

            // Function to close sidebars
            function closeSidebars() {
                rightSidebar.classList.remove('open');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }


            // Toggle right sidebar
            toggleRightSidebar.addEventListener('click', function() {
                rightSidebar.classList.toggle('open');

                overlay.classList.toggle('hidden', !rightSidebar.classList.contains('open'));
                document.body.classList.toggle('overflow-hidden', rightSidebar.classList.contains('open'));
            });

            // Close sidebar when clicking overlay
            overlay.addEventListener('click', closeSidebars);

            // Close sidebar when pressing Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeSidebars();
                }
            });


            function handleResize() {
                if (window.innerWidth <= 1920) {
                    rightSidebar.classList.remove('open');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }
            }


            handleResize();


            window.addEventListener('resize', handleResize);
        });
    </script>

</body>

</html>
