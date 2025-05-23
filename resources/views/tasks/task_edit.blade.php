@extends('layouts.main')
@section('content')

    <section class="bg-white">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5">Создать задачу</h1>

                <form class="w-50" method="POST" action="/tasks/{{$task->id}}">
                    @csrf
                    <input type="hidden" name="_method" id="_method" value="PATCH">
                    <div class="flex flex-col">
                        <div>
                            <label for="name">Имя</label>
                        </div>
                        <div class="mt-2">
                            <input class="rounded border-gray-300 w-1/3" type="text" name="name" id="name" value="{{$task->name}}">
                        </div>
                        @if ($errors->any())
                            <div class="text-rose-600" >
                                {{$errors->first('name')}}
                            </div>
                        @endif
                        <div class="mt-2">
                            <label for="description">Описание</label>
                        </div>
                        <div>
                            <textarea class="rounded border-gray-300 w-1/3 h-32" name="description" id="description">{{$task->description}}</textarea>
                        </div>
                        <div class="mt-2">
                            <label for="status_id">Статус</label>
                        </div>
                        <div>
                            <select class="rounded border-gray-300 w-1/3" name="status_id" id="status_id">
                                <option value={{$task->status_id}} selected="selected">{{$task->status->name}}</option>
                                @foreach($statuses as $status)
                                    <option value="{{$status->id}}">{{$status->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($errors->any())
                            <div class="text-rose-600" >
                                {{$errors->first('status_id')}}
                            </div>
                        @endif
                        <div class="mt-2">
                            <label for="status_id">Исполнитель</label>
                        </div>
                        <div>
                            <select class="rounded border-gray-300 w-1/3" name="assigned_to_id" id="assigned_to_id">
                                <option value="{{$task->assigned_to_id}}" selected>{{$task->assign?->name ?? ''}}</option>
                                @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                            <div class="mt-2">
                                <label for="status_id">Метки</label>
                            </div>
                            <div>
                                <select class="rounded border-gray-300 w-1/3 h-32" name="labels[]" id="labels[]" multiple="">
                                    @foreach($allLabels as $label)
                                    <option value="{{$label->id}}"
                                            @if(in_array($label->name, $task->labeles->pluck('name')->all()))
                                        selected
                                        @endif>{{$label->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-2">
                                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">Обновить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
