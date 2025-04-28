import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {FormArray, FormBuilder, FormGroup} from '@angular/forms';
import {ShippingFormStore} from '../../../../store/shipping/form.store';
import {PackageSizeEnum} from '../../../../types/shipping/package-size.enum';
import {Shipping} from '../../../../types/shipping/shipping';
import {ModalComponent} from '../../../../shared/components/modal/modal.component';

@Component({
  selector: 'app-form',
  standalone: false,
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss',
  providers: [ShippingFormStore]
})
export class FormComponent extends ModalComponent implements OnInit {
  form: FormGroup;
  @ViewChild('modal') content!: ElementRef;
  private formBuilder = inject(FormBuilder)
  private isSubmitted: boolean;
  private _store = inject(ShippingFormStore)
  vm$ = this._store.vm$

  ngOnInit() {
    this.initForm()
    this._store.getCouriers()

    if (this.formData?.id) {
      this._store.loadDataForCountry(1).subscribe((results: Shipping[]) => {
        console.log('res', results)
        const methodFormArray = this.form.get('methods') as FormArray;

        results.forEach(result => {
          const topicFormGroup = this.formBuilder.group({
            name: result.name,
            courier: result.courier_id,
            price: result.price,
            tracking: result.tracking
          });
          methodFormArray.push(topicFormGroup);
        })
      })
    }
  }

  initForm() {
    this.form = this.formBuilder.group({
      id: [''],
      //name: [''],
      //country_id: [0, Validators.required],
      // subCategory: ['', Validators.required],
      methods: this.formBuilder.array([]),
      // image: [''],
      // type: [''],
      // description: [''],
      // richdescription: [''],
      // isFeatured: [false],
      // isHomeFeatured: [false],
    });
  }

  addMethod() {
    const methodFormArray = this.form.get('methods') as FormArray;
    const topicFormGroup = this.formBuilder.group({
      name: '',
      courier: '',
      price: 0,
      tracking: false
    });
    methodFormArray.push(topicFormGroup);
  }

  getMethodControls(): FormArray {
    return this.form.get('methods') as FormArray;
  }

  removeMethod(methodIndex: number): void {
    this.getMethodControls().removeAt(methodIndex);
  }

  onSubmit() {
    this.isSubmitted = true;
    if (this.form.invalid) {
      console.log(this.form)
      return;
    }

    const quizFormData = new FormData();

    // Append basic quiz data to FormData
    Object.keys(this.form.value).forEach((key) => {
      if (key !== 'topics') {
        quizFormData.append(key, this.form.value[key]);
      }
    });

    // Append Topics data to FormData
    const methods = this.form.value.methods.map((method: any) => {
      return {name: method.name, courier: method.courier, price: method.price, tracking: method.tracking};
    });

    quizFormData.append('methods', JSON.stringify(methods));

    console.log(Object.fromEntries(quizFormData)) // Works if all fields are uniq

    this._store.saveData(quizFormData).subscribe()

  }

  protected readonly PackageSizeEnum = PackageSizeEnum;
}
