<?php

//  $_SESSION['NOME']
//  $_SESSION['ENDERECO']
//  $_SESSION['DATA_NASC']
//  $_SESSION['CPF']
//  $_SESSION['SUS']
//  $_SESSION['SENHA']




define('PASTA_CADASTROS', "cadastros"); //   root/cadastros
define('PASTA_SENHAS', "senhas"); //   root/senhas

define('ARQUIVO_SENHAS', "password.sus"); //   root/cadastros/nome do usuario/password.sus
define('ARQUIVO_NOME', "nome.sus"); //   root/cadastros/nome do usuario/nome.sus
define('ARQUIVO_ENDERECO', "endereco.sus"); //   root/cadastros/nome do usuario/endereco.sus
define('ARQUIVO_DATA_NASC', "data_nascimento.sus"); //   root/cadastros/nome do usuario/data_nascimento.sus
define('ARQUIVO_CPF', "cpf.sus"); //   root/cadastros/nome do usuario/cpf.sus
define('ARQUIVO_SUS', "sus.sus"); //   root/cadastros/nome do usuario/sus.sus


define('MAX_SENHAS', 100);
define('CONSIDERAR_PRIORITARIO', 60);


session_start();

init();

function init()
{
    if (!is_dir(PASTA_CADASTROS)) {
        mkdir(PASTA_CADASTROS);
    }
    if (!is_dir(PASTA_SENHAS)) {
        mkdir(PASTA_SENHAS);
    }

    if (!is_dir('adm')) {
        mkdir('adm');
    }

}

//funcoes de login
function logar($sus, $senha)
{
    //$_GET['sus']
    //$_GET['senha']
    if (is_dir(PASTA_CADASTROS . '/' . $sus)) {
        $pass = file_get_contents(PASTA_CADASTROS . '/' . $sus . '/' . ARQUIVO_SENHAS);
        if (_md5($senha) == $pass) {
            $_SESSION['SUS'] = $sus;
            echo 'Logado com sucesso';
        } else {
            echo 'Senha incorreta';
        }
    } else {
        echo 'Usuario nao cadastrado';
    }
}

if (isset($_GET['sus']) && isset($_GET['senha']) && isset($_GET['logar'])) {
    logar($_GET['sus'], $_GET['senha']);
}

//================================================


//funcoes de cadastro
function cadastrar_usuario($nome, $endereco, $data_nascimento, $cpf, $sus, $senha)
{
    if (!is_dir(PASTA_CADASTROS . '/' . $sus)) {

        mkdir(PASTA_CADASTROS . '/' . $sus);

        //-----------------
        file_put_contents(PASTA_CADASTROS . '/' . $sus . '/' . ARQUIVO_NOME, $nome);
        file_put_contents(PASTA_CADASTROS . '/' . $sus . '/' . ARQUIVO_ENDERECO, $endereco);
        file_put_contents(PASTA_CADASTROS . '/' . $sus . '/' . ARQUIVO_DATA_NASC, $data_nascimento);
        file_put_contents(PASTA_CADASTROS . '/' . $sus . '/' . ARQUIVO_CPF, $cpf);
        file_put_contents(PASTA_CADASTROS . '/' . $sus . '/' . ARQUIVO_SUS, $sus);
        file_put_contents(PASTA_CADASTROS . '/' . $sus . '/' . ARQUIVO_SENHAS, _md5($senha));


        $_SESSION['NOME'] = $nome;
        $_SESSION['ENDERECO'] = $endereco;
        $_SESSION['DATA_NASC'] = $data_nascimento;
        $_SESSION['CPF'] = $cpf;
        $_SESSION['SUS'] = $sus;
        $_SESSION['SENHA'] = _md5($senha);




        if (!file_exists('adm/usuarios.sus')) {
            file_put_contents('adm/usuarios.sus', '');
        }
        $m = file_get_contents('adm/usuarios.sus');

        file_put_contents('adm/usuarios.sus', $m . $sus . '&');


        echo 'Usuario cadastrado com sucesso';

    } else {
        echo 'Usuario ja cadastrado';
    }
}

if (isset($_GET['cadastrar_usuario'])) {

    cadastrar_usuario(
        $_GET['nome'],
        $_GET['endereco'],
        $_GET['data_nascimento'],
        $_GET['cpf'],
        $_GET['sus'],
        $_GET['senha']
    );
}
//================================================

