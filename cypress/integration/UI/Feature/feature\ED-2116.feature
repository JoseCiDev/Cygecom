Feature: Gerenciamento de Solicitações de Compras

    Background:
        Given que o usuário solicitante está autenticado no sistema

    Scenario Outline: Criar solicitação para <tipo de solicitação> e habilitar campos de pagamento para "Suprimentos"
        Given que o usuário solicitante inicia a criação de uma nova solicitação de <tipo de solicitação>
        And o usuário marca "Suprimentos" como responsável pela contratação de compra
        Then os campos de pagamento devem estar habilitados e não obrigatórios
        And o usuário deve poder preencher as seguintes informações de pagamento:
            | Campo                 | Valor                   |
            | Condição de pagamento | <condição de pagamento> |
            | Valor total           | <valor total>           |
            | Forma de pagamento    | <forma de pagamento>    |
            | Número de parcelas    | <número de parcelas>    |
            | Detalhes do pagamento | Detalhes adicionais     |

        Examples:
            | tipo de solicitação | condição de pagamento | forma de pagamento |
            | produto             | Antecipado            | boleto             |
            | produto             | A vista               | cartão de crédito  |
            | produto             | Parcelado             | cheque             |
            | serviço pontual     | Antecipado            | depósito bancário  |
            | serviço pontual     | A vista               | dinheiro           |
            | serviço pontual     | Parcelado             | pix                |
            | serviço recorrente  | Antecipado            | cartão de débito   |
            | serviço recorrente  | A vista               | boleto             |
            | serviço recorrente  | Parcelado             | pix                |

    Scenario: Criar rascunho de solicitação e editar antes de enviar
        Given que o usuário solicitante cria um rascunho de solicitação de produto
        When o usuário salva a solicitação como rascunho
        And o usuário acessa o rascunho de solicitação para edição
        And o usuário altera as informações e salva a solicitação
        Then a solicitação deve ser salva com as informações atualizadas
        And enviadas para o usuário aprovador em suprimentos

    Scenario: Salvar solicitação e impedir edição após envio
        Given que o usuário solicitante inicia a criação de uma nova solicitação de serviço pontual
        When o usuário salva a solicitação como "Solicitação Salva"
        Then a solicitação deve estar visível na lista de solicitações do usuário de suprimentos
        And a solicitação não deve estar disponível para edição

    Scenario: Exibir solicitação na lista após criação
        Given que o usuário solicitante inicia a criação de uma nova solicitação de serviço recorrente
        When o usuário salva a solicitação como "Solicitação Salva"
        Then a solicitação deve estar visível na lista de solicitações do usuário suprimentos
        And a solicitação não deve estar disponível para edição

    Scenario Outline: Preencher campos de pagamento e exibir na etapa de Suprimentos
        Given que o usuário solicitante cria uma solicitação de <tipo de solicitação>
        And o usuário preenche as informações de pagamento com:
            | Campo                 | Valor               |
            | Condição de pagamento | <condição>          |
            | Valor total           | 1000                |
            | Forma de pagamento    | <forma>             |
            | Número de parcelas    | 3                   |
            | Detalhes do pagamento | Pagamento detalhado |
        When o usuário salva e envia a solicitação
        And o usuário suprimentos acessa a etapa "Informações de pagamentos"
        Then o usuário suprimentos deve visualizar os dados de pagamento preenchidos

        Examples:
            | tipo de solicitação | condição   | forma             |
            | produto             | Antecipado | boleto            |
            | serviço pontual     | A vista    | dinheiro          |
            | serviço recorrente  | Parcelado  | cartão de crédito |

    Scenario: Visualizar e aprovar solicitação pelo usuário suprimentos
        Given que o usuário solicitante criou e enviou uma solicitação de serviço pontual para aprovação
        When o usuário suprimentos acessa a lista de solicitações
        And o usuário visualiza a solicitação e seus detalhes de pagamento
        Then os dados de pagamento preenchidos pelo solicitante devem ser exibidos corretamente
        When o usuário suprimentos altera o status da solicitação para finalizada
        Then o status da solicitação deve ser atualizado para "Finalizada"
        Then a ação deve estar registrada no histórico da solicitação

    Scenario Outline: Selecionar responsável pela compra e criar solicitação
        Given que o usuário solicitante seleciona "<responsável>" na pergunta "Quem fez/fará a contratação-compra?"
        And o usuário cria uma solicitação de <tipo de solicitação>
        Then a solicitação deve ser salva com "<responsável>" como responsável pela compra/contratação
        And a solicitação deve estar visível na lista de solicitações do suprimentos

        Examples:
            | responsável           | tipo de solicitação |
            | Suprimentos           | produto             |
            | Eu (Área solicitante) | serviço pontual     |
            | Eu (Área solicitante) | serviço recorrente  |
            | Suprimentos           | serviço recorrente  |

    Scenario Outline: Exibir informações de pagamento com base na condição e forma de pagamento
        Given que o usuário solicitante cria uma nova solicitação de <tipo de solicitação>
        And seleciona a condição de pagamento como <condição>
        And seleciona a forma de pagamento como <forma>
        Then os dados devem ser exibidos na tela de detalhes de Suprimentos com a condição e forma de pagamento corretas

        Examples:
            | tipo de solicitação | condição   | forma             |
            | produto             | A vista    | cartão de crédito |
            | serviço pontual     | Parcelado  | cheque            |
            | serviço recorrente  | Antecipado | pix               |

    