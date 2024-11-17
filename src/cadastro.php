<?php
require('api.php');

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="api.js"></script>
    <title>Cadastro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            border: 3px solid #ddd;
        }

        h1 {
            text-align: center;
            font-size: 24px; 
            animation: ee 2s normal;
        }

        input {
            width: 90%;
            padding: 10px;
            margin: 5px 0;
            border: 3px solid #ddd;
            border-radius: 4px;
            animation: ee 2s normal;
        }

        .btn {
            width: 90%;
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            animation: ee 2s normal;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .link {
            text-align: center;
            margin-top: 10px;
            animation: ee 2s normal;
        }

        img{
            width: 30%;
            animation: ee 1s normal;
        }

        @keyframes ee{
            0%{
                scale: 0;
            }
            100%{
                scale: 1;
            }
        }
    </style>
</head>

<body>

    <div class="container">

    

        <center>
        <img src="logo.png" alt="">
        <h1>Cadastro</h1>

        <h2 id="h2">&nbsp;</h2>
        <input type="text" id="nome" placeholder="Nome completo"><br>
        <input type="text" id="endereco" placeholder="Endereço"><br>
        <input type="text" id="data_nascimento" placeholder="Data de Nascimento"><br>
        <input type="number" id="cpf" placeholder="CPF"><br>
        <input type="number" id="sus" placeholder="Cartao do SUS"><br>
        <input type="password" id="senha" placeholder="Senha"><br>
        <input type="password" id="confirmar_senha" placeholder="Repetir a Senha"><br>
        <button class="btn" type="submit" id="Cadastrar">Cadastrar</button>
        </center>


        <div class="link">
            <p>Já tem uma conta? <a href="login.php">Faça login</a></p>
        </div>
    </div>

</body>

<script>



    const inputs = [
        'nome', 'endereco', 'data_nascimento',
        'cpf', 'sus', 'senha', 'confirmar_senha'
    ]

    addClick('Cadastrar', () => {

        var tdok = true;
        inputs.forEach(e => {

            if (getID(e).value !== '') {

            } else {
                tdok = false
                bordaVM(e)
            }

        });



        if (tdok) {
            if (senha.value === confirmar_senha.value) {



                fetch('api.php?cadastrar_usuario=1' +
                    '&nome=' + getValue('nome') +
                    '&endereco=' + getValue('endereco') +
                    '&data_nascimento=' + getValue('data_nascimento') +
                    '&cpf=' + getValue('cpf') +
                    '&sus=' + getValue('sus') +
                    '&senha=' + getValue('senha') +
                    '')
                    .then(response => {
                        return response.text()
                    })
                    .then(data => {
                        console.log(data)
                        getID('h2').innerHTML = data

                        if (data.includes('sucesso')) {
                            setTimeout(() => {
                                goTo('index.php')
                            }, 2000);
                        }
                        //goTo('index.php')
                    })






            } else {
                h2.innerHTML = 'Senhas estão diferentes'
                bordaVM(confirmar_senha)
                bordaVM(senha)
            }
        }




    })


    

    setInterval(() => {
        if (data_nascimento.value.length == 2) {
            data_nascimento.value += '/'
        }
        if (data_nascimento.value.length == 5) {
            data_nascimento.value += '/'
        }
    }, 1);

</script>
</html>
