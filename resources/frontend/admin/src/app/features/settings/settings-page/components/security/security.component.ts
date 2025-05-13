import { Component, inject, ViewChild } from '@angular/core';
import { FormBuilder, FormControl, FormGroup } from '@angular/forms';
import { AuthService } from '../../../../../core/auth/auth.service';
import { SecurityStore } from './security.store';

@Component({
  selector: 'app-security',
  standalone: false,
  templateUrl: './security.component.html',
  styleUrl: './security.component.scss',
  providers: [SecurityStore]
})
export class SecurityComponent {

  private _store = inject(SecurityStore)
  private fb = inject(FormBuilder)
  form: FormGroup;
  @ViewChild("mycheckbox") mycheckbox;
  deletePressed = false
  sellerId: number = 0
  private _auth = inject(AuthService)

  ngOnInit() {
    this.initForm();

    this._store.data$.subscribe(res => {
      this.sellerId = res.id
    })
  }

  initForm() {
    this.form = this.fb.group({
      password: new FormControl(''),
      newPassword: new FormControl(''),
      confirmPassword: new FormControl(''),
    })
  }

  deleteAccount() {
    if (!this.mycheckbox.nativeElement.checked) {
      this.deletePressed = true
      return
    }

    this._store.deleteAccount(this.sellerId).subscribe(() => {
      this._auth.Logout();
    })

  }

  get deleteAccepted(): boolean {
    return this.deletePressed && !this.mycheckbox.nativeElement.checked
  }

  updatePassword() {
    this._store.resetPassword({
      old_password: this.form.value['password'],
      new_password: this.form.value['newPassword'],
      new_password_confirmation: this.form.value['confirmPassword']
    }).subscribe()
  }
}
