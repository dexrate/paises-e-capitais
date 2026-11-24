<x-main-layout paginaTitulo="Paises e Capitais Quiz">
    <!-- form -->
    <div class="container">
        <x-questao :pais="$infosPergunta['pais']" :pergunta-atual="$perguntaAtual" :total-questoes="$totalQuestoes" />

        <x-respostas :respostas="$respostas" />
        
    </div>

    <!-- cancel game -->
    <div class="text-center mt-5">
        <a href="{{ route('start-game') }}" class="btn btn-outline-danger mt-3 px-5">CANCELAR JOGO</a>
    </div>
</x-main-layout>