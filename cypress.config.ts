import { defineConfig } from "cypress";

export default defineConfig({
  projectId: "r5rp3y",
  includeShadowDom: true,
  defaultCommandTimeout: 10000,
  waitForAnimations: false,
  numTestsKeptInMemory: 5,
  experimentalMemoryManagement: true,

  e2e: {
    baseUrl: 'http://gerenciador-compras.docker.local:8085',
    setupNodeEvents(on, config) {
      // Acessa a variável de ambiente e a armazena em uma constante
      const recordKey = config.env.CYPRESS_RECORD_KEY;

      // Verifica se a chave de gravação existe e configura a opção de gravação
      // dentro do objeto env para uso posterior
      if (recordKey) {
        config.env.recordKey = recordKey;
        // Configurações adicionais baseadas na presença da chave de gravação
      }

      return config;
    },
    pageLoadTimeout: 60000,
    supportFile: 'cypress/support/e2e.{js,jsx,ts,tsx}',
    specPattern: 'cypress/**/*.{js,jsx,ts,tsx}',
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
