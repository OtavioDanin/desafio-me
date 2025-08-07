# 🚀 Processamente de Log da API Gateway - Laravel Commands

## 📚 Propósito da Aplicação

Este é um sistema CLI back-end para gerar relatórios cvs personalizados e automáticos a partir de arquivo de log gerado por um sistema de API Gateway.

## 📋 Descrição
A aplicação faz a leitura do arquivo de log, armazena os dados relevantes no banco de dados e a partir disso exporta relatórios(Requisições por consumido, Requisições por serviço e Tempo médio de request, proxy e gateway por serviço) no formato csv.
Sistema para processamento de logs de API Gateway com:
- Importação de dados para banco relacional
- Geração de relatórios em CSV
- Comandos Artisan customizados

## ✨ Funcionalidades

* **Processamento Log:**
    * Faz a leitura do arquivo de log em um diretório.
    * Extrai os dados necessários para a geração dos relatórios.
    * Salva os dados extraidos no em uma tabela no banco de dados.
* **Relatórios:**
    * Obtem do banco os dados necessários para gerar cada um dos relatórios.
        * Requisições por consumido.
        * Requisições por serviço.
        * Tempo médio de request, proxy e gateway por serviço.
    * Com a obteção dos dados específicos, exporta cada um  destes relatórios para arquivos csv em um diretório.

## 🛠 Tecnologias
As ferramentas de solução proposta para este desafio back-end foram:
- Laravel 12 (CLI Commands).
- PostgreSQL 17.
- PHP 8.3+ (Opcache + JIT).

## 🚀🔧 Como Instalar e Rodar

Siga os passos abaixo para configurar e executar a aplicação em seu ambiente local.

### Passos de Instalação do Projeto com Docker

Certifique-se de ter instalado em sua máquina:

* Docker
* Docker Composer

1.  **Clonar repositório:**
    ```bash
    git clone [repo-url] && cd [project-folder]
2.  **Faça o build das imagens e start dos container, executando:**
    ```bash
    docker network create me_network
    docker compose up -d
    ```
3.  **Entre no container desafio-me, e execute:**
    ```bash
    docker exec -it desafio-me sh
    
4.  **Gere a Chave da Aplicação:**
    ```bash
    php artisan key:generate

5.  **Instale as Dependências do Composer:**
    ```bash
    composer install # ou composer install --no-dev -o -a para produção
    ```
6.  **Execute as Migrações e Seeds:**
    Isso criará as tabelas no banco de dados.
    ```bash
    php artisan migrate:fresh
7.  **Execute o projeto(CLI Commands):**
    * Processamento Log.
    ```bash
    php artisan app:process-gateway-logs
    ```
    * Geração de Relatórios.
    ```bash
    php artisan app:generate-gateway-reports

## 📍 Visualizar o resultado da Aplicação
Os relatórios estarão na raiz da aplicação, na pasta "reports"
    
