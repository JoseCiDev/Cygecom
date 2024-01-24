export function validateEmail(email: string): boolean {
    if (email === '') {
        return true;
    }
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

export function validatePassword(password: string): boolean {
    const re = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d@]{8,}$/;
    return re.test(password);
}

export function checkInput($input, elementError, errorMessage) {
    const inputValueFromInput = String($input.val());
    if (inputValueFromInput.length < 1 && !Cypress.$(elementError).is(':visible')) {
        throw new Error(errorMessage);
    }
}