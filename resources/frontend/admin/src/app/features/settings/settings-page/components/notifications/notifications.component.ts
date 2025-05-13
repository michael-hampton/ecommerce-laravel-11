import { Component, inject } from '@angular/core';
import { FormArray, FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { NotificationTypeCollection, Type } from '../../../../../types/notifications/type';
import { NotificationStore } from './notification.store';
import { AuthService } from '../../../../../core/auth/auth.service';

@Component({
  selector: 'app-notifications',
  standalone: false,
  templateUrl: './notifications.component.html',
  styleUrl: './notifications.component.scss',
  providers: [NotificationStore]
})
export class NotificationsComponent {

  private _authService = inject(AuthService)
  private fb = inject(FormBuilder)
  form: FormGroup;
  private _store = inject(NotificationStore)
  vm$ = this._store.vm$


  ngOnInit() {
    const userId = this._authService.GetUser().payload.id;
    this.form = this.fb.group({
      dynamicFields: this.fb.array([]), // Initialize form array
    });
    this._store.getNotificationTypes(Number(userId)).subscribe((results: NotificationTypeCollection) => {
      console.log('results', results)
      this.form = new FormGroup(
        Object.fromEntries(
            results.types.map(
                option => [option.id, new FormControl(
                  results.user_types.find(x => x.notification_type === option.id) || false, 
                  { nonNullable: true })]
            )
        )
    );
    });
  }

  get dynamicFields(): FormArray {
    return this.form.get('dynamicFields') as FormArray;
  }

  getField(name: string): FormArray {
    return this.form.get('dynamicFields')[name].controls
  }

  submitForm() {
    this._store.saveNotificationTypes({notification_types: this.form.value}).subscribe()
  }
}
