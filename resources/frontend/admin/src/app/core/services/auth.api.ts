import {HttpClient} from '@angular/common/http';
import {of} from 'rxjs';
import {Injectable} from '@angular/core';

@Injectable({providedIn: 'root'})
export class AuthApi {
  constructor(private _http: HttpClient) {}

  public Login(username: string, password: string) {
      const response = {data: { accessToken: 'some_acces_token',
        refreshToken: 'some_refresh_token',
        payload: {
          "id": "841fca92-eba8-48c8-8c96-92616554c590",
          "email": "aa@gmail.com"
        },
        expiresIn: 3600}};

      return of(response)
  }

  public Refresh(token: string) {
    const response = {data: { accessToken: 'some_acces_token',
        refreshToken: 'some_refresh_token',
        payload: {
          "id": "841fca92-eba8-48c8-8c96-92616554c590",
          "email": "aa@gmail.com"
        },
        expiresIn: 3600}};

    return of(response)
  }

  public GetUser() {

  }
}
