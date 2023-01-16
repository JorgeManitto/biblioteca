<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Biblioteca virtual CIE</title>

        {{-- <script src='/pdf/lib/webviewer.min.js'></script> --}}
        <style>
            #canvas_container {
                width: 800px;
                height: 450px;
                overflow: auto;
            }
            #canvas_container {
              background: #333;
              text-align: center;
              border: solid 3px;
            }
        </style>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

        {{-- <script type="text/jscript">
            function disableContextMenu()
            {
              window.frames["fraDisabled"].document.oncontextmenu = function(){alert("No way!"); return false;};
              // Or use this
              // document.getElementById("fraDisabled").contentWindow.document.oncontextmenu = function(){alert("No way!"); return false;};;
            }
          </script> --}}
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased" >
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class=" mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>
