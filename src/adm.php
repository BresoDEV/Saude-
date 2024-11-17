<?php
require('api.php');

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração de Senhas - UBS</title>
    <script src="api.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .btn {
            padding: 8px 16px;
            font-size: 14px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn-attended {
            background-color: #008CBA;
        }

        .btn-attended:hover {
            background-color: #007bb5;
        }

        .container a {
            text-decoration: none;
            color: #4CAF50;
        }

        .priori {
            background-color: rgb(200 100 100);
        }
        .normal {
            background-color: rgb(100 150 100);
        }
    </style>
</head>

<body>

    <div class="container">

        <?php

        //funcionando, mas não implementado
        //echo consultas_marcadas_pra_hoje();
        ?>





        <h1>Administração de Senhas - UBS</h1>
        <table>
            <thead>
                <tr>
                    <th class="priori">Senha</th>
                    <th class="priori">Nome</th>
                    <th class="priori">SUS</th>
                    <th class="priori">Data</th>
                    <th class="priori" colspan="3">
                        <center>Ações</center>
                    </th>
                </tr>
            </thead>
            <tbody>

                <?php

                //FUNCIONANDO
                //
                // echo 'Usuarios:<br><br>';
                // $membros = obterTodosUsers();
                // foreach ($membros as $m) {
                //     if ($m !== '') {
                //         echo '<button>' . obter_Nome($m) . '</button><br>';
                //     }
                // }
                // echo '<br><hr><br>';
                

                //===============================================
                

                $fichas = explode('&', obterFichasDeHoje());
                foreach ($fichas as $num) {


                    if ($num !== '') {
                        if (stripos($num, 'P') !== false) {

                            $hh = explode('&', lerFicha($num));
                            

                            echo '
                            
                    
                            <tr>
                                <td>'.$num.'</td>
                                <td>'.str_replace('Nome:','',$hh[0]).'</td>
                                <td>'.str_replace('SUS:','',$hh[1]).'</td>
                                <td>'.str_replace('Data e hora da ficha: ','',$hh[5]).'</td>
                                <td>
                                    <button id="atendido_' . $num . '" class="btn btn-attended">Atendido</button>
                                </td>
                                <td>
                                    <button class="btn btn-attended" id="remover_' . $num . '">Remover</button>
                                </td>
                                <td>
                                    <input type="date" id="dia_' . $num . '">
                                    <input type="time" id="hora_' . $num . '">
                                    <button id="marcar_' . $num . '" class="btn btn-attended" style="width:100%">Marcar</button>
                                </td>
                            </tr>
                            
                        ';
                        }




 

                    }
                }
                ?>
            </tbody>
        </table>



        <table>
            <thead>
                <tr>
                    <th class="normal">Senha</th>
                    <th class="normal">Nome</th>
                    <th class="normal">SUS</th>
                    <th class="normal">Data</th>
                    <th class="normal" colspan="3">
                        <center>Ações</center>
                    </th>
                </tr>
            </thead>
            <tbody>

                <?php

                //FUNCIONANDO
                //
                // echo 'Usuarios:<br><br>';
                // $membros = obterTodosUsers();
                // foreach ($membros as $m) {
                //     if ($m !== '') {
                //         echo '<button>' . obter_Nome($m) . '</button><br>';
                //     }
                // }
                // echo '<br><hr><br>';
                

                //===============================================
                

                $fichas = explode('&', obterFichasDeHoje());
                foreach ($fichas as $num) {


                    if ($num !== '') {
                        if (stripos($num, 'P') !== false) {

                           
                        }else{
                            $hh = explode('&', lerFicha($num));
                            
                            if(isset($hh[5])){
                                echo '
                            
                    
                            <tr>
                                <td>'.$num.'</td>
                                <td>'.str_replace('Nome:','',$hh[0]).'</td>
                                <td>'.str_replace('SUS:','',$hh[1]).'</td>
                                <td>'.str_replace('Data e hora da ficha: ','',$hh[5]).'</td>
                                <td>
                                    <button id="atendido_' . $num . '" class="btn btn-attended">Atendido</button>
                                </td>
                                <td>
                                    <button class="btn btn-attended" id="remover_' . $num . '">Remover</button>
                                </td>
                                <td>
                                    <input type="date" id="dia_' . $num . '">
                                    <input type="time" id="hora_' . $num . '">
                                    <button id="marcar_' . $num . '" class="btn btn-attended" style="width:100%">Marcar</button>
                                </td>
                            </tr>
                            
                        ';
                            }

                            
                        }





                        

                    }
                }
                ?>
            </tbody>
        </table>

    </div>



</body>
<script>

    const botoes = document.querySelectorAll('*')

    botoes.forEach(fichas => {


        if (fichas.id.includes('atendido_')) {

            fichas.addEventListener('click', () => {
                const numficha = fichas.id.replace('atendido_', '');
                const prioritario = numficha.includes('P');
                alert('Atendido\nId: ' + numficha + '\nPrioritario: ' + prioritario)
            })

        }
        //----------------------------------
        if (fichas.id.includes('remover_')) {

            fichas.addEventListener('click', () => {
                const numficha = fichas.id.replace('remover_', '');
                const prioritario = numficha.includes('P');
                alert('Remover\nId: ' + numficha + '\nPrioritario: ' + prioritario)
            })

        }
        //--------------------------------
        if (fichas.id.includes('marcar_')) {

            fichas.addEventListener('click', () => {
                const numficha = fichas.id.replace('marcar_', '');
                const prioritario = numficha.includes('P');

                const dia = document.getElementById('dia_' + numficha).value
                const hora = document.getElementById('hora_' + numficha).value

                alert('Marcar\nId: ' + numficha +
                    '\nDia: ' + dia +
                    '\nHora: ' + hora +
                    '\nPrioritario: ' + prioritario)


                //-----------------------
                fetch('api.php?marcar_consulta=1' +
                    '&numficha=' + numficha +
                    '&dia=' + dia +
                    '&hora=' + hora +
                    '&prioritario=' + prioritario +
                    '')
                    .then(response => {
                        return response.text()
                    })
                    .then(data => {
                        console.log(data)
                        //document.title = data

                        setTimeout(() => {


                        }, 2000);

                    })

                //----------------------

            })


        }







    });


</script>

</html>