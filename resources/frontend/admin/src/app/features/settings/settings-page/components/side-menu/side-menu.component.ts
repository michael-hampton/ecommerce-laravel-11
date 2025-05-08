import { Component, EventEmitter, inject, Output } from '@angular/core';
import { AuthService } from '../../../../../core/auth/auth.service';
import { FormGroup } from '@angular/forms';
import { ProfileStore } from '../../../../../store/profile/form.store';
import { Router } from '@angular/router';

@Component({
  selector: 'app-side-menu',
  standalone: false,
  templateUrl: './side-menu.component.html',
  styleUrl: './side-menu.component.scss',
  providers: [ProfileStore]
})
export class SideMenuComponent {
  private _store = inject(ProfileStore)
  vm$ = this._store.vm$
  form?: FormGroup;
  private _authService = inject(AuthService)
  url: string = 'settings';
  @Output() menuItemChanged = new EventEmitter()

  ngOnInit() {
    this._store.getData(Number(this._authService.GetUser().payload.id)).subscribe()
  }

  menuItemClicked(page: string) {
    this.url = page
    this.menuItemChanged.emit(page)
  }
}

