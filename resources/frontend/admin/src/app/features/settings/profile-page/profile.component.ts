import { Component, inject } from '@angular/core';
import { AuthService } from '../../../core/auth/auth.service';
import { ProfileStore } from '../../../store/profile/form.store';
import { FormGroup } from '@angular/forms';

@Component({
  selector: 'app-profile',
  standalone: false,
  templateUrl: './profile.component.html',
  styleUrl: './profile.component.scss',
  providers: [ProfileStore]
})
export class ProfileComponent {
  private _store = inject(ProfileStore)
  vm$ = this._store.vm$
  form?: FormGroup;
  private _authService = inject(AuthService)

  ngOnInit() {
    this._store.getData(Number(this._authService.GetUser().payload.id)).subscribe()
  }
}
