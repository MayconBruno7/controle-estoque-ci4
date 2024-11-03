@echo off
:: Configurações do banco de dados
set host=localhost
set user=root
set pass=
set db=controle_estoque
set backupDir="C:\Users\TI\Desktop\!\ADS\Estudos\Programacao Web\Projeto Controle de estoque-v1\Projeto Controle de estoque-v1.0\controle-estoque-develop\Instalacao\banco de dados\backup banco"

:: Adiciona o caminho do MySQL bin ao PATH, se necessário
set PATH=%PATH%;C:\wamp64\bin\mysql\mysql8.0.33\bin

:: Criar diretório de backups se não existir
if not exist %backupDir% mkdir %backupDir%

:: Obter a data e hora atuais formatadas corretamente para o nome do arquivo
for /f "tokens=2-4 delims=/ " %%a in ('date /t') do set date=%%c-%%b-%%a
for /f "tokens=1-2 delims=: " %%a in ('time /t') do set time=%%a-%%b

:: Nome do arquivo de backup
set backupFile=%backupDir%\backup_%date%_%time%.sql

:: Remover espaços em branco do nome do arquivo
set backupFile=%backupFile: =%

:: Comando para realizar o backup
mysqldump --host=%host% --user=%user% --password=%pass% %db% > %backupFile%

:: Verifica se o backup foi realizado com sucesso
if %errorlevel% equ 0 (
    echo Backup realizado com sucesso em: %backupFile%
) else (
    echo Erro ao realizar o backup.
)
pause