//obter senha

if (isset($_GET['obter_senha'])) {


    date_default_timezone_set('America/Sao_Paulo');

    $data = new DateTime();
    $dia = $data->format('d');
    $mes = $data->format('m');

    $hora = $data->format('H');
    $minutos = $data->format('i');


    $prioritario = '';
    if (ehIdoso($_GET['user'])) {
        $prioritario = 'P';
    }



    for ($i = 0; $i < MAX_SENHAS; $i++) {
        if (file_exists(PASTA_CADASTROS . '/' . $_GET['user'] . '/' . $dia . '-' . $mes . '-' . $prioritario . $i . '.sus')) {
            echo 'Voce ja retirou a senha ' . $i;
            return;
        }
    }






    $encontrou = false;

    for ($i = 0; $i < MAX_SENHAS; $i++) {
        if ($encontrou === false) {
            if (!file_exists(PASTA_SENHAS . '/' . $mes . '/' . $dia . '/' . $prioritario . $i . '.sus')) {

                $encontrou = true;



                $dados = 'Nome: ' . obter_Nome($_GET['user']) . '&' .
                    'SUS: ' . $_GET['user'] . '&' .
                    'CPF: ' . obter_cpf($_GET['user']) . '&' .
                    'Endereço: ' . obter_endereco($_GET['user']) . '&' .
                    'Data de Nascimento: ' . obter_data_nascimento($_GET['user']) . '&' .
                    'Data e hora da ficha: ' . $dia . '/' . $mes . ' as ' . $hora . ':' . $minutos;




                cadastrarSenha($mes, $dia, $prioritario . $i, $dados, $_GET['user']);
            }
        }
    }

    if ($encontrou === false) {
        echo 'As senhas ja acabaram';
    }

}




function obterSenha($sus)
{
    date_default_timezone_set('America/Sao_Paulo');

    $data = new DateTime();
    $dia = $data->format('d');
    $mes = $data->format('m');


    for ($i = 0; $i < MAX_SENHAS; $i++) {
        if (file_exists(PASTA_CADASTROS . '/' . $sus . '/' . $dia . '-' . $mes . '-' . $i . '.sus')) {
            echo $i;
            return;
        }
    }
    echo 'Nenhuma ficha';
}


function cadastrarSenha($m, $d, $i, $user, $cartaoSUS)
{

    if (!is_dir('senhas'))
        mkdir('senhas');


    if (!is_dir('senhas/' . $m))
        mkdir('senhas/' . $m);


    if (!is_dir('senhas/' . $m . '/' . $d))
        mkdir('senhas/' . $m . '/' . $d);






    file_put_contents('senhas/' . $m . '/' . $d . '/' . $i . '.sus', $user);


    file_put_contents(PASTA_CADASTROS . '/' . obter_sus($cartaoSUS) . '/' . $d . '-' . $m . '-' . $i . '.sus', $i);




    echo 'Senha cadastrada: ' . $i;
}




function obterFichasDeHoje()
{
    date_default_timezone_set('America/Sao_Paulo');

    $data = new DateTime();
    $dia = $data->format('d');
    $mes = $data->format('m');

    $fichas = '';
    for ($i = 0; $i < MAX_SENHAS; $i++) {

        if (file_exists('senhas/' . $mes . '/' . $dia . '/P' . $i . '.sus')) {
            $fichas .= 'P' . $i . '&';
        }
    }


    for ($i = 0; $i < MAX_SENHAS; $i++) {

        if (file_exists('senhas/' . $mes . '/' . $dia . '/' . $i . '.sus')) {
            $fichas .= $i . '&';
        }
    }


    if ($fichas == '') {
        $fichas = 'Nenhuma ficha';
    }
    return $fichas;
}


function obterTodosUsers()
{
    $lista = array();
    if (file_exists('adm/usuarios.sus')) {
        $lista = explode('&', file_get_contents('adm/usuarios.sus'));
    }
    return $lista;
}






