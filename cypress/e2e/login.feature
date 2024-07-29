Feature: Login

    Scenario: Simple test
        Given Estou na página de login
        When I run a simple action
        Then I should see a result
        Then I should see a result 2

# @LoginFeature
# Feature: Login

#     @Background
#     Background: Usuário na página de login
#         Given Estou na página de login

#     @LoginSuccess
#     Scenario Outline: Deve efetuar o login com sucesso
#         When Eu insiro o usuário "<username>" e a senha "<password>"
#         Then Eu devo ser redirecionado para a página inicial
#         Then O nome do usuário deve ser exibido no canto superior direito

#         Examples:
#             | username    | password  |
#             | usuarioXpto | senhaXpto |
