import { Component, inject, TemplateRef, ViewChild, ViewContainerRef } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ModalComponent } from '../../../../../shared/components/modal/modal.component';
import { ModalService } from '../../../../../services/modal.service';
import { CardDetailsStore } from './card-details.store';

@Component({
  selector: 'app-card-details',
  standalone: false,
  templateUrl: './card-details.component.html',
  styleUrl: './card-details.component.scss',
  providers: [CardDetailsStore]
})
export class CardDetailsComponent {

  private _store = inject(CardDetailsStore)
  private _modalService = inject(ModalService)
  vm$ = this._store.vm$
  private fb = inject(FormBuilder)
  @ViewChild('cardForm') cardForm: TemplateRef<any>;
  form: FormGroup;
  @ViewChild('addCardModal', { static: true, read: ViewContainerRef })
  addCardModal!: ViewContainerRef;

  ngOnInit() {
    this.initCardDetailsForm();

    this._store.getSellerCardDetails()
  }

  saveCardDetails() {
    if (this.form?.valid) {
      const model = {
        id: this.form.value.id,
        card_name: this.form.value.nameOnCard,
        card_expiry_date: this.form.value.expiry,
        card_cvv: this.form.value.cvvCode,
        card_number: this.form.value.cardNumber,
      };

      console.log('model', model)

      this._store.saveCardDetails(model).subscribe()
    }
  }
  initCardDetailsForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      nameOnCard: new FormControl('', [Validators.required]),
      expiry: new FormControl('', [Validators.required]),
      cvvCode: new FormControl('', [Validators.required]),
      cardNumber: new FormControl('', [Validators.required]),
    })
  }

  addPaymentMethod() {
    this.initCardDetailsForm()
    this._modalService
      .openConfirmationModal(ModalComponent, this.addCardModal, {}, {
        modalTitle: 'Add new payment method',
        template: this.cardForm,
        showFooter: true,
        saveButtonLabel: 'Add card'
      })
      .subscribe((v) => {
       this.saveCardDetails()
      });
  }

  async editPaymentMethod(id: number) {

    const cards = this._store.cards$.subscribe(results => {
      const card = results.filter(x => x.id === id)[0]
      this.form?.patchValue({
        id: card.id,
        nameOnCard: card.card_name,
        expiry: card.card_expiry_date,
        cvvCode: card.card_cvv,
        cardNumber: card.card_number,
      })
    })

    this._modalService
      .openConfirmationModal(ModalComponent, this.addCardModal, {}, {
        modalTitle: 'Edit payment method',
        template: this.cardForm,
        showFooter: true,
        saveButtonLabel: 'Add card'
      })
      .subscribe((v) => {
       this.saveCardDetails()
      });
  }

  removePaymentMethod(id: number) {
    this._store.deleteCard(id)
  }
}
