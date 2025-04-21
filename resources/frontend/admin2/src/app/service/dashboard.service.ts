import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';

export const MODULE = 'admin'

@Injectable({
  providedIn: 'root'
})
export class DashboardService {

  constructor(private httpclient: HttpClient) { }

  getData(){
    return this.httpclient.get(`${environment.apiUrl}/${MODULE}`);
  }
}
