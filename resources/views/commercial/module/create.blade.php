<form action="{{ route('commercial.store') }}" method="POST" class="div__create_form">
    @csrf
    <div class="div__create_block">
        <h1><span class="Jikharev">Уважаемый клиент,</span>   мы подготовили для Вас Коммерческий бриф</h1>
        <p>Вам необходимо заполнить все поля. Чем больше мы получим информации, тем более точный результат мы сможем гарантировать!</p>
     
        <button type="submit">Создать бриф</button>
    </div>
</form>
