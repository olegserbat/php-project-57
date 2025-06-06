<x-guest-layout>

    <h2 class="text-center">
        <a href="/">Менеджер задач</a>
    </h2>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                <div>Упс! Что-то пошло не так:</div>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Имя')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
{{--            <x-input-error :messages="$errors->get('name')" class="mt-2" />--}}
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
{{--            <x-input-error :messages="$errors->get('email')" class="mt-2" />--}}
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Пароль')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

{{--            <x-input-error :messages="$errors->get('password')" class="mt-2" />--}}
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Подтверждение')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

{{--            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />--}}
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Уже зарегестрированы?') }}
            </a>

            <button type="submit"  class="ms-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white  tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
{{--                {{ $slot }}--}}
{{--                {{ __('Зарегестрировать') }}--}} Зарегистрировать
            </button>
{{--            <x-primary-button class="ms-4">--}}
{{--                {{ __('Зарегестрировать') }}--}}
{{--            </x-primary-button>--}}
        </div>
    </form>
</x-guest-layout>
