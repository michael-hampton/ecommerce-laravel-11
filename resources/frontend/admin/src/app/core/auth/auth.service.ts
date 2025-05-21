// Auth service
import {BehaviorSubject, map, Observable, of, switchMap} from 'rxjs';
import {Injectable} from '@angular/core';
import {AuthApi} from './auth.api';
import {Toast} from '../../services/toast/toast.service';
import {AuthState} from './auth.state';
import {IAuthInfo, Login, NewAuthInfo, PrepSetSession} from './auth.model';

@Injectable({providedIn: 'root'})
export class AuthService {
  private _loginUrl = '/auth/login';
  private stateItem: BehaviorSubject<IAuthInfo | null> = new BehaviorSubject(null);
  stateItem$: Observable<IAuthInfo | null> = this.stateItem.asObservable();

  constructor(private _api: AuthApi, private toast: Toast, private authState: AuthState) {
  }

  Login(payload: Partial<Login>): Observable<any> {
    return this._api.Login(payload.email, payload.password).pipe(
      map((response) => {
        console.log('response from login', response)
        // prepare the response to be handled, then return
        const retUser: IAuthInfo = NewAuthInfo((<any>response));

        // save session and return user if needed
        return this.authState.SaveSession(retUser);
      }),
      // if we are setting cookie on server, this is the place to call local server
      switchMap((user) => this.SetLocalSession(user))
    );
  }

  RefreshToken(): Observable<IAuthInfo> {
    return this._api.Refresh(this.authState.GetRefreshToken())
      .pipe(
        map((response) => {
          // this response has the new refresh token and access token
          if (!response) {
            // something terrible happened
            throw new Error('Oh oh');
          }

          // update session
          const retUser: IAuthInfo = NewAuthInfo((<any>response).data);
          this.authState.UpdateSession(retUser);

          return retUser;
        }),
        // if we use set session on local server, then this is the place
        // to call it
        switchMap((response) => this.SetLocalSession(response))
      );
  }

  SetLocalSession(user: IAuthInfo): Observable<IAuthInfo> {
    // prepare the information to use in the cookie
    // basically the auth info and the cookie name
    const data = PrepSetSession(user);

     localStorage.setItem('user', JSON.stringify(user));

    // notice the relative url, this is the path you need to setup in your server
    // look up an example in server.js
    return of(user)
  }

  GetUser() {
    const _localuser: IAuthInfo = JSON.parse(localStorage.getItem('user'));
    if (_localuser && _localuser.accessToken) {
      return <IAuthInfo>_localuser;
    }
    return null;
  }

  Logout(): Observable<boolean> {
    // logout locally
    this.authState.Logout();

    return of(true)

    // return this.http.post(this._localLogout, data).pipe(
    //   map((response) => {
    //     return true;
    //   })
    // );
  }
}
