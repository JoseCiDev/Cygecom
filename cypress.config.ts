import { defineConfig } from "cypress";

export default defineConfig({

<<<<<<< HEAD
  includeShadowDom: true,
  defaultCommandTimeout: 10000,

  e2e: {
    setupNodeEvents(on, config) {

    },
    supportFile: 'cypress/support/e2e.{js,jsx,ts,tsx}',
    specPattern: 'cypress/**/*.{js,jsx,ts,tsx}',
    redirectionLimit: 5000,
    viewportHeight: 1280,
    viewportWidth: 1024,
    numTestsKeptInMemory: 150,
    excludeSpecPattern: [
      'cypress/support/*',
      'cypress/DadosParametros.ts',
      'cypress/elements.ts',
      'cypress/reports/*',
      'cypress/reports/html/*',
      'cypress/reports/html/assets/*',
      'cypress/reports/.jsons/*',
    ],
    video:true,
    videosFolder:'cypress/videos',
    screenshotsFolder:'cypress/screenshots',
=======
  includeShadowDom:true,
  defaultCommandTimeout:10000,

  e2e: {
    setupNodeEvents(on, config) {
      // implement node event listeners here
    },
    supportFile:'cypress/support/e2e.{js,jsx,ts,tsx}',
    specPattern:'cypress/**/*.cy.{js,jsx,ts,tsx}',
    redirectionLimit:50,
    viewportHeight:1280,
    viewportWidth:1024
>>>>>>> 66389675fb764448964dc7d97d8eb66f3d517bd5
  },
});
