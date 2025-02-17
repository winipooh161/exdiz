<form action="{{ route('commercial.store') }}" method="POST" class="div__create_form">
    @csrf
    <div class="div__create_block">
        <h1><span class="Jikharev">Добро пожаловать!</span>   </h1>
        <p><strong>Дорогой клиент,</strong> для продолжения требуется пройти <strong>бриф-опросник</strong> </p>
     
        <button type="submit">Создать бриф</button>
    </div>
</form>
