<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class MainController extends Controller
{
    private $app_data;

    public function __construct()
    {
        // carregar app_data
        $this->app_data = require(app_path('app_data.php'));
    }

    public function mostraDados()
    {
        return response()->json($this->app_data);
    }

    public function iniciaJogo(): View
    {
        return view('home');
    }

    public function preparaJogo(Request $request)
    {
        $request->validate([
            'total_questions' => 'required|integer|min:3|max:30',
        ],
        [
            'total_questions.required' => 'Numero de questões é obrigatório',
            'total_questions.integer' => 'Numero de questões é tem que ser um valor inteiro',
            'total_questions.min' => 'Numero de questões deve ser maior ou igual a :min',
            'total_questions.max' => 'Numero de questões deve ser menor ou igual a :max',
        ]);

        //verificar total de questôes
        $totalQuestoes = intval($request->total_questions);

        // preprara toda a estrutura do quiz
        $quiz = $this->preparaQuiz($totalQuestoes);

        // guardar o jogo na sessão
        session()->put([
            'quiz' => $quiz,
            'total_questoes' => $totalQuestoes,
            'pergunta_atual' => 1,
            'corretas' => 0,
            'erradas' => 0,
        ]);

        return redirect()->route('jogo');
    }

    public function jogo()
    {
        $quiz = session('quiz');
        $totalQuestoes = session('total_questoes');
        $perguntaAtual = session('pergunta_atual') - 1;

        // informações daquela pergunta
        $infosPergunta = $quiz[$perguntaAtual];

        // preparando respostas erradas
        $respostas = $infosPergunta['respostas_erradas'];
        $respostas[] =  $infosPergunta['resposta_correta'];

        // misturar as respostas
        shuffle($respostas);


        return view('jogo', compact('infosPergunta', 'respostas', 'perguntaAtual', 'totalQuestoes'));
    }

    public function resposta($resposta_encriptada)
    {
        try {
            $resposta = Crypt::decryptString($resposta_encriptada);
        } catch (\Exception $e) {
            return redirect()->route('jogo');
        }

        // logica do jogo
        $quiz = session('quiz');
        $totalQuestoes = session('total_questoes');
        $perguntaAtual = session('pergunta_atual') - 1;

        $resposta_correta = $quiz[$perguntaAtual]['resposta_correta'];

        $corretas = session('corretas');
        $erradas = session('erradas');

        if ($resposta == $resposta_correta) {
            $corretas++;
            $quiz[$perguntaAtual]['correto'] = true;
        } else {
            $erradas++;
            $quiz[$perguntaAtual]['correto'] = false;
        }

        // atualizar sessão
        session()->put([
            'quiz' => $quiz,
            'corretas' => $corretas,
            'erradas' => $erradas,
        ]);

        // preparar dados para mostrar a resposta correta
        $dados = [
            'pais' => $quiz[$perguntaAtual]['pais'],
            'resposta_certa' => $resposta_correta,
            'reposta_escolhida' => $resposta,
            'pergunta_atual' => $perguntaAtual,
            'total_perguntas' => $totalQuestoes,
        ];

        $infosPergunta = $quiz[$perguntaAtual];

        return view('resultado-pergunta', compact('dados', 'infosPergunta', 'perguntaAtual', 'totalQuestoes'));
    }

    public function proximaQuestao()
    {
        $totalQuestoes = session('total_questoes');
        $perguntaAtual = session('pergunta_atual');

        // verificar se chegou ao fim
        if ($perguntaAtual < $totalQuestoes) {
            $perguntaAtual++;
            session()->put('pergunta_atual', $perguntaAtual);

            return redirect()->route('jogo');
        } else {
            // fim do jogo

            return redirect()->route('resultado');
        }
    }

    public function resultado()
    {
        $quiz = session('quiz');
        $corretas = session('corretas');
        $erradas = session('erradas');
        $totalQuestoes = session('total_questoes');
        $porcentagem = round($corretas/$totalQuestoes * 100, 2);

        return view('resultado', compact('corretas', 'erradas', 'totalQuestoes', 'porcentagem'));
    }
    
    private function preparaQuiz($totalQuestoes) {
        $questoes = [];
        $paisesTotal = count($this->app_data);
        //todos paises array
        $indexPaises = range(0, $paisesTotal - 1);

        // embaralhar sem repetir os indexes de paises
        shuffle($indexPaises);
        // corta para pegar a quantidade de questoes
        $indexPaises = array_slice($indexPaises, 0, $totalQuestoes);

        // criar o array de questões
        $question_number = 1;
        foreach($indexPaises as $indexPais) {
            $questao['numero_questao'] = $question_number++;
            $questao['pais'] = $this->app_data[$indexPais]['country'];
            $questao['resposta_correta'] = $this->app_data[$indexPais]['capital'];

            // $questao['respostas_erradas'] = $this->app_data[$indexPais]['country'];
            // respostas erradas
            $outrasCapitais = array_column($this->app_data, 'capital');

            // remover resposta correta
            $outrasCapitais = array_diff($outrasCapitais, [$questao['resposta_correta']]);
            // embaralhar as respostas erradas
            shuffle($outrasCapitais);

            // cortar para apenas 3 capitais
            $questao['respostas_erradas'] = array_slice($outrasCapitais, 0, 3);

            // verifica se resposta foi correta
            $questao['correto'] = null;

            $questoes[] = $questao;
        }

        return $questoes;
    }
}
