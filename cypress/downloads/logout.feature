#/home/jose/projetos/Cygecom/cypress/e2e/logout.feature
Feature: Logout

    Background: Usuário logado no sistema
        Given que eu estou logado como administrador

    Scenario: Deve efetuar o logout com sucesso
        When eu faço logout
        Then eu devo visualizar a tela de login