import { defineConfig } from "cypress";

export default defineConfig({
  projectId: "kserwh",
  includeShadowDom: true,
  defaultCommandTimeout: 10000,
  waitForAnimations: false,

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
      'cypress/support/commands/*',
      'cypress/DadosParametros.ts',
      'cypress/elements.ts',
      'cypress/reports/*',
      'cypress/reports/html/*',
      'cypress/reports/html/assets/*',
      'cypress/reports/.jsons/*',
    ],
    video: true,
    videosFolder: 'cypress/videos',
    screenshotsFolder: 'cypress/screenshots',
  },
});
