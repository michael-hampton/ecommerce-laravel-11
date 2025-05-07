import {Injectable} from '@angular/core';
import {BehaviorSubject, map, Observable} from 'rxjs';
import {RoleEnum} from '../types/users/role.enum';
import {IAuthInfo} from '../core/auth/auth.model';
import {AuthService} from '../core/auth/auth.service';

@Injectable({
  providedIn: 'root',
})
export class AuthStore {
  private user: BehaviorSubject<IAuthInfo | undefined>;
  user$: Observable<IAuthInfo | undefined>;
  isUserLoggedIn$: Observable<boolean>;
  isAdmin$: Observable<boolean>;

  constructor(private _auth: AuthService) {
    this.user = new BehaviorSubject<IAuthInfo | undefined>(this._auth.GetUser());
    this.user$ = this.user.asObservable();
    this.isUserLoggedIn$ = this.user$.pipe(map(Boolean));
    this.isAdmin$ = this.user$.pipe(map((user) => user?.payload.role === RoleEnum.Admin));
  }


  hasAnyRole = (role: RoleEnum | RoleEnum[]) =>
    this.user$.pipe(
      map((user) => {
        const roles: RoleEnum[] = Array.isArray(role) ? role : [role];
        return roles.length === 0 || roles.includes(user?.payload?.role)
      })
    );

  add(user: IAuthInfo) {
    this.user.next(user);
  }
}
