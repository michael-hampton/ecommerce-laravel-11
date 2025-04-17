import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {BASE_URL} from '../config';

export const MODULE = 'admin'

@Injectable({
  providedIn: 'root'
})
export class DashboardService {

  constructor(private httpclient: HttpClient) { }

  getData(){
    return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }
}
