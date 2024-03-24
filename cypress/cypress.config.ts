import { defineConfig } from "cypress";

export default defineConfig({

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
  },
});
