Feature: Login

    Background: Usuário na página de login
        Given Estou na página de login

    Scenario Outline: Deve efetuar o login com sucesso
        When Eu insiro o usuário "<username>" e a senha "<password>"
        Then Eu devo ser redirecionado para a página inicial
        Then O nome do usuário deve ser exibido no canto superior direito

        Examples:
            | username          | password        |
            | usuarioCadastrado | senhaCadastrada |


    Scenario Outline: Deve falhar ao tentar efetuar o login com credenciais inválidas
        When eu tento fazer login com "<emailInvalido>" e "<senhaInvalida>"
        Then eu devo ver uma mensagem de erro "As credenciais fornecidas não coincidem com nossos registros."

        Examples:
            | emailInvalido  | senhaInvalida  |
            | emailIncorreto | senhaIncorreta |


    Scenario: Deve falhar ao tentar efetuar o login com campos vazios
        When eu tento fazer login com campos vazios
        Then eu devo ver uma mensagem de erro "Preencha este campo."


    Scenario Outline: Deve falhar ao tentar efetuar o login com senha incorreta
        When eu tento fazer login com "<emailCorreto>" e "senhaErrada"
        Then eu devo ver uma mensagem de erro "As credenciais fornecidas não coincidem com nossos registros."

        Examples:
            | emailCorreto | senhaErrada |
            | emailCorreto | senhaErrada |


    Scenario: Deve falhar ao tentar efetuar o login com um usuário não existente
        When eu tento fazer login com "usuarioInexistente" e "senhaAleatoria"
        Then eu devo ver uma mensagem de erro "As credenciais fornecidas não coincidem com nossos registros."