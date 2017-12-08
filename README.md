# TasksVoxus
## por Paulo Salvatore

Essa aplicação foi desenvolvida para o 'DesafioDevVoxus' que consistia em desenvolver uma aplicação web que atendesse alguns requisitos básicos de programação.

## Instalação

1. Faça o download do projeto
2. Coloque a pasta do projeto na pasta de algum servidor apache (esse projeto foi desenvolvido no Xampp 5.6.3)
3. Importe o banco de dados (rootProjeto/sql) ou utilize o comando no console bin\cake migrations migrate (certifique-se que o console está na pasta raiz do projeto)
4. Acesse a URL http://127.0.0.1/usuarios/login e faça o cadastro via formulário ou via Google+.
5. Adicione uma Task clicando no botão 'Add'.
6. É possível adicionar múltiplos arquivos às Tasks, visualizá-los e marcá-la como concluído.

## Estrutura/Diretórios importantes

1. A estrutura dos arquivos segue o padrão MVC.
2. Diretório com os Controllers: src/Controller
3. Diretório com os Models: src/Model/Table
4. Diretório com as Views: src/Template
5. Diretório com a classe de upload de arquivos: config/bootstrap.php
6. Arquivo com atualização de usuário src/Controller/AppController.php
7. Diretório das migrations (criação da base de dados): config/Migrations
8. Tabela 'HistoricosAuditoria' contém todas as modificações realizadas

## Tempo demorado

Até o estágio atual foram cerca de 7-8 horas de desenvolvimento, com algumas pausas.

## Dificuldades do Projeto

A autenticação com o Google teve alguns problemas aparentemente devido à versão PHP utilizada que trata certificados SSL de uma maneira diferente, gastei um tempo com pesquisas tentando arrumar uma solução, apliquei todas as encontradas mas nenhuma funcionou, provavelmente porque estava testando em um ambiente local, então desativei a etapa de verificação de segurança no ambiente local, que funcionou normalmente no ambiente de hospedagem remoto.

## TODO

1. Integração com Amazon S3
2. Index com Elastic Search

Estou com pouco tempo livre e alguns projetos em fase final, em breve posso dedicar mais um tempo para integrar essas etapas.

## Considerações

Como o projeto não vai entrar em produção, creio que no estado atual já dá pra ter noção das etapas desenvolvidas, incluindo todo o progresso do desenvolvimento que pode ser acompanhando através dos commits criados, creio que o propósito do desafio é mais nivelar e conhecer as capacidades de desenvolvimento do que ter uma ferramenta completamente implementável em si.
