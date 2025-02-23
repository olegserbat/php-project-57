<!DOCTYPE html>
<html lang="ru"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="YIhgJCewwXIRgNZRPjDdvhNJPdjtbyZYvhqoQjBM">
    <meta name="csrf-param" content="_token">

    <title>Менеджер задач</title>

    <!-- Scripts -->
    <link rel="preload" as="style" href="https://php-task-manager-ru.hexlet.app/build/assets/app.4885a691.css">
    <link rel="modulepreload" href="https://php-task-manager-ru.hexlet.app/build/assets/app.42df0f0d.js">
    <link rel="stylesheet" href="https://php-task-manager-ru.hexlet.app/build/assets/app.4885a691.css">
    <script type="module" src="https://php-task-manager-ru.hexlet.app/build/assets/app.42df0f0d.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
</head>
<body>
<div id="app">
    <header class="fixed w-full">
        <nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-900 shadow-md">
            <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
                <a href="/" class="flex items-center">
                    <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Менеджер задач</span>
                </a>

                <div class="flex items-center lg:order-2">
                    <a href="/login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Вход
                    </a>
                    <a href="/register" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                        Регистрация
                    </a>
                </div>

                <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1">
                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                        <li>
                            <a href="/tasks" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                Задачи                                </a>
                        </li>
                        <li>
                            <a href="/task_statuses" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                Статусы                                </a>
                        </li>
                        <li>
                            <a href="/labels" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                Метки                                </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="bg-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5">Задачи</h1>

                <div class="w-full flex items-center">
                    <div>
                        <form method="GET" action="/tasks">
                            <div class="flex">
                                <select class="rounded border-gray-300" name="filter[status_id]" id="filter[status_id]">
                                    <option value="" selected="selected">Статус</option>
                                    <option value="1">новая</option>
                                    <option value="2">завершена</option>
                                    <option value="3">выполняется</option>
                                    <option value="4">в архиве</option>
                                </select>
                                <select class="rounded border-gray-300" name="filter[created_by_id]" id="filter[created_by_id]">
                                    <option value="" selected="selected">Автор</option>
                                    <option value="1">Владимир Евгеньевич Михайлов</option>

                                    <option value="8">Марк Александрович Авдеев</option><option value="9">Воронов Роберт Романович</option><option value="10">Фёдоров Вячеслав Романович</option><option value="11">Клим Евгеньевич Федотов</option><option value="12">Калинин Данила Фёдорович</option><option value="13">Стефан Фёдорович Баранов</option><option value="14">Вадим Сергеевич Орехов</option><option value="15">Георгий Фёдорович Власов</option><option value="16">Oleg</option><option value="17">Oleg</option></select>
                                <select class="rounded border-gray-300" name="filter[assigned_to_id]" id="filter[assigned_to_id]"><option value="" selected="selected">Исполнитель</option>
                                    <option value="1">Владимир Евгеньевич Михайлов</option>
                                    <option value="2">Фаина Романовна Белоусова</option>
                                </select>
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2" type="submit">Применить</button>

                            </div></form>
                    </div>

                    <div class="ml-auto">
                    </div>
                </div>

                <table class="mt-4">
                    <thead class="border-b-2 border-solid border-black text-left">
                    <tr>
                        <th>ID</th>
                        <th>Статус</th>
                        <th>Имя</th>
                        <th>Автор</th>
                        <th>Исполнитель</th>
                        <th>Дата создания</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="border-b border-dashed text-left">
                        <td>1</td>
                        <td>в архиве</td>
                        <td>
                            <a class="text-blue-600 hover:text-blue-900" href="/tasks/1">
                                Исправить ошибку в какой-нибудь строке
                            </a>
                        </td>
                        <td>Марк Александрович Авдеев</td>
                        <td>Фаина Романовна Белоусова</td>
                        <td>22.02.2025</td>
                        <td>
                        </td>
                    </tr>

                    </tbody></table>

                <div class="mt-4">
                    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
                        <div class="flex justify-between flex-1 sm:hidden">
                            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                    « Previous
                </span>

                            <a href="/tasks?page=2" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">
                                Next »
                            </a>
                        </div>

                        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
                                    Showing
                                    <span class="font-medium">1</span>
                                    to
                                    <span class="font-medium">15</span>
                                    of
                                    <span class="font-medium">16</span>
                                    results
                                </p>
                            </div>

                            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">

                                            <span aria-disabled="true" aria-label="&amp;laquo; Previous">
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </span>





                    <span aria-current="page">
                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600">1</span>
                    </span>
                    <a href="/tasks?page=2" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:text-gray-300 dark:active:bg-gray-700 dark:focus:border-blue-800" aria-label="Go to page 2">
                                        2
                                    </a>


                    <a href="/tasks?page=2" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:active:bg-gray-700 dark:focus:border-blue-800" aria-label="Next &amp;raquo;">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                                    </span>
                            </div>
                        </div>
                    </nav>

                </div>
            </div>

        </div>
    </section>
</div>


</body></html>
