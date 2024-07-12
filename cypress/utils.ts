export function validateEmail(email: string): string | null {
    if (email === '') {
        return 'Preencha este campo.';
    }
    if (!email.includes('@')) {
        return `Inclua um "@" no endereço de e-mail. "${email}" não contém um "@".`;
    }
    const parts = email.split('@');
    if (parts.length !== 2) {
        return `Insira uma parte após "@". O "${email}@" está incompleto.`;
    }
    if (parts[1].includes('@')) {
        return `Uma parte após '@' não deve conter o símbolo '${email}'`;
    }
    if (parts[1].indexOf('.') === 0 || parts[1].indexOf('.') === parts[1].length - 1) {
        return `'.' foi usado em uma posição incorreta em '${email}'`;
    }
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!re.test(String(email).toLowerCase())) {
        return 'Email com formato inválido';
    }
    return null;
};

export function validatePassword(password: string): boolean {
    const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@]{8,}$/;
    return re.test(password);
};

export function checkInput($input, elementError, errorMessage) {
    const inputValueFromInput = String($input.val());
    if (inputValueFromInput.length < 1 && !Cypress.$(elementError).is(':visible')) {
        return cy.wrap({error:errorMessage});
    }
};





