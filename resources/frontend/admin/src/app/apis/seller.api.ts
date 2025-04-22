import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {of} from 'rxjs';
import {Seller} from '../types/seller/seller';
import {BaseHttpClient} from './base.http-client';

export const MODULE = 'sellers'

@Injectable({
  providedIn: 'root'
})
export class SellerApi {

  private users: Seller[] = [
    {
      id: 1, name: 'Category 1',
      email: 'michaelhamptondesign@yahoo.com',
      phone: '07851624051',
      profile_picture: '',
      active: false,
      address1: 'test',
      address2: 'test2',
      zip: 'zip',
      city: 'city',
      state: 'state',
      username: 'test',
      biography: 'test biography'
    },
    {
      id: 2, name: 'Category 1',
      email: 'michaelhamptondesign@yahoo.com',
      phone: '07851624051',
      profile_picture: '',
      active: false,
      address1: 'test',
      address2: 'test2',
      zip: 'zip',
      city: 'city',
      state: 'state',
      username: 'test',
      biography: 'test biography'
    },
    {
      id: 3, name: 'Category 1',
      email: 'michaelhamptondesign@yahoo.com',
      phone: '07851624051',
      profile_picture: '',
      active: false,
      address1: 'test',
      address2: 'test2',
      zip: 'zip',
      city: 'city',
      state: 'state',
      username: 'test',
      biography: 'test biography'
    },
    {
      id: 4, name: 'Category 1',
      email: 'michaelhamptondesign@yahoo.com',
      phone: '07851624051',
      profile_picture: '',
      active: false,
      address1: 'test',
      address2: 'test2',
      zip: 'zip',
      city: 'city',
      state: 'state',
      username: 'test',
      biography: 'test biography'
    },
    {
      id: 5, name: 'Category 1',
      email: 'michaelhamptondesign@yahoo.com',
      phone: '07851624051',
      profile_picture: '',
      active: false,
      address1: 'test',
      address2: 'test2',
      zip: 'zip',
      city: 'city',
      state: 'state',
      username: 'test',
      biography: 'test biography'

    },
  ]

  constructor(private baseHttpClient: BaseHttpClient) { }

  delete(id: number) {
    alert('deleting')
    return of(this.users);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  create(payload: Partial<Seller>) {
    alert('creating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  update(id: number, payload: Partial<Seller>) {
    alert('updating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getAll(){
    return of({data: this.users[0]})
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getSeller(id: number){
    return this.baseHttpClient.getById(`${MODULE}/${id}`);
    // return of({data: this.users[0]})
  }
}
