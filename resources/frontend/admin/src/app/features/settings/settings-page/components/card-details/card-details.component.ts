import { Component, inject, TemplateRef, ViewChild, ViewContainerRef } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ModalComponent } from '../../../../../shared/components/modal/modal.component';
import { ModalService } from '../../../../../services/modal.service';
import { CardDetailsStore } from './card-details.store';
import { cardOptions, elementsOptions } from './stripe-setup';
import {
  injectStripe,
  StripeElementsDirective,
  StripeCardComponent,
  StripeFactoryService,
  StripeService,
  StripeCardNumberComponent
} from 'ngx-stripe';
import { environment } from '../../../../../../environments/environment';
import { Observable, switchMap } from 'rxjs';
import { PaymentIntent } from '@stripe/stripe-js';
import { StripeApi } from '../../../../../apis/stripe.api';

@Component({
  selector: 'app-card-details',
  standalone: false,
  templateUrl: './card-details.component.html',
  styleUrl: './card-details.component.scss',
  providers: [CardDetailsStore, StripeFactoryService]
})
export class CardDetailsComponent {


  private _store = inject(CardDetailsStore)
  private _modalService = inject(ModalService)
  vm$ = this._store.vm$
  private fb = inject(FormBuilder)
  @ViewChild('cardForm') cardForm: TemplateRef<any>;
  @ViewChild('updateCardForm') updateCardForm: TemplateRef<any>;
  form: FormGroup;
  @ViewChild('addCardModal', { static: true, read: ViewContainerRef })
  addCardModal!: ViewContainerRef;
  useStripe = true
  cardOptions = cardOptions
  elementOptions = elementsOptions
  elements: any;
  cardElement: any;
  stripe: any;


  ngOnInit() {
    this.initCardDetailsForm();

    this._store.getSellerCardDetails()

    this._store.id$.subscribe(async res => {

      if (res) {
        const result = await this.stripe.confirmCardSetup(res, {
          payment_method: {
            card: this.cardElement
          },
        })

        const paymentMethodId = result.setupIntent.payment_method
        this.saveCardDetails(paymentMethodId)
      }
    })

    this.invokeStripe()

  }

  invokeStripe() {
    if (!window.document.getElementById('stripe-script')) {
      const script = window.document.createElement('script');
      script.id = 'stripe-script';
      script.type = 'text/javascript';
      script.src = 'https://js.stripe.com/v3/';
      script.onload = () => {
        this.stripe = (<any>window).Stripe(environment.stripeKey);
        this.elements = this.stripe.elements();
        this.cardElement = this.elements.create("card", { hidePostalCode: true });
        this.cardElement.mount("#card-element");
      };
      window.document.body.appendChild(script);
    }
  }

  saveCardDetails(paymentMethodId: string) {
    // if (this.form?.valid) {
    const model = {
      id: this.form.value.id,
      payment_method_id: paymentMethodId
    };

    console.log('model', model)

    this._store.saveCardDetails(model).subscribe()
    //}
  }
  initCardDetailsForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      nameOnCard: new FormControl('', [Validators.required]),
      expiry_month: new FormControl('', [Validators.required]),
      expiry_year: new FormControl('', [Validators.required]),
      cvvCode: new FormControl('', [Validators.required]),
      cardNumber: new FormControl('', [Validators.required]),
    })
  }

  addPaymentMethod() {
    this.initCardDetailsForm()
    console.log('element', this.cardElement)
    this._modalService
      .openConfirmationModal({
        modalTitle: 'Add new payment method',
        template: this.cardForm,
        showFooter: true,
        saveButtonLabel: 'Add card'
      })
      .subscribe((v) => {
        alert('here')
        //this.saveCardDetails()

      });
  }

  addCard() {

    this._store.createPaymentIntent()
  }

  async editPaymentMethod(id: number) {

    const cards = this._store.cards$.subscribe(results => {
      const card = results.filter(x => x.id === id)[0]
      this.form?.patchValue({
        id: card.id,
        nameOnCard: card.card_name,
        //expiry_month: card.card_expiry_date,
        //cvvCode: card.card_cvv,
        //cardNumber: card.card_number,
      })
    })

    console.log(this.updateCardForm)

    this._modalService
      .openConfirmationModal({
        modalTitle: 'Edit payment method',
        template: this.updateCardForm,
        showFooter: true,
        saveButtonLabel: 'Add card'
      })
      .subscribe((v) => {

        this._store.saveCardDetails(this.form.value).subscribe()
      });
  }

  removePaymentMethod(id: number) {
    this._store.deleteCard(id)
  }
}
