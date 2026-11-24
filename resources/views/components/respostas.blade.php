<div class="row">
    @foreach ($respostas as $resposta)
        <div class="col-6 text-center">
            <a href="{{ route('resposta', Crypt::encryptString($resposta)) }}" class="text-decoration-none">
                <p class="response-option">{{ $resposta }}</p>
            </a>
        </div>
    @endforeach
</div>
