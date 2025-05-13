import { Component, inject } from '@angular/core';
import { AuthService } from '../../../core/auth/auth.service';
import { FormGroup } from '@angular/forms';
import { ProfileStore } from './profile.store';
import { Seller } from '../../../types/seller/seller';

@Component({
  selector: 'app-profile',
  standalone: false,
  templateUrl: './profile.component.html',
  styleUrl: './profile.component.scss',
  providers: [ProfileStore]
})
export class ProfileComponent {
  _store = inject(ProfileStore)
  vm$ = this._store.vm$
  form?: FormGroup;
  private _authService = inject(AuthService)
  sellerId: number;

  ngOnInit() {
    const sellerId = Number(this._authService.GetUser().payload.id)
    this._store.getData(sellerId).subscribe((result: Seller) => {
     this.sellerId = result.id
    })

    this._store.currentFile$.subscribe(result => {
      if (result) {
        this._store.saveData(result, this.sellerId).subscribe()
      }

    })
  }
}
