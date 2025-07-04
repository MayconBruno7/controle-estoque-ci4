# 📦 Controle de Estoque - CI4

Sistema de Controle de Estoque desenvolvido em **CodeIgniter 4**, ideal para empresas que precisam gerenciar produtos, fornecedores e movimentações de forma eficiente e organizada.

---

## ⚙️ Descrição do Sistema

O **Sistema de Controle de Estoque** é uma solução completa para gerenciamento de produtos e estoque, com funcionalidades como:

✅ Registro de entradas e saídas de produtos  
✅ Validação de documentos fiscais (CNPJ, CPF)  
✅ Relatórios periódicos e por fornecedor  
✅ Controle detalhado de movimentações  
✅ Painel com gráficos de vendas e estoque  

---

## ✨ Funcionalidades Principais

### 🔒 Logs de Alterações
- Cada alteração (inclusão, edição ou exclusão) é registrada.
- Informações armazenadas:
  - Tabela afetada
  - Ação realizada
  - Data/hora
  - Usuário responsável
- Garantia de rastreabilidade total no sistema.

---

### 🔍 Busca e Relatórios
- Filtros por data (mensal, anual, semanal).
- Relatórios personalizados por fornecedor.
- Visão clara das movimentações de estoque.

---

### 📄 Validação de Documentos
- Validação automática de:
  - **CNPJ**
  - **CPF**
- Evita cadastros inconsistentes e problemas fiscais.

---

### 📧 Envio de E-mails
- Notificações automáticas sobre:
  - Movimentação de produtos
  - Alerta de estoque baixo
- Integração com **tarefas CRON** para envios automáticos.

---

### 📊 Relatórios e Exportações
- Relatórios disponíveis em:
  - **PDF**
  - **XLSX**
  - **CSV**
- Flexibilidade para análise e compartilhamento de dados.

---

### 📈 Gráficos de Vendas e Estoque
- Gráficos interativos para:
  - Visualização diária das vendas
  - Acompanhamento do desempenho do estoque

---

### 💬 Fale Conosco
- Canal direto de comunicação com o suporte.
- Envio rápido de dúvidas ou solicitações.

---

## 🗄️ Estrutura do Banco de Dados

O sistema utiliza o banco **controle_estoque**, composto por tabelas inter-relacionadas:

| Tabela               | Descrição                                                                 |
|----------------------|--------------------------------------------------------------------------|
| **Logs**             | Registra todas as alterações realizadas no sistema.                     |
| **Produtos**         | Informações dos produtos: descrição, quantidade, status, fornecedor.    |
| **Movimentações**    | Registra entradas e saídas de produtos, com dados de fornecedores.      |
| **Fornecedores**     | Cadastro de fornecedores: nome, CNPJ, endereço e contato.               |
| **Funcionários**     | Cadastro de colaboradores da empresa.                                   |
| **Cargos**           | Controle dos cargos disponíveis.                                        |
| **Setores**          | Organização do estoque por setores.                                     |
| **Cidades/Estados**  | Geolocalização dos fornecedores.                                        |

---

## 🎯 Considerações Finais

O **Controle de Estoque CI4** oferece:

✅ Gestão prática e eficiente do inventário  
✅ Segurança e rastreamento completo das operações  
✅ Análises detalhadas com relatórios e gráficos  
✅ Notificações inteligentes por e-mail  
✅ Interface moderna e intuitiva  

Sistema ideal para empresas que buscam eficiência no controle de produtos e estoque.

---

## 🖼️ Imagens do Sistema

![Tela 6](https://github.com/user-attachments/assets/c2fb5a52-6506-460c-8a34-74739cc0fa54)  
![Tela 5](https://github.com/user-attachments/assets/0c11a238-bbb9-4cd1-a295-f694f172c919)  
![Tela 4](https://github.com/user-attachments/assets/34c61b4f-7de3-48a0-bdf0-61fc7e572719)  
![Tela 3](https://github.com/user-attachments/assets/8fb8d3d0-362c-4762-913d-99b9fd971724)  
![Tela 2](https://github.com/user-attachments/assets/6e0a3ae6-b847-4bde-b35e-4932721c5bdf)  
![Tela 1](https://github.com/user-attachments/assets/6399bceb-9788-42a4-90a4-780775801961)  

---

## 🚀 Tecnologias Utilizadas

- PHP 8+  
- Framework **CodeIgniter 4**  
- MySQL 8+  
- Bootstrap 5 (interface)  
- Gráficos interativos (Chart.js ou equivalente)  
- Exportação de relatórios (PDF, Excel, CSV)  


