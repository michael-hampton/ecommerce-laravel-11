import { Injectable } from '@angular/core';
import { ComponentStore } from '@ngrx/component-store';
import { tapResponse } from '@ngrx/operators'
import {pipe, switchMap, tap} from 'rxjs';
import {HttpErrorResponse} from '@angular/common/http';
import {GlobalStore} from './global.store';
import {Category} from '../types/categories/category';
import {Attribute} from '../types/attributes/attribute';
import {Brand} from '../types/brands/brand';
import {LookupApi} from '../apis/lookup.api';
import {Order} from '../types/orders/order';


export interface GlobalState {
  loading: boolean;
  error: string;
  success: string
  categories: Category[];
  subcategories: Category[];
  attributes: Attribute[],
  brands: Brand[];
  orders: Order[]

}

const defaultState: GlobalState = {
  loading: false,
  error: '',
  success: '',
  categories: [],
  brands: [],
  subcategories: [],
  attributes: [],
  orders: []
};

@Injectable({
  providedIn: 'root'
})
export class LookupStore extends ComponentStore<GlobalState> {
  constructor(private _lookupService: LookupApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  private readonly categories$ = this.select((state) => state.categories);
  vm$ = this.select(state => ({
    categories: state.categories,
    brands: state.brands,
    attributes: state.attributes,
    subcategories: state.subcategories,
    orders: state.orders
  }))


  getCategories = this.effect<void>(
    // Standalone observable chain. An Observable<void> will be attached by ComponentStore.
    pipe(
      tap(() => this.patchState({loading: true})),
      switchMap(filter =>
        this._lookupService.getCategories().pipe(
          tapResponse({
            next: (categories) => this.patchState({categories: categories.data}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(error.message),
            finalize: () => this.patchState({loading: false}),
          })
        )
      )
    ));

  getOrders = this.effect<void>(
    // Standalone observable chain. An Observable<void> will be attached by ComponentStore.
    pipe(
      tap(() => this.patchState({loading: true})),
      switchMap(filter =>
        this._lookupService.getOrders().pipe(
          tapResponse({
            next: (orders) => this.patchState({orders: orders.data}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(error.message),
            finalize: () => this.patchState({loading: false}),
          })
        )
      )
    ));

  readonly getSubcategories = this.effect<number>((categoryId) => {
    return categoryId.pipe(
      tap(() => this.patchState({ loading: true })),
      switchMap(categoryId =>
        this._lookupService.getSubcategories(categoryId).pipe(
          tapResponse({
            next: (subcategories) => this.patchState({ subcategories: subcategories.data }),
            error: (error: HttpErrorResponse) => this._globalStore.setError(error.message),
            finalize: () => this.patchState({ loading: false }),
          })
        )
      )
    );
  });

  getBrands = this.effect<void>(
    // Standalone observable chain. An Observable<void> will be attached by ComponentStore.
    pipe(
      tap(() => this.patchState({loading: true})),
      switchMap(filter =>
        this._lookupService.getBrands().pipe(
          tapResponse({
            next: (brands) => this.patchState({brands: brands.data}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(error.message),
            finalize: () => this.patchState({loading: false}),
          })
        )
      )
    ));

  getAttributes = this.effect<void>(
    // Standalone observable chain. An Observable<void> will be attached by ComponentStore.
    pipe(
      tap(() => this.patchState({loading: true})),
      switchMap(filter =>
        this._lookupService.getAttributes().pipe(
          tapResponse({
            next: (attributes) => this.patchState({attributes: attributes.data}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(error.message),
            finalize: () => this.patchState({loading: false}),
          })
        )
      )
    ));
}
