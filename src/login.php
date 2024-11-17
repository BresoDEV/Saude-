<?php
require('api.php');

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="api.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
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
        input[type="number"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
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
       <h1>Login</h1>

        <h2 id="h2">&nbsp;</h2>
         
            <input type="number" id="sus" placeholder="Cartao do SUS" required>
            <input type="password" id="senha" placeholder="Senha" required>
            <br>
            <br>
            <button class="btn" id="Entrar" type="submit">Entrar</button>
         
        <div class="link">
            <p>Não tem uma conta? <a href="cadastro.php">Cadastre-se</a></p>
        </div>
       </center>
    </div>

</body> 
<script>

    if(localStorage.getItem('SUS')){
        getID('sus').value = localStorage.getItem('SUS')
    }

    


    addClick('Entrar', () => {

        if (getValue('sus') !== '') {
            if (getValue('senha') !== '') {

                fetch('api.php?logar=1&sus=' + getValue('sus') + '&senha=' + getValue('senha'))
                    .then(response => {
                        return response.text()
                    })
                    .then(data => {
                        //console.log(data)
                        getID('h2').innerHTML = data
                        if (data == 'Logado com sucesso') {
                            goTo('index.php')
                        }
                    })

            } else {
                fundoVM('senha')
            }
        } else {
            bordaVM('sus')
        }


    })



    //fetch('api.php?ping=1')
    //    .then(response => {
    //        return response.text()
    //    })
    //    .then(data => {
    //        getID('h2').innerHTML = data
    //    })

</script>

</html>