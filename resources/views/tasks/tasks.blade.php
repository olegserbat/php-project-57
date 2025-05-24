@extends('layouts.main')
@section('content')

    <section class="bg-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            @if (session('task'))
                <div class="alert
                    alert-success
                    " role="alert">
                    {{ session('task') }}
                </div>
            @endif
            <div class="grid col-span-full">
                <h1 class="mb-5">Задачи</h1>

                <div class="w-full flex items-center">
                    <div>
                        <form method="GET" action="/tasks">
                            <div class="flex">
                                <select class="rounded border-gray-300" name="filter[status_id]" id="filter[status_id]">
                                    <option value="">Статус</option>
                                    @foreach($statuses as $status)
                                        @if($status->id == $filter['status_id'])
                                            <option value="{{$status->id}}" selected>{{$status->name}}</option>
                                        @endif
                                        <option value="{{$status->id}}">{{$status->name}}</option>
                                    @endforeach
                                </select>
                                <select class="rounded border-gray-300" name="filter[created_by_id]"
                                        id="filter[created_by_id]">
                                    <option value="">Автор</option>
                                    @foreach($users as $user)
                                        @if($user->id == $filter['created_by_id'])
                                            <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                        @endif
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                <select class="rounded border-gray-300" name="filter[assigned_to_id]"
                                        id="filter[assigned_to_id]">
                                    <option value="">Исполнитель</option>
                                    @foreach($users as $user)
                                        @if($user->id == $filter['assigned_to_id'])
                                            <option value="{{$user->id}}" selected>{{$user->name}}</option>
                                        @endif
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                <button
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2"
                                    type="submit">Применить
                                </button>

                            </div>
                        </form>
                    </div>
                    @auth()
                        <div class="ml-auto">
                            <a href="/tasks/create"
                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                                Создать задачу </a>
                        </div>
                    @endauth
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
                        @auth()
                            <th>Действия</th>
                        @endauth
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tasks as $task)
                        <tr class="border-b border-dashed text-left">
                            <td>{{$task->id}}</td>
                            <td>{{$task->status->name}}</td>
                            <td>
                                <a class="text-blue-600 hover:text-blue-900" href="/tasks/{{$task->id}}">
                                    {{$task->name}}
                                </a>
                            </td>
                            <td>{{ $task->creator->name}}</td>
                            <td>{{$task->assign->name ?? ''}}</td>
                            <td>{{$task->created_at->format('d.m.Y')}}</td>
                            <td>
                                @auth()
                                    @if($task->created_by_id == auth()->user()->id)
                                    <td class="border-b border-dashed text-left">
                                            <a href="{{route('tasks.destroy', ['id' => $task->id, '_token' => csrf_token()])}}"
                                               data-confirm="Уверены, что хотите удалить?"
                                               data-method="delete" style="color: red"
                                               rel="nofollow">
                                                Удалить
                                            </a>  |
{{--                                        <form class="text-red-600 hover:text-blue-900"--}}
{{--                                              action="/tasks/{{$task->id}}" method="POST">--}}
{{--                                            @csrf--}}
{{--                                            @method('DELETE')--}}
{{--                                            <button type="submit" class="btn btn-danger btn-sm"--}}
{{--                                                    onclick="return confirm('Уверены, что хотите удалить?')">--}}
{{--                                                Удалить--}}
{{--                                            </button>--}}
{{--                                        </form>--}}
                                    @endif
                                    <a href="/tasks/{{$task->id}}/edit" class="text-blue-600 hover:text-blue-900">
                                        Изменить </a>
                                    </td>
                            @endauth
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                {{$tasks->links()}}
            </div>
        </div>
    </section>
@endsection
