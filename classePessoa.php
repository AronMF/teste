<?php
// 6funcoes
Class Pessoa{
    
    private $pdo;

    public function __construct($host,$dbname,$user,$password)
    {
        try {
            $this->pdo = new PDO('mysql:host='.$host.';dbname='.$dbname,$user,$password);

        } catch (PDOException $e) {
            echo "error on the BDD  : " .$e->getMessage();
        }catch (Exception $e) {
            echo "error Others  : " .$e->getMessage();
        }
    }
    // Buscar os dados e colocar no canto direito 
    public function buscarDados()
    {
        $res = array();
        $cmd = $this->pdo->query("SELECT * FROM cliente ORDER BY firstname ASC");
        $res = $cmd->fetchAll(PDO::FETCH_ASSOC);

        return $res;
    }

    public function cadastrarPessoa($nome,$telefone,$email)
    {

        // antes de cadastrar vamos ver se possou email
        $cmd = $this->pdo->prepare("SELECT id FROM cliente WHERE  email =:e");
        $cmd->bindValue(':e',$email);
        $cmd->execute();

        if($cmd->rowCount() > 0){
            return false;
        }else{   //não foi cadastrada
            $cmd = $this->pdo->prepare("INSERT INTO cliente (firstname, 
                                                                telefone, 
                                                                email
                                            )                    
                                            VALUES(:f, :t, :e)");
            $cmd->bindValue(":f",$nome);
            $cmd->bindValue(":t",$telefone);
            $cmd->bindValue(":e",$email);
            $cmd->execute();
            return  true;

        }

    }
    public function excluir($id){
        echo  $sql = "DELETE FROM cliente WHERE id = $id";
         $this->pdo->query($sql);
    }

    
    public function excluirPessoa($id){
        // echo "error on the prepare delete";
        // echo'<br>';
        // echo $id;
        // echo'<br>';

        echo  $sqli = "DELETE FROM cliente WHERE id = :id";
        $cmd = $this->pdo->prepare($sqli);
        $cmd->bindValue(':id',$id);
        $cmd->execute();
    }

    // BUSCAR PESSOAS 
    public function buscarDadosPessoa($id){

        $res = array();
        $cmd = $this->pdo->prepare("SELECT * FROM cliente where id = :id");
        $cmd->bindValue(':id', $id);
        $cmd->execute();

        $res = $cmd->fetch(PDO::FETCH_ASSOC);
        return $res;
    }


    public function atualizarDados($id, $nome, $telefone, $email){

        // $cmd = $this->pdo->prepare("SELECT id FROM cliente WHERE  email =:e");
        // $cmd->bindValue(':e',$email);
        // $cmd->execute();

        // if($cmd->rowCount() > 0){
        //     return false;
        // }else{   //não foi cadastrada
            $sql = "UPDATE cliente SET firstname = :n, telefone = :t, email = :e WHERE  id = :id";

            $cmd = $this->pdo->prepare($sql);
            $cmd->bindValue(":n",$nome);
            $cmd->bindValue(":t",$telefone);
            $cmd->bindValue(":e",$email);
            $cmd->bindValue(":id",$id);
            $cmd->execute();
        //     return true;
        // }
    }
}