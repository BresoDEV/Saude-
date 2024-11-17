<?php
require('api.php');
if (isset($_SESSION['SUS'])) {
    echo '
    <script>
    localStorage.setItem("SUS","' . $_SESSION['SUS'] . '");
    </script>
    ';
} else {
    echo '
    <script>
    window.location.href="login.php";
    </script>
    ';
}
?>
<script>
    if (!localStorage.getItem('SUS')) {
        window.location.href = 'login.php'
    } else {
        console.log('SUS: ' + localStorage.getItem('SUS'));
    }
</script>




<!--------------------------------------------------->
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retirar Senha</title>
    <script src="api.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .btn {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .active-tickets {
            margin-top: 30px;
        }

        .ticket {
            padding: 8px;
            background-color: #f1f1f1;
            margin-bottom: 5px;
            border-radius: 4px;
        }

        h1 {
            font-size: 50px;
            padding: 10px;
            border-radius: 25px;
            color: white;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Bem vindo(a)
            <?php echo obter_Nome($_SESSION['SUS']); ?>
        </h2>
        <h2 id="h2"></h2>


        <button class="btn" id="ObterSenha">Retirar Senha</button>


        <div class="active-tickets" id="active-tickets">
            <h2 id="Senhas Ativas">Senhas Ativas</h2>



            <h1 id="ficha">&nbsp;</h1>

        </div>
    </div>

</body>



<!--------------------------------------------------->










<script>
    if (localStorage.getItem('ficha')) {
        getID('ficha').innerHTML = localStorage.getItem('ficha')


        if (localStorage.getItem('ficha').includes('Prioritario ')) {
            getID('ficha').style.backgroundColor = 'rgb(200 100 100)'
        } else {
            getID('ficha').style.backgroundColor = 'rgb(100 100 200)'
        }

        console.log('Ficha: ' + localStorage.getItem('ficha'))
    }
        //obterSenha()
</script>

</body>
<script>

    addClick('ObterSenha', () => {


        fetch('api.php?obter_senha=1&user=' + localStorage.getItem('SUS'))
            .then(response => {
                return response.text()
            })
            .then(data => {
                console.log(data)
                getID('h2').innerHTML = data

                setTimeout(() => {

                    if (data.includes('Senha cadastrada: P')) {
                        localStorage.setItem('ficha', data.replace('Senha cadastrada: P', 'Prioritario '))
                    }
                    else if (data.includes('Senha cadastrada: ')) {
                        localStorage.setItem('ficha', data.replace('Senha cadastrada: ', ''))
                    }


                    if (localStorage.getItem('ficha')) {
                        getID('ficha').innerHTML = '<b>' + localStorage.getItem('ficha') + '</b>'
                        if (localStorage.getItem('ficha').includes('Prioritario ')) {
                            getID('ficha').style.backgroundColor = 'rgb(200 100 100)'
                        } else {
                            getID('ficha').style.backgroundColor = 'rgb(100 100 200)'
                        }
                        console.log('Ficha: ' + localStorage.getItem('ficha'))
                    }
                }, 2000);

            })


    })


        <?php
        if (file_exists(PASTA_CADASTROS . '/' . $_SESSION['SUS'] . '/consulta.sus')) {
            if ('' !== file_get_contents(PASTA_CADASTROS . '/' . $_SESSION['SUS'] . '/consulta.sus')) {
                
                $data = explode('=',file_get_contents(PASTA_CADASTROS . '/' . $_SESSION['SUS'] . '/consulta.sus'))[1];
                
                echo "

            //localStorage.removeItem('ficha')
            getID('ObterSenha').style.display = 'none'
            getID('Senhas Ativas').innerHTML = 'Consultas:'
            getID('ficha').innerHTML = '" . $data . "'
            if(localStorage.getItem('ficha').includes('Prioritario ')){
                getID('ficha').style.backgroundColor = 'rgb(200 100 100)'
            }else{
                getID('ficha').style.backgroundColor = 'rgb(100 100 200)'
            }
            ";

            }
        }
        //localStorage.getItem('ficha')
        ?>

</script>

</html>