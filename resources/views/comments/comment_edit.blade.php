@extends('layouts.main')
@section('content')

    <section class="bg-white ">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h2 class="mb-5">
                    Просмотр задачи: {{$task->name}}        <a href="https://tasks/{{$task->id}}/edit">⚙</a>
                </h2>
                <p><span class="font-black">Имя:</span> {{$task->name}}</p>
                <p><span class="font-black">Статус:</span> {{$task->status->name}}</p>
                <p><span class="font-black">Описание:</span> {{$task->description}}</p>
                <p><span class="font-black">Метки:</span></p>
                <div>
                    @foreach($task->labeles as $label)
                        <div class="text-xs inline-flex items-center font-bold leading-sm uppercase px-3 py-1 bg-blue-200 text-blue-700 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{$label->name}}
                        </div>
                    @endforeach
                </div>
                <div>
                        <form class="w-50" method="POST" action="/comments/{{$comment->id}}">
                            @csrf
                            <input type="hidden" name="_method" id="_method" value="PATCH">
                            <div class="flex flex-col">
                                <div>
                                    <label for="name">Написать комментарий к задаче</label>
                                </div>
                                <div class="mt-2">
                                    <input class="rounded border-gray-300 w-1/3" type="text" name="comment" value="{{$comment->comment}}">
                                    <input class="rounded border-gray-300 w-1/3" type="hidden" name="task_id" value="{{$task->id}}">
                                </div>
                                @if ($errors->any())
                                    <div class="text-rose-600" >
                                        {{$errors->first('comment')}}
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Изменить комментарий</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </section>
@endsection
