import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {formatDate} from '@angular/common';
import {Order} from '../types/orders/order';
import {FilterModel, PagedData} from '../types/filter.model';
import {Category} from '../types/categories/category';
import {User} from '../types/users/user';
import {BaseHttpClient} from './base.http-client';

export const MODULE = 'orders'

@Injectable({
  providedIn: 'root'
})
export class OrderApi {

  private orders: Order[] = [
    {
      id: 1,
      customer_id: 0,
      subtotal: 0,
      shipping: 0,
      discount: 0,
      tax: 0,
      status: '',
      is_shipping_different: false,
      note: '',
      delivery_date: '',
      cancelled_date: '',
      address_id: 0,
      review_status: '',
      total: 0,
      commission: 0,
      tracking_number: 0,
      courier_name: '',
      customer: {
        id: 1,
        name: 'Michael Hampton',
        email: '',
        password: '',
        mobile: '07851624051',
        image: '',
        utype: '',
        active: false
      },
      order_date: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      number_of_items: 9,
      delivered_date: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      address: {
        phone: '',
        address1: '',
        address2: '',
        zip: '',
        state: '',
        city: '',
        country: ''
      }
    },
    {
      id: 2,
      customer_id: 0,
      subtotal: 0,
      shipping: 0,
      discount: 0,
      tax: 0,
      status: '',
      is_shipping_different: false,
      note: '',
      delivery_date: '',
      cancelled_date: '',
      address_id: 0,
      review_status: '',
      total: 0,
      commission: 0,
      tracking_number: 0,
      courier_name: '',
      customer: {
        id: 1,
        name: 'Michael Hampton',
        email: '',
        password: '',
        mobile: '07851624051',
        image: '',
        utype: '',
        active: false
      },
      order_date: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      number_of_items: 8,
      delivered_date: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      address: {
        phone: '',
        address1: '',
        address2: '',
        zip: '',
        state: '',
        city: '',
        country: ''
      }
    }, {
      id: 3,
      customer_id: 0,
      subtotal: 0,
      shipping: 0,
      discount: 0,
      tax: 0,
      status: '',
      is_shipping_different: false,
      note: '',
      delivery_date: '',
      cancelled_date: '',
      address_id: 0,
      review_status: '',
      total: 0,
      commission: 0,
      tracking_number: 0,
      courier_name: '',
      customer: {
        id: 1,
        name: 'Michael Hampton',
        email: '',
        password: '',
        mobile: '07851624051',
        image: '',
        utype: '',
        active: false
      },
      order_date: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      number_of_items: 7,
      delivered_date: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      address: {
        phone: '',
        address1: '',
        address2: '',
        zip: '',
        state: '',
        city: '',
        country: ''
      }
    }, {
      id: 4,
      customer_id: 0,
      subtotal: 0,
      shipping: 0,
      discount: 0,
      tax: 0,
      status: '',
      is_shipping_different: false,
      note: '',
      delivery_date: '',
      cancelled_date: '',
      address_id: 0,
      review_status: '',
      total: 0,
      commission: 0,
      tracking_number: 0,
      courier_name: '',
      customer: {
        id: 1,
        name: 'Michael Hampton',
        email: '',
        password: '',
        mobile: '07851624051',
        image: '',
        utype: '',
        active: false
      },
      order_date: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      number_of_items: 6,
      delivered_date: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      address: {
        phone: '',
        address1: '',
        address2: '',
        zip: '',
        state: '',
        city: '',
        country: ''
      }
    }, {
      id: 5,
      customer_id: 0,
      subtotal: 0,
      shipping: 0,
      discount: 0,
      tax: 0,
      status: '',
      is_shipping_different: false,
      note: '',
      delivery_date: '',
      cancelled_date: '',
      address_id: 0,
      review_status: '',
      total: 0,
      commission: 0,
      tracking_number: 0,
      courier_name: '',
      customer: {
        id: 1,
        name: 'Michael Hampton',
        email: '',
        password: '',
        mobile: '07851624051',
        image: '',
        utype: '',
        active: false
      },
      order_date: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      number_of_items: 5,
      delivered_date: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      address: {
        phone: '',
        address1: '',
        address2: '',
        zip: '',
        state: '',
        city: '',
        country: ''
      }
    },
  ]

  constructor(private baseHttpClient: BaseHttpClient) { }

  delete(id: number) {
    alert('deleting')
    return of(this.orders);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getData(filter: FilterModel): Observable<any>{
    return this.baseHttpClient.get(filter, MODULE);
    //return of({data: this.orders, current_page: 1, total: this.orders.length} as PagedData<Order>)
  }
}
