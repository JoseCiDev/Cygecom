import { defineConfig } from "cypress";
// import createBundler from "@bahmutov/cypress-esbuild-preprocessor";
// import { addCucumberPreprocessorPlugin } from "@badeball/cypress-cucumber-preprocessor";
// import createEsbuildPlugin from "@bahmutov/cypress-esbuild-preprocessor/esbuild";

// async function setupNodeEvents(
//   on: Cypress.PluginEvents,
//   config: Cypress.PluginConfigOptions
// ): Promise<Cypress.PluginConfigOptions> {
//   // This is required for the preprocessor to be able to generate JSON reports after each run, and more,
//   await addCucumberPreprocessorPlugin(on, config);

//   on(
//     "file:preprocessor",
//     createBundler({
//       plugins: [createEsbuildPlugin(config)],
//     })
//   );

//   // Make sure to return the config object as it might have been modified by the plugin.
//   return config;
// }

export default defineConfig({
  projectId: "r5rp3y",
  includeShadowDom: true,
  defaultCommandTimeout: 30000,
  pageLoadTimeout: 30000,
  requestTimeout: 30000,
  responseTimeout: 30000,
  waitForAnimations: false,
  numTestsKeptInMemory: 5,
  experimentalMemoryManagement: true,
  e2e: {
    // setupNodeEvents,
    baseUrl: 'http://gerenciador-compras.docker.local:8085/login',
    supportFile: 'cypress/support/e2e.ts',
    specPattern: 'cypress/**/*.{js,jsx,ts,tsx,feature}',
    redirectionLimit: 5000,
    viewportHeight: 1280,
    viewportWidth: 1024,
    numTestsKeptInMemory: 1,
    excludeSpecPattern: [
      'cypress/support/*',
      'cypress/support/commands/*',
      'cypress/DadosParametros.ts',
      'cypress/elements.ts',
      'cypress/reports/*',
      'cypress/reports/html/*',
      'cypress/reports/html/assets/*',
      'cypress/reports/.jsons/*',
      'cypress/DataParameters/Enums/*',
      'cypress/DataParameters/Interfaces/*',
      'cypress/DataParameters/Types/*',
    ],
    video: true,
    videosFolder: 'cypress/videos',
    screenshotsFolder: 'cypress/screenshots',
  },
});

