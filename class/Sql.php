<?php

class Sql extends PDO # Criado a classe chamada Sql que extende da classe PDO
{
	private $conexao; # Definido a variavel de conexão em modo privado.

	public function __construct(){ # metodo construtor para carregar as config. conexão
		$this->conexao = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
	}


	#Recebe os comandos e os dados
	private function setParams($cmd, $parametros = array())
	{
		foreach ($parametros as $key => $value) {
			#chama o metrodo abaixo que pega os parametros
			$this->setParam($key, $value);
		}
	}


	#Recebe apenas um parametro
	private function setParam($cmd, $key, $value)
	{
		$cmd->bindParam($key, $value);
	}


	# Função criada para executar os comandos. $consultaSQL recebe os comandos de consulta.
	public function query($consultaSQL, $params = array())
	{
		#Variavel $comando recebe os dados do objeto conexão.
		$comando = $this->conexao->prepare($consultaSQL);

		#Recebe o conjunto de parametros do metodo setParams (acima)
		$this->setParams($comando, $params);

		#Executa o comando.
		$comando->execute();

		return $comando;

	}

	#Metodo para o comando select
	public function select($consultaSQL, $params = array()):array
	{
		#Variavel $comando recebe o metódo query usando os parametros da função.
		$comando = $this->query($consultaSQL, $params);


		return $comando->fetchAll(PDO::FETCH_ASSOC);

	}


}


?>