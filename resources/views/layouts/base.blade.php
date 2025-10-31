<!DOCTYPE html>

<html>
    <head>
        <title>User Balance Transfer - JOB-TEST</title>

        @vite([
            'resources/css/app.css',
            'resources/js/app.js',
        ])
    </head>
    <body class="w-full mx-auto max-w-[1200px] grid grid-row-[100px_auto_100px] gap-y-[24px]">
        <header>
            Какой-то дефолтный хидер
        </header>
        <main>
            @yield('section')
        </main>
        <footer>
            Какой-то дефолтный футер
        </footer>
    </body>
</html>