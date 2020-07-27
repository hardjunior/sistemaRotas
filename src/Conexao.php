<?php

namespace Src;

final class Conexao
{
    private static $conexao;

    /**
     * Singleton: Método construtor privado para impedir classe de gerar instâncias
     *
     */
    private function __construct(){
        error_reporting(E_ALL);
        ini_set('display_errors', true);
    }
 
    private function __clone()
    {}
 
    private function __wakeup()
    {}
    

    /**
     * Método estático que devolve a instancia ativa
     *
    */
    public static function getInstance(): \PDO
    {
        //string $arquivo
        echo "<pre>";
        if(self::$conexao == NULL) {
        // Receber os dados do arquivo
            self::$conexao = self::make(self::load());
            self::$conexao->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            self::$conexao->exec("set names utf8");
        }
        return self::$conexao;
    }
    
    /**
     * Método estático privado que permite o carregamento do arquivo
     * @param $arquivo string
     * @return array
     */
    private static function load(): array
    {
        // $arquivo = 'subsdiretorio/' .$arquivo.'.ini';
        // echo $arquivo;exit;
        $nameServer = explode('.',$_SERVER['HTTP_HOST'])[0];
        $arquivo = '../{$nameServer}.ini';

        if(file_exists($arquivo)) {
            $dados = parse_ini_file($arquivo,'mysql')['mysql'];
        } else {
            throw new \Exception('Erro: Arquivo não encontrado');
        }
        return $dados;
    }

    /**
     * Método montar string de conexao e gerar o objeto PDO
     * @param $dados array
     * @return PDO
    */
 
    private static function make(array $dados): \PDO
    {
        // capturar dados
        $sgdb     = isset($dados['sgdb']) ? $dados['sgdb'] : NULL;
        $usuario  = isset($dados['usuario']) ? $dados['usuario'] : NULL;
        $senha    = isset($dados['senha']) ? $dados['senha'] : NULL;
        $banco    = isset($dados['banco']) ? $dados['banco'] : NULL;
        $servidor = isset($dados['servidor']) ? $dados['servidor'] : NULL;
        $porta    = isset($dados['porta']) ? $dados['porta'] : NULL;
        
        if(!is_null($sgdb)) {
            // selecionar banco - criar string de conexão
            switch (strtoupper($sgdb)) {
                case 'MYSQL' : 
                {
                    $porta = isset($porta) ? $porta : 3306 ; 
                    return new \PDO("mysql:host={$servidor};port={$porta};dbname={$banco}", $usuario, $senha);
                }
                break;
                case 'MSSQL' :
                {
                    $porta = isset($porta) ? $porta : 1433 ;
                    return new PDO("mssql:host={$servidor},{$porta};dbname={$banco}", $usuario, $senha);
                    break;
                } 
                case 'PGSQL' :
                {    
                    $porta = isset($porta) ? $porta : 5432 ;
                    return new PDO("pgsql:dbname={$banco}; user={$usuario}; password={$senha}, host={$servidor};port={$porta}");
                    break;
                }
                case 'SQLITE' : return new PDO("sqlite:{$banco}");
                break;
                case 'OCI8' : return new PDO("oci:dbname={$banco}", $usuario, $senha);
                break;
                case 'FIREBIRD' : return new PDO("firebird:dbname={$banco}",$usuario, $senha);
                break;
            }
        } else {
            throw new Exception('Erro: tipo de banco de dados não informado');
        }
    }

    // $con = Conexao::getInstance();
    // echo (is_a($con, '\PDO'))?'Instanciado com êxito' :'Não deu certo!';
    // exit;
}