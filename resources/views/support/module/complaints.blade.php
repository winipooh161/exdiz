
    <div class="main__flex">
        <div class="main__ponel">
        
        </div>
        <div class="main__module">
      
            <h1>Все жалобы</h1>
            <div class="support_adm">
                @foreach ($complaints as $complaint)
                    <div class="support_adm__card">
                        <div class="complaint">
                            <div class="complaint__user">
                                <h3>{{ $complaint->title }}</h3>
                                <p>{{ $complaint->description }}</p>
                                <p>Ответ: {{ $complaint->response ?? 'Ответ еще не предоставлен' }}</p>
                            </div>
            
                            <div class="complaint__support">
                                <a href="{{ route('support.chat', ['complaintId' => $complaint->id]) }}">Перейти в чат</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
        </div>
    </div>
