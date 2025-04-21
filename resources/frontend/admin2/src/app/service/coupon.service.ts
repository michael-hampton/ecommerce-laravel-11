import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {of} from 'rxjs';
import {Coupon} from '../data/coupon';
import {formatDate} from '@angular/common';
import {Brand} from '../data/brand';

export const MODULE = 'admin/coupons'

@Injectable({
  providedIn: 'root'
})
export class CouponService {

  private coupons: Coupon[] = [
    {
      id: 1, code: 'Category 1',
      type: 'fixed',
      value: 20,
      cart_value: 2,
      expires_at: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      brands: [{
        id: 1,
        name: 'test 1',
        slug: '',
        image: '',
        products: 0
      }, {
        id: 2,
        name: 'test 2',
        slug: '',
        image: '',
        products: 0
      }],
      categories: [{
        id: 1,
        name: 'test 1',
        slug: '',
        image: '',
        parent_id: 0
      }, {
        id: 2,
        name: 'test 2',
        slug: '',
        image: '',
        parent_id: 0
      }],
      seller_id: 0,
      usages: 0
    },
    {
      id: 2, code: 'Category 1',
      type: 'fixed',
      value: 20,
      cart_value: 2,
      expires_at: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      brands: [{
        id: 1,
        name: 'test 1',
        slug: '',
        image: '',
        products: 0
      }, {
        id: 2,
        name: 'test 2',
        slug: '',
        image: '',
        products: 0
      }],
      categories: [{
        id: 1,
        name: 'test 1',
        slug: '',
        image: '',
        parent_id: 0
      }, {
        id: 2,
        name: 'test 2',
        slug: '',
        image: '',
        parent_id: 0
      }],
      seller_id: 0,
      usages: 0
    },
    {
      id: 3, code: 'Category 1',
      type: 'fixed',
      value: 20,
      cart_value: 2,
      expires_at: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      brands: [{
        id: 1,
        name: 'test 1',
        slug: '',
        image: '',
        products: 0
      }, {
        id: 2,
        name: 'test 2',
        slug: '',
        image: '',
        products: 0
      }],
      categories: [{
        id: 1,
        name: 'test 1',
        slug: '',
        image: '',
        parent_id: 0
      }, {
        id: 2,
        name: 'test 2',
        slug: '',
        image: '',
        parent_id: 0
      }],
      seller_id: 0,
      usages: 0
    },
    {
      id: 4, code: 'Category 1',
      type: 'fixed',
      value: 20,
      cart_value: 2,
      expires_at: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      brands: [{
        id: 1,
        name: 'test 1',
        slug: '',
        image: '',
        products: 0
      }, {
        id: 2,
        name: 'test 2',
        slug: '',
        image: '',
        products: 0
      }],
      categories: [{
        id: 1,
        name: 'test 1',
        slug: '',
        image: '',
        parent_id: 0
      }, {
        id: 2,
        name: 'test 2',
        slug: '',
        image: '',
        parent_id: 0
      }],
      seller_id: 0,
      usages: 0
    },
    {
      id: 5, code: 'Category 1',
      type: 'fixed',
      value: 20,
      cart_value: 2,
      expires_at: formatDate(new Date(), 'yyyy-MM-dd hh:mm:ssZZZZZ', 'en_US'),
      brands: [{
        id: 1,
        name: 'test 1',
        slug: '',
        image: '',
        products: 0
      }, {
        id: 2,
        name: 'test 2',
        slug: '',
        image: '',
        products: 0
      }],
      categories: [{
        id: 1,
        name: 'test 1',
        slug: '',
        image: '',
        parent_id: 0
      }, {
        id: 2,
        name: 'test 2',
        slug: '',
        image: '',
        parent_id: 0
      }],
      seller_id: 0,
      usages: 0
    },
  ]

  constructor(private httpclient: HttpClient) { }

  create(payload: Partial<Coupon>) {
    alert('creating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  update(id: number, payload: Partial<Coupon>) {
    alert('updating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  delete(id: number) {
    alert('deleting')
    return of(this.coupons);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getData(){
    return of({data: this.coupons})
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }
}
