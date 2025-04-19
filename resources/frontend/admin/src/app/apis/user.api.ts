import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {of} from 'rxjs';
import {User} from '../types/users/user';

export const MODULE = 'admin/users'

@Injectable({
  providedIn: 'root'
})
export class UserApi {

  private users: User[] = [
    {
      id: 1, name: 'Category 1',
      email: '',
      password: '',
      mobile: '07851624051',
      image: '',
      utype: '',
      active: false
    },
    {
      id: 2, name: 'Category 1',
      email: '',
      password: '',
      mobile: '07851624051',
      image: '',
      utype: '',
      active: false
    },
    {
      id: 3, name: 'Category 1',
      email: '',
      password: '',
      mobile: '07851624051',
      image: '',
      utype: '',
      active: false
    },
    {
      id: 4, name: 'Category 1',
      email: '',
      password: '',
      mobile: '07851624051',
      image: '',
      utype: '',
      active: false
    },
    {
      id: 5, name: 'Category 1',
      email: '',
      password: '',
      mobile: '07851624051',
      image: '',
      utype: '',
      active: false
    },
  ]

  constructor(private httpclient: HttpClient) { }

  delete(id: number) {
    alert('deleting')
    return of(this.users);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  create(payload: Partial<User>) {
    alert('creating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  update(id: number, payload: Partial<User>) {
    alert('updating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getData(){
    return of({data: this.users})
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }
}
