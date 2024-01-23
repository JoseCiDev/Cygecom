const fs = require('fs');
const jsdom = require('jsdom');
const { JSDOM } = jsdom;

// Função para remover acentos
function removeAccents(str) {
  return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

// Função para converter uma string para camelCase
function toCamelCase(str) {
  return str.toLowerCase().replace(/[^a-zA-Z0-9]+(.)/g, (m, chr) => chr.toUpperCase());
}

// 1. Ler o arquivo HTML
const html = fs.readFileSync('cypress/fixtures/GenerateEnum.html', 'utf-8');

// 2. Analisar o HTML
const dom = new JSDOM(html);

// 3. Selecionar todos os elementos li
const elements = dom.window.document.querySelectorAll('li');

// 4. Iterar sobre os elementos e extrair os IDs e o texto
const elementsData = Array.from(elements).map(element => ({
  id: element.getAttribute('data-select2-id'),
  text: element.textContent.trim(),
}));

// 5. Criar um enum TypeScript com esses IDs e nomes
let enumCode = 'export enum ElementIds {\n';
elementsData.forEach(({ id, text }) => {
  let name = text;
  name = removeAccents(name).replace(/[^a-zA-Z0-9 /]/g, '').replace(/ /g, '_').replace(/\//g, '_').toUpperCase();
  name = toCamelCase(name);
  enumCode += `  ${name} = "${id}",\n`;
});
enumCode += '}';

// 6. Escrever o enum em um arquivo TypeScript
fs.writeFileSync('cypress/usuarioAprovador.ts', enumCode);