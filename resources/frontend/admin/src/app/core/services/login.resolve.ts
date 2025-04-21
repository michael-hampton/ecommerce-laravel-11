// services/login.resolve
import {ActivatedRouteSnapshot, Resolve, Router, RouterStateSnapshot} from '@angular/router';
import {AuthService} from './auth.service';
import {map, Observable} from 'rxjs';
import {Injectable} from '@angular/core';
import {AuthState} from './auth.state';

@Injectable({ providedIn: 'root' })
export class LoginResolve implements Resolve<boolean> {
  constructor(private authState: AuthState, private router: Router) {}
  resolve(
    route: ActivatedRouteSnapshot,
    state: RouterStateSnapshot
  ): Observable<boolean> {
    return this.authState.stateItem$.pipe(
      map((user) => {
        // if logged in succesfully, go to last url
        if (user) {
          this.router.navigateByUrl(
            this.authState.redirectUrl || '/'
          );
        }
        // does not really matter, I either go in or navigate away
        return true;
      })
    );
  }
}
