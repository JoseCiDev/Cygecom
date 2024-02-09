const fs = require('fs');
const jsdom = require('jsdom');
const { JSDOM } = jsdom;

// 1. Ler o arquivo HTML
const html = fs.readFileSync('cypress/fixtures/GenerateEnum.html', 'utf-8');

// 2. Analisar o HTML
const dom = new JSDOM(html);

// 3. Selecionar todos os elementos li
const elements = dom.window.document.querySelectorAll('li');

// 4. Iterar sobre os elementos e extrair os IDs e o texto
const elementsData = Array.from(elements).map(element => ({
  id: element.getAttribute('data-select2-id'),
  text: element.textContent.trim().replace(/'/g, "\\'"), // Escapar apóstrofos
}));

// 5. Criar um objeto TypeScript com esses IDs e nomes
let objectCode = 'export const ElementIds = {\n';
elementsData.forEach(({ id, text }) => {
  let name = text;
  objectCode += `  '${name}'= '${name}',\n`; // Agora o valor do objeto é igual ao nome
});
objectCode += '}';

// 6. Escrever o objeto em um arquivo TypeScript
fs.writeFileSync('cypress/enum.ts', objectCode);