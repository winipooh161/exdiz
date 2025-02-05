

@extends('layouts.auth')
@section('content')
    <div class="container-auth">
        <div class="auth__body flex center">
            <div class="auth__form">
     
                <h1>{{ $title_site }}</h1>

                <form action="{{ route('auth.complete_registration_by_deal', ['token' => $deal->registration_token]) }}" method="POST">
                    @csrf
                
                        <label for="name">Имя
                        <input type="text" id="name" name="name"placeholder="Ваше имя" class="form-control" required>
                    </label>
                
                
                        <label for="phone">Номер телефона
                        <input type="text" id="phone" name="phone" class="form-control maskphone"placeholder="+7 (___) ___-__-__"  value="{{ old('phone') }}" required>
                    </label>
                
                  
                        <label for="password">Пароль
                        <input type="password" id="password" name="password" placeholder="********" class="form-control" required>
             
                    </label>
                
                        <label for="password_confirmation">Подтверждение пароля
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="********"  class="form-control" required>
                    </label>
                
                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                </form>
            </div>
        </div>
    </div>
@endsection
