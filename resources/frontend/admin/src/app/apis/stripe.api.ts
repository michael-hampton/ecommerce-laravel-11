import { HttpClient } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { PaymentIntent } from "@stripe/stripe-js";
import { environment } from "../../environments/environment";
import { Observable } from "rxjs";

@Injectable({providedIn: 'root'})
export class StripeApi {
    constructor(private httpClient: HttpClient) { }
    createPaymentIntent(): Observable<PaymentIntent> {
        return this.httpClient.get<PaymentIntent>(
            `${environment.apiUrl}/stripe/create-payment-intent`,
        );
    }
}