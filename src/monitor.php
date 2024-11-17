<?php
require('api.php');

$prox_senha = obter_proxima_senha_a_ser_chamada();
$prioritario = stripos($prox_senha, 'P') !== false;
echo '<h1>' . $prox_senha . '</h1>';
echo '<h1>Prioritario: ' . $prioritario . '</h1>';
echo '<h1>Nome: ' . obterPacienteDeUmaFicha($prox_senha) . '</h1>';
echo '<h1>CPF: ' . mascararCPF(obterCPFDeUmaFicha($prox_senha)) . '</h1>';
//
?>