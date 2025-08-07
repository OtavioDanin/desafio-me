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
    * Com a obtenão dos dados específicos, exporta estes relatórios para um arquivo csv em um diretório.

## 🛠 Tecnologias
- Laravel 12
- PostgreSQL 17
- PHP 8.3+(Opcache + JIT)

## 🔧 Instalação

1. **Clonar repositório**:
```bash
git clone [repo-url] && cd [project-folder]