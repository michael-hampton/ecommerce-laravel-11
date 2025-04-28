import {Component, inject} from '@angular/core';
import {ProfileStore} from '../../../../store/profile/form.store';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {Seller} from '../../../../types/seller/seller';
import {AccountDetails} from '../../../../types/seller/account-details';
import {Billing} from '../../../../types/seller/billing';
import {AuthService} from '../../../../core/auth/auth.service';

@Component({
  selector: 'app-setting-page',
  standalone: false,
  templateUrl: './setting-page.component.html',
  styleUrl: './setting-page.component.scss',
  providers: [ProfileStore]
})
export class SettingPageComponent {

  private _store = inject(ProfileStore)
  vm$ = this._store.vm$
  form?: FormGroup;
  private _authService = inject(AuthService)

  ngOnInit() {
    this._store.getData(Number(this._authService.GetUser().payload.id)).subscribe()
  }

}
