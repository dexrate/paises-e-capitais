<x-main-layout paginaTitulo="Paises e Capitais Quiz">
    <!-- form -->
    <div class="container">

        <div class="text-center fs-3 mb-3">
            <p class="text-info">RESULTADOS FINAIS</p>
        </div>

        <div class="row fs-3">
            <div class="col text-end">Total de questões:</div>
            <div class="col text-info">{{ $totalQuestoes }}</div>
        </div>
        <div class="row fs-3">
            <div class="col text-end">Respostas Certas:</div>
            <div class="col text-success">{{ $corretas }}</div>
        </div>
        <div class="row fs-3">
            <div class="col text-end">Respostas Erradas:</div>
            <div class="col text-danger">{{ $erradas }}</div>
        </div>
        <div class="row fs-1">
            <div class="col text-end">Score Final:</div>
            <div class="col {{$porcentagem < 50 ? 'text-danger' : 'text-success'}}">{{ $porcentagem }} %</div>
        </div>
        
    </div>

    <!-- cancel game -->
    <div class="text-center mt-5">
        <a href="{{ route('start-game') }}" class="btn btn-primary mt-3 px-5">VOLTAR AO INÍCIO</a>
    </div>

</x-main-layout>