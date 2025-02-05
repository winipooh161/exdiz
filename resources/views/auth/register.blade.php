@extends('layouts.auth')
@section('content')
    <div class="container-auth">
        <div class="auth__body flex center">
            <div class="auth__form">
                <h1>Регистрация</h1>
                <form action="{{ route('register.post') }}" method="POST">
                    @csrf
                    <label for="name">
                        <p>Имя:</p>
                        <input type="text" name="name" id="name" placeholder="Ваше имя"  class="form-control" value="{{ old('name') }}"
                           maxlength="50" required>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </label>
                    <label for="phone">
                        <p>phone:</p>
                        <input type="phone" name="phone" id="phone" class="form-control maskphone" placeholder="+7 (___) ___-__-__"  value="{{ old('phone') }}"
                            required>
                        @error('phone')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </label>
                    <label for="password">
                        <p>Пароль:</p>
                        <input type="password" name="password" id="password" class="form-control" placeholder="********"  maxlength="50" required>
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </label>
                    <label for="password_confirmation">
                        <p>Подтвердите пароль:</p>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="********"  maxlength="50" class="form-control"
                            required>
                    </label>
                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                    <ul class="auth__form__link">
                        <li><a href="{{ route('login.code') }}">Войти по коду</a></li>
                        <li style="text-align: center">Нажимая на "Зарегистрироваться" вы соглашаетесь с<a href=""> политикой конфиденциальности</a></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
@endsection
