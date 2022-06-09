<?php
    require_once'classePessoa.php';
     $p = new Pessoa("localhost","pessoa",'root','root');

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <title>Cadastro de Dados</title>
        <link rel="stylesheet" href="estilo.css">
    </head>
    <body>
        <?php
            if (isset($_POST['nome'])) { //botao de cadastrar ou editar 
                if (isset($_GET['id_up']) && !empty($_GET['id_up'])) {
                    $id_upd = addslashes($_GET['id_up']);
                    $nome = addslashes($_POST['nome']);
                    $telefone = addslashes($_POST['telefone']);
                    $email = addslashes($_POST['email']);
                    if(!empty($nome)&& !empty($telefone) && !empty($email)){
                        echo "Atualizando";
                        echo'<br>';
                        // EDITAR PESSOA
                        $p->atualizarDados($id_upd, $nome,$telefone,$email);
                        header("location: index.php");

                            
                    }else{
                        echo "prencha todos os dados";
                    }
                }
                //////////--------cadastrar
                else{
                    $nome = addslashes($_POST['nome']);
                    $telefone = addslashes($_POST['telefone']);
                    $email = addslashes($_POST['email']);
                    if(!empty($nome)&& !empty($telefone) && !empty($email)){
                        echo "ENTREI";
                        // CADASTRAR PESSOA
                        if(!$p->cadastrarPessoa($nome,$telefone,$email)){
                            echo "email ja esta cadastrado";
                        }
                    }else{
                        echo "prencha todos os dados";
                    }
                }
            }
        
        ?>

        <?php
        if (isset($_GET['id_up'])) { //EDITAR 
            $id_up = addslashes($_GET['id_up']);
            $res = $p->buscarDadosPessoa($id_up);

        }
        ?>
        <section id=izquerda>
            <form  method="POST" >
                <h2 id="titulo">CADASTRAR PESSOA</h2>
                <label  for="nome">Nome</label>
                <input type="text" name="nome" id="nome" value= "<?php if(isset($res)){echo $res['firstname'];}?>">
                <label  for="telefone">Telefone</label>
                <input type="text" name="telefone" id="telefone" value= "<?php if(isset($res)){echo $res['telefone'];}?>">
                <label  for="email">Email</label>
                <input type="text" name="email" id="email"value= "<?php if(isset($res)){echo $res['email'];}?>">
                <input type="submit" VALUE= "<?php if(isset($res)){echo "Atualizar";}else{echo "Cadastrar";}?>">
            </form>
        </section>
        <section id=direita>
            <table>
                <tr id="titulo">
                    <td>NOME</td>
                    <td>TELEFONE</td>
                    <td colspan="2">EMAIL</td>
                </tr>

    

        <?php
            $dados = $p->buscarDados();
            if(count($dados) > 0){
                for ($i=0; $i < count($dados); $i++) { 
                    echo'<tr>';
                    foreach ($dados[$i] as $k => $v) {
                        if($k !="id"){
                            echo'<td>'.$v.'</td>';
                        }
                    }
        ?>
                    <td id=bottom>
                        <?php echo $dados[$i]['id'];?>
                        <a href="index.php?id_up=<?php echo $dados[$i]['id'];?>">Editar</a>
                        <a href="index.php?id=<?php echo $dados[$i]['id'];?>">Excluir</a>
                    </td>

        <?php
                }
                echo'</tr>';
            }else{ //o banco esta vazio
                echo " ainda não há pessoas cadastradas";
            }
        ?>  
            </table>
        </section>

    </body>
</html>
        <?php
            if(isset($_GET['id']))
            {
                $id_pessoa = addslashes($_GET['id']);
                
                $p->excluir($id_pessoa);

                header("location: index.php");
            }
        ?>