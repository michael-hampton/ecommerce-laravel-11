// this function is FYI only, it is not being used

import {
  HttpRequest,
  HttpInterceptor,
  HttpHandler,
  HttpEvent,
  HttpErrorResponse,
} from '@angular/common/http';
import { Injectable } from '@angular/core';
import {
  catchError,
  Observable,
  switchMap,
  throwError,
  finalize,
  Subject,
  filter,
} from 'rxjs';
import {AuthService} from '../auth/auth.service';
import {AuthState} from '../auth/auth.state';

@Injectable()
export class AppInterceptor implements HttpInterceptor {
  // if refreshing token, it is busy, lock
  isBusy: boolean;
  // create a subject to queue outstanding refresh calls
  recall: Subject<boolean> = new Subject();

  constructor(private authState: AuthState, private authService: AuthService) {}
  intercept(
    req: HttpRequest<any>,
    next: HttpHandler
  ): Observable<HttpEvent<any>> {
    // to make a local call to our front-end server side
    // neet to filter out some specific link, let's say it's localdata/setsession
    if (req.url.indexOf('localdata') > -1) {
      // this call is local, thus the url is relative to this same server
      // if your server cannot handle relative calls, prefix it with the proper
      // url, like https://my.domain/ + url
      return next.handle(req);
    }

    // prefixing the api with proper value, mostly from config
    // remote config url are expected to filtered out, it would not make sense
    const url = 'https://saphire.sekrab.com/api' + req.url;

    const adjustedReq = req.clone({
      url: url,
      setHeaders: this.getHeaders(),
    });

    return next.handle(adjustedReq).pipe(
      catchError((error) => {
        // if this is really an http error
        if (
          error instanceof HttpErrorResponse &&
          // and of 401 status
          error.status === 401 &&
          // filter out login calls
          req.url.indexOf('login') < 0
        ) {
          return this.handle401Error(adjustedReq, next);
        }
        // rethrow error
        return throwError(() => error);
      })
    );
  }

  private handle401Error(
    originalReq: HttpRequest<any>,
    next: HttpHandler
  ): Observable<any> {
    // let's first try to submit a refresh access token request
    // return authService.RefreshToken()
    // switchMap when done to resubmit the req passed, using next.handler
    // catchError means it is not working, rethrow and logout

    if (!this.isBusy) {
      this.isBusy = true;
      // progress subject to false
      this.recall.next(false);

      return this.authService.RefreshToken().pipe(
        switchMap((result: any) => {
          if (result) {
            // progress subject to true
            this.recall.next(true);

            // token saved (in RefreshToken), now recall the original req after adjustment
            return next.handle(
              originalReq.clone({ setHeaders: this.getHeaders() })
            );
          }

          return throwError(() => 'Failed')
        }),
        catchError((error) => {
          // else refresh token did not work, its bigger than both of us
          // log out and throw error
          this.authState.Logout(true);
          return throwError(() => error);
        }),
        finalize(() => {
          this.isBusy = false;
        })
      );
    } else {
      // return the subject, watch when it's ready, switch to recall original request
      return this.recall.pipe(
        filter((ready) => ready === true),
        switchMap((ready) => {
          // try again with adjusted header

          return next.handle(
            originalReq.clone({ setHeaders: this.getHeaders() })
          );
        })
      );
    }
  }

  private getHeaders(): any {
    //  authorization here
    let headers: any = {};
    const _auth = this.authState.GetToken();
    if (_auth && _auth !== '') {
      headers['authorization'] = `Bearer ${_auth}`;
    }

    return headers;
  }
}
