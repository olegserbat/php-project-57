@extends('layouts.main')
@section('content')
    <section class="bg-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            @if (session('status'))
            <div class="alert
                    alert-success
                    " role="alert">
                {{ session('status') }}
            </div>
            @endif
                @if(session('alert'))
                    <div class="alert
                    alert-danger
                    " role="alert">
                        {{session('alert')}}
                    </div>
                @endif
            <div class="grid col-span-full">
                <h1 class="mb-5">Статусы</h1>
                @auth()
                    <div>
                        <a href="/task_statuses/create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Создать статус </a>
                    </div>
                @endauth
                    <table class="mt-4">
                        <thead class="border-b-2 border-solid border-black text-left">
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Дата создания</th>
                            @auth()
                                <th>Действия</th>
                            @endauth
                        </tr>
                        </thead>
                        <tbody>

                           @foreach($taskStatuses as $taskStatuse)
                               <tr class="border-b border-dashed text-left">
                            <td>{{$taskStatuse->id}}</td>
                            <td>{{$taskStatuse->name}}</td>
                            <td>{{$taskStatuse->created_at}}</td>
                               @auth()
                                    <td>
                                       <td class="border-b border-dashed text-left">
                                           <a href="{{route('task_statuses.destroy', ['id' => $taskStatuse->id, '_token' => csrf_token()])}}"
                                              data-confirm="Уверены, что хотите удалить?"
                                              data-method="delete" style="color: red"
                                              rel="nofollow">
                                               Удалить
                                           </a> |
                                        <a class="text-blue-600 hover:text-blue-900" href="/task_statuses/{{$taskStatuse->id}}/edit">
                                            Изменить </a>
                                    </td>
                                @endauth
                               </tr>
                            @endforeach

                        </tbody>
                    </table>
            </div>
        </div>
    </section>
@endsection
