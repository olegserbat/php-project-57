@extends('layouts.main')
@section('content')

    <section class="bg-white ">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h2 class="mb-5">
                    Просмотр задачи: {{$task->name}} <a href="https://tasks/{{$task->id}}/edit">⚙</a>
                </h2>
                <p><span class="font-black">Имя:</span> {{$task->name}}</p>
                <p><span class="font-black">Статус:</span> {{$task->status->name}}</p>
                <p><span class="font-black">Описание:</span> {{$task->description}}</p>
                <p><span class="font-black">Метки:</span></p>
                <div>
                    @foreach($task->labeles as $label)
                        <div
                            class="text-xs inline-flex items-center font-bold leading-sm uppercase px-3 py-1 bg-blue-200 text-blue-700 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            {{$label->name}}
                        </div>
                    @endforeach
                </div>
                    @auth()
                        <form class="w-50" method="POST" action="/comments">
                            @csrf
                            <div class="flex flex-col">
                                <div>
                                    <label for="name">Написать комментарий к задаче</label>
                                </div>
                                <div class="mt-2">
                                    <input class="rounded border-gray-300 w-1/3" type="text" name="comment">
                                    <input class="rounded border-gray-300 w-1/3" type="hidden" name="task_id"
                                           value="{{$task->id}}">
                                </div>
                                @if ($errors->any())
                                    <div class="text-rose-600">
                                        {{$errors->first('comment')}}
                                    </div>
                                @endif
                            </div>
                            <div class="mt-2">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                        type="submit">Комментировать
                                </button>
                            </div>
                        </form>
                    @endauth

                    <table class="mt-4">
                        <thead class="border-b-2 border-solid border-black text-left">
                        <tr>
                            <th>Комментарии к задаче:</th>
                            @auth()
                                <th>Действия с комментарием</th>
                            @endauth
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($task->comments as $comment)
                            <tr class="border-b border-dashed text-left">
                                <td>{{$comment->comment}}</td>
                                @auth()
                                    <td class="border-b border-dashed text-left">
                                    @if($task->created_by_id == auth()->user()->id or $comment->creator->id == auth()->user()->id )
                                            <a href="{{route('comments.destroy', ['comment' => $comment->id, '_token' => csrf_token()])}}"
                                               data-confirm="Уверены, что хотите удалить?"
                                               data-method="delete" style="color: red"
                                               rel="nofollow">
                                                Удалить
                                            </a> |
                                            @endif
                                            @if($comment->creator->id == auth()->user()->id)
                                            <a href="/comments/{{$comment->id}}/edit"
                                               class="text-blue-600 hover:text-blue-900">
                                                Изменить </a>
                                            @endif
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
