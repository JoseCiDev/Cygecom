// ***********************************************************
// This example support/e2e.ts is processed and
// loaded automatically before your test files.
//
// This is a great place to put global configuration and
// behavior that modifies Cypress.
//
// You can change the location of this file or turn off
// automatically serving support files with the
// 'supportFile' configuration option.
//
// You can read more here:
// https://on.cypress.io/configuration
// ***********************************************************

// Import commands.js using ES2015 syntax:
<<<<<<< HEAD
import './commands/commands'
=======
<<<<<<< HEAD
import './commands/commands.ts'

// Alternatively you can use CommonJS syntax:
// require('./commands')
Cypress.on('uncaught:exception', (err, runnable) => {
    // returning false here prevents Cypress from
    // failing the test
    return false
})
=======
import './commands'
>>>>>>> 7e26ae0ed00df99f6fe0236388fd5d6c2090292e

// Alternatively you can use CommonJS syntax:
// require('./commands')
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