function lerFicha($ficha)
{
    $ficha = str_replace('-', '', $ficha);


    date_default_timezone_set('America/Sao_Paulo');

    $data = new DateTime();
    $dia = $data->format('d');
    $mes = $data->format('m');

    $fichas = '';

    if (file_exists('senhas/' . $mes . '/' . $dia . '/' . $ficha . '.sus')) {
        $fichas = file_get_contents('senhas/' . $mes . '/' . $dia . '/' . $ficha . '.sus');
    } else if (file_exists('senhas/' . $mes . '/' . $dia . '/P' . $ficha . '.sus')) {
        $fichas = file_get_contents('senhas/' . $mes . '/' . $dia . '/P' . $ficha . '.sus');
    }
    return $fichas;
}

function obterCartaoSusDeUmaFicha($ficha)
{
    return str_replace('SUS: ', '', explode('&', lerFicha($ficha))[1]);
}

function obterCPFDeUmaFicha($ficha)
{
    $dd = explode('&', lerFicha($ficha));
    if(isset($dd[2])){
        return str_replace('CPF: ', '', $dd[2]);
    }
    else{
        return '';
    }
    
}

function obterPacienteDeUmaFicha($ficha)
{
    return str_replace('Nome: ', '', explode('&', lerFicha($ficha))[0]);
}


function mascararCPF($cpf)
{
    $f = $cpf;
    $f = str_replace('2', '*', $f);
    $f = str_replace('4', '*', $f);
    $f = str_replace('6', '*', $f);
    $f = str_replace('8', '*', $f);
    $f = str_replace('0', '*', $f);
    return $f;
}

function obter_proxima_senha_a_ser_chamada()
{


    date_default_timezone_set('America/Sao_Paulo');

    $data = new DateTime();
    $dia = $data->format('d');
    $mes = $data->format('m');

    $fichas = '';

    for ($i = 0; $i <= MAX_SENHAS; $i++) {
        if (file_exists('senhas/' . $mes . '/' . $dia . '/P' . $i . '.sus')) {
            $fichas = 'P' . $i;
            break;
        }
        if (file_exists('senhas/' . $mes . '/' . $dia . '/' . $i . '.sus')) {
            $fichas = $i;
            break;
        }
    }

    return $fichas;
}


//$_SESSION['NOME'] = $nome;
//$_SESSION['ENDERECO'] = $endereco;
//$_SESSION['DATA_NASC'] = $data_nascimento;
//$_SESSION['CPF'] = $cpf;
//$_SESSION['SUS'] = $sus;
//$_SESSION['SENHA'] = _md5($senha);


function obter_Nome($sus)
{
    return file_get_contents(PASTA_CADASTROS . '/' . $sus . '/' . ARQUIVO_NOME);
}
function obter_endereco($sus)
{
    return file_get_contents(PASTA_CADASTROS . '/' . $sus . '/' . ARQUIVO_ENDERECO);
}
function obter_data_nascimento($sus)
{
    return file_get_contents(PASTA_CADASTROS . '/' . $sus . '/' . ARQUIVO_DATA_NASC);
}

function ehIdoso($sus)
{
    //CONSIDERAR_PRIORITARIO
    date_default_timezone_set('America/Sao_Paulo');

    $data = new DateTime();
    $ano = $data->format('Y');

    $ano_naasc = explode('/', obter_data_nascimento($sus))[2];
    if (($ano - $ano_naasc) >= CONSIDERAR_PRIORITARIO) {
        return true;
    }
    return false;
}
function obter_cpf($sus)
{
    return file_get_contents(PASTA_CADASTROS . '/' . $sus . '/' . ARQUIVO_CPF);
}
function obter_sus($sus)
{
    return file_get_contents(PASTA_CADASTROS . '/' . $sus . '/' . ARQUIVO_SUS);
}



