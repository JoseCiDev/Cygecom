#/home/jose/projetos/Cygecom/cypress/e2e/createRequest.feature
@criarSolicitacao
Feature: Criação de Solicitações

    Background: Usuário logado no sistema
        Given que estou na página de login
        When eu faço login com email "<user>" e senha "<password>"
        Then eu devo ser redirecionado para a página inicial

    Scenario: Solicitação de produtos
        Given que estou na página inicial
        When eu navego para o menu de novas solicitações
        And eu crio uma nova solicitação de produto
        Then a solicitação deve ser criada com sucesso
        And eu devo visualizar a solicitação na lista de solicitações