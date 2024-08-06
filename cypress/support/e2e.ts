///home/jose/projetos/Cygecom/cypress/support/e2e.ts
import './commands/commands';
import './commands/commandsLogin';
import './commands/commandsRegistration';
import './commands/commandsRequest';

Cypress.on('uncaught:exception', (err, runnable) => {

    return false
})