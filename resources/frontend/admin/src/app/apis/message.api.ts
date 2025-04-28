import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {Attribute} from '../types/attributes/attribute';
import {FilterModel, PagedData} from '../types/filter.model';
import {BaseHttpClient} from './base.http-client';
import {environment} from '../../environments/environment';
import {Message, SaveMessage} from '../types/messages/message';

export const MODULE = 'messages'

@Injectable({
  providedIn: 'root'
})
export class MessageApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) {
  }

  delete(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }

  create(payload: Partial<SaveMessage>) {
    const formData = this.baseHttpClient.getFormData(payload)
    Array.from(payload.images).forEach((file: File) => { formData.append('images[]', file); });
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, formData);
  }

  update(id: number, payload: Partial<Attribute>) {
    return this.httpClient.put(`${environment.apiUrl}/${MODULE}/${id}`, payload);
  }

  getData(filter: FilterModel): Observable<any> {
    return this.baseHttpClient.get(filter, MODULE);
  }

  getMessageDetails(messageId: number): Observable<any> {
    return this.httpClient.get(`${environment.apiUrl}/${MODULE}/${messageId}`)
  }
}
