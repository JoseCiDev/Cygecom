import { ConditionalWrite } from "../../import";


export interface PaymentConditionData extends ConditionalWrite {
    anticipatedPayment: [boolean, string];
    cashPayment: [boolean, string];
    paymentInInstallments: [boolean, string];
};

export interface FileData {
    filePath: string;
}