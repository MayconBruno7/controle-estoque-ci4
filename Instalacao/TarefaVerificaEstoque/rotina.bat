@echo off

:: Verifica se o PHP está instalado e no PATH
echo Verificando se o PHP está instalado...
php -v
if %errorlevel% neq 0 (
    echo Erro: O PHP não está instalado ou não está no PATH.
    exit /b
)

:: Verifica se o caminho para o arquivo PHP está correto
echo Verificando se o caminho do arquivo PHP existe...
if exist "C:\Users\Maycon Bruno\Documents\Projetos\Projeto-Controle-de-estoque-v1\ci4\controle-estoque-develop\Instalacao\TarefaVerificaEstoque\verificaEstoque.php" (
    echo O arquivo PHP foi encontrado.
) else (
    echo Erro: O arquivo PHP não foi encontrado no caminho especificado.
    exit /b
)

:: Executa o script PHP
echo Executando o script PHP...
php "C:\Users\Maycon Bruno\Documents\Projetos\Projeto-Controle-de-estoque-v1\ci4\controle-estoque-develop\Instalacao\TarefaVerificaEstoque\verificaEstoque.php"

:: Verifica se a execução foi bem-sucedida
if %errorlevel% neq 0 (
    echo Erro ao executar o script PHP.
) else (
    echo Script PHP executado com sucesso.
)

pause
