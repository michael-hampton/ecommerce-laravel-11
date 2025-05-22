import { Component, inject } from '@angular/core';
import { AuthService } from '../../auth/auth.service';
import { IUser } from '../../auth/user.model';
import { TopbarStore } from './store/topbar.store';
import { defaultPaging } from '../../../types/filter.model';

@Component({
  selector: 'app-topbar',
  standalone: false,
  templateUrl: './topbar.component.html',
  styleUrl: './topbar.component.scss',
  providers: [TopbarStore]
})
export class TopbarComponent {
  public notifications = [{message: 'Message here', created_at: 'created at', id: 1}]
  private _authService = inject(AuthService)
  user: IUser;
  private _store = inject(TopbarStore)
  vm$ = this._store.vm$

  ngOnInit() {
    this.user = this._authService.GetUser()?.payload
  }

  openNotifications() {
    this._store.loadData(defaultPaging)
  }
}
