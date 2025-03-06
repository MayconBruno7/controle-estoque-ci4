#!/bin/bash

# Verifica se o PHP está instalado e no PATH
echo "Verificando se o PHP está instalado..."
php -v &>/dev/null
if [ $? -ne 0 ]; then
    echo "Erro: O PHP não está instalado ou não está no PATH."
    exit 1
fi

# Verifica se o caminho para o arquivo PHP está correto
echo "Verificando se o caminho do arquivo PHP existe..."
if [ -f "/usr/bin/php" ]; then
    echo "O arquivo PHP foi encontrado."
else
    echo "Erro: O arquivo PHP não foi encontrado no caminho especificado."
    exit 1
fi

# Executa o script PHP
echo "Executando o script PHP..."
	php ~/Documentos/Projetos/Projeto-Controle-de-estoque-v1/ci4/controle-estoque-final/Instalacao/TarefaVerificaEstoque/verificaEstoque.php

# Verifica se a execução foi bem-sucedida
if [ $? -ne 0 ]; then
    echo "Erro ao executar o script PHP."
else
    echo "Script PHP executado com sucesso."
fi

