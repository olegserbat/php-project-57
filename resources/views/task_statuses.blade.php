<!DOCTYPE html>
<html lang="ru">
@include('shared.head')
<body>
<div id="app">
@include('shared.header')

    <section class="bg-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5">Статусы</h1>

                <div>
                </div>

                <table class="mt-4">
                    <thead class="border-b-2 border-solid border-black text-left">
                    <tr>
                        <th>ID</th>
                        <th>Имя</th>
                        <th>Дата создания</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="border-b border-dashed text-left">
                        <td>1</td>
                        <td>новая</td>
                        <td>23.02.2025</td>
                        <td>
                        </td>
                    </tr>

                    </tbody></table>

            </div>
        </div>
    </section>
</div>
