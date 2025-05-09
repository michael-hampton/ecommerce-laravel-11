import { Component, inject } from '@angular/core';
import { FormArray, FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { ProfileStore } from '../../../../../store/profile/form.store';
import { Type } from '../../../../../types/notifications/type';

@Component({
  selector: 'app-notifications',
  standalone: false,
  templateUrl: './notifications.component.html',
  styleUrl: './notifications.component.scss'
})
export class NotificationsComponent {

  private fb = inject(FormBuilder)
  form: FormGroup;
  private _store = inject(ProfileStore)
  vm$ = this._store.vm$


  ngOnInit() {
    this.form = this.fb.group({
      dynamicFields: this.fb.array([]), // Initialize form array
    });
    this._store.getNotificationTypes().subscribe((results: Type[]) => {
      this.form = new FormGroup(
        Object.fromEntries(
            results.map(
                option => [option.id, new FormControl(false, { nonNullable: true })]
            )
        )
    );
    });
  }

  get dynamicFields(): FormArray {
    return this.form.get('dynamicFields') as FormArray;
  }

  getField(name: string): FormArray {
    console.log('here', (this.form.get('dynamicFields') as FormArray).at(0).get(name))
    return this.form.get('dynamicFields')[name].controls
  }

  submitForm() {
    this._store.saveNotificationTypes({notification_types: this.form.value}).subscribe()
  }
}
