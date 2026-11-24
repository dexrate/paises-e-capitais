<x-main-layout paginaTitulo="Paises e Capitais Quiz">
    <!-- form -->
    <div class="container">
        <x-questao :pais="$infosPergunta['pais']" :pergunta-atual="$perguntaAtual" :total-questoes="$totalQuestoes" />

        <div class="text-center fs-3 mb-3">
            Resposta correta: <span class="text-info">{{ $dados['resposta_certa'] }}</span>
        </div>

        <div class="text-center fs-3 mb-3">
            A sua resposta: <span class="[conditional]">{{ $dados['reposta_escolhida'] }}</span>
        </div>
        
    </div>

    <!-- cancel game -->
    <div class="text-center mt-5">
        <a href="{{ route('proxima') }}" class="btn btn-primary mt-3 px-5">AVANÇAR</a>
    </div>

</x-main-layout>