//marcar consulta
if (isset($_GET['marcar_consulta'])) {


    //$_GET['numficha']
    //$_GET['dia']
    //$_GET['hora']
    //$_GET['prioritario']
    //obterPacienteDeUmaFicha($_GET['numficha'])

    //marca pro cliente/paciente
    $consulta = $_GET['numficha'] . ' = ' . $_GET['dia'] . ' - ' . $_GET['hora'];
    file_put_contents(PASTA_CADASTROS . '/' . obterCartaoSusDeUmaFicha($_GET['numficha']) . '/consulta.sus', $consulta);



    $cpf = obterCPFDeUmaFicha($_GET['numficha']);
    $paciente = obterPacienteDeUmaFicha($_GET['numficha']);


    //muda o conteudo pra ja marcada
    date_default_timezone_set('America/Sao_Paulo');
    $data = new DateTime();
    $dia = $data->format('d');
    $mes = $data->format('m');

    file_put_contents('senhas/' . $mes . '/' . $dia . '/' . $_GET['numficha'] . '.sus', 'Consulta ja marcada para ' . $paciente . ',CPF: ' . $cpf . ', em ' . $_GET['dia'] . ' - ' . $_GET['hora']);

    rename('senhas/' . $mes . '/' . $dia . '/' . $_GET['numficha'] . '.sus', 'senhas/' . $mes . '/' . $dia . '/marcada_' . $_GET['numficha'] . '.sus');






    //marca no sistema
    $dia_da_consulta = explode('-', $_GET['dia'])[2];
    $mes_da_consulta = explode('-', $_GET['dia'])[1];
    $ano_da_consulta = explode('-', $_GET['dia'])[0];

    $hora_da_consulta = explode(':', $_GET['hora'])[0];
    $minutos_da_consulta = explode(':', $_GET['hora'])[1];


    if (!is_dir('consultas')) {
        mkdir('consultas');
    }
    if (!is_dir('consultas/' . $ano_da_consulta)) {
        mkdir('consultas/' . $ano_da_consulta);
    }
    if (!is_dir('consultas/' . $ano_da_consulta . '/' . $mes_da_consulta)) {
        mkdir('consultas/' . $ano_da_consulta . '/' . $mes_da_consulta);
    }
    if (!is_dir('consultas/' . $ano_da_consulta . '/' . $mes_da_consulta . '/' . $dia_da_consulta)) {
        mkdir('consultas/' . $ano_da_consulta . '/' . $mes_da_consulta . '/' . $dia_da_consulta);
    }

    $arquivo = 'consultas/' . $ano_da_consulta . '/' . $mes_da_consulta . '/' . $dia_da_consulta . '/' . $hora_da_consulta . '_' . $minutos_da_consulta . '.sus';
    $consultas_antigas = '';
    if (file_exists($arquivo)) {
        $consultas_antigas = file_get_contents($arquivo);
    }


    //$_GET['numficha']
    //$_GET['dia']
    //$_GET['hora']
    //$_GET['prioritario']
    //obterPacienteDeUmaFicha($_GET['numficha'])
    $consultas_antigas .= '&Ficha: '.$_GET['numficha'].','.$paciente.','.$cpf;
    file_put_contents($arquivo,$consultas_antigas);
    
    echo 'Td certo';
}




function consultas_marcadas_pra_hoje(){
    date_default_timezone_set('America/Sao_Paulo');

    $data = new DateTime();
    $dia = $data->format('d');
    $mes = $data->format('m');
    $ano = $data->format('Y');

     
    $consultas = '';

    for ($i=0; $i < 24; $i++) { 
        for ($j=0; $j < 60; $j++) { 
           
            $arquivo = 'consultas/'.$ano.'/'.$mes.'/'.$dia.'/'.$i.'_'.$j.'.sus';
            if($i<9){
                $arquivo = 'consultas/'.$ano.'/'.$mes.'/'.$dia.'/0'.$i.'_'.$j.'.sus';
                if($j<9){
                    $arquivo = 'consultas/'.$ano.'/'.$mes.'/'.$dia.'/0'.$i.'_0'.$j.'.sus';
                }
                else{
                   $arquivo = 'consultas/'.$ano.'/'.$mes.'/'.$dia.'/0'.$i.'_'.$j.'.sus';
                   
                }
            }
            else{
                if($j<9){
                    $arquivo = 'consultas/'.$ano.'/'.$mes.'/'.$dia.'/0'.$i.'_0'.$j.'.sus';
                }
                else{
                   $arquivo = 'consultas/'.$ano.'/'.$mes.'/'.$dia.'/0'.$i.'_'.$j.'.sus';
                   
                }
            }
            
            
            if(file_exists( $arquivo)){
                $consultas .= file_get_contents($arquivo);
            }
        }
    }




    return $consultas;
}












function joaat($s)
{
    return hash('joaat', $s);
}
function _md5($s)
{
    return hash('md5', $s);
}


if (isset($_GET['ping'])) {
    echo 'pong';
}
?>