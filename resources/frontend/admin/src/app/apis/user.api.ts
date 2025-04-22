import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {User} from '../types/users/user';
import {FilterModel, PagedData} from '../types/filter.model';
import {Category} from '../types/categories/category';
import {BaseHttpClient} from './base.http-client';

export const MODULE = 'users'

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

  constructor(private baseHttpClient: BaseHttpClient) { }

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

  getData(filter: FilterModel): Observable<any>{
    return this.baseHttpClient.get(filter, MODULE);
    //return of({data: this.users, current_page: 1, total: this.users.length} as PagedData<User>)
  }
}
