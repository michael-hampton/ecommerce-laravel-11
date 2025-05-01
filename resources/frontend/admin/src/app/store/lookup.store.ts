import {Injectable} from '@angular/core';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {Observable, pipe, switchMap, tap} from 'rxjs';
import {HttpErrorResponse} from '@angular/common/http';
import {GlobalStore} from './global.store';
import {Category} from '../types/categories/category';
import {Attribute} from '../types/attributes/attribute';
import {Brand} from '../types/brands/brand';
import {LookupApi} from '../apis/lookup.api';
import {Order} from '../types/orders/order';
import {UiError} from '../core/services/exception.service';
import {Courier} from '../types/couriers/courier';


export interface GlobalState {
  loading: boolean;
  error: string;
  success: string
  categories: Category[];
  subcategories: Category[];
  attributes: Attribute[],
  brands: Brand[];
  orders: Order[]
  couriers: Courier[]

}

const defaultState: GlobalState = {
  loading: false,
  error: '',
  success: '',
  categories: [],
  brands: [],
  subcategories: [],
  attributes: [],
  orders: [],
  couriers: []
};

@Injectable({
  providedIn: 'root'
})
export class LookupStore extends ComponentStore<GlobalState> {
  constructor(private _lookupService: LookupApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly attributes$ = this.select((state) => state.attributes);

  vm$ = this.select(state => ({
    categories: state.categories,
    brands: state.brands,
    attributes: state.attributes,
    subcategories: state.subcategories,
    orders: state.orders,
    couriers: state.couriers
  }))


  getCategories = this.effect<void>(
    // Standalone observable chain. An Observable<void> will be attached by ComponentStore.
    pipe(
      tap(() => this.patchState({loading: true})),
      switchMap(filter =>
        this._lookupService.getCategories().pipe(
          tapResponse({
            next: (categories) => this.patchState({categories: categories as Category[]}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
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
            next: (orders) => this.patchState({orders: orders as Order[]}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            finalize: () => this.patchState({loading: false}),
          })
        )
      )
    ));

  getBrands = this.effect<void>(
    // Standalone observable chain. An Observable<void> will be attached by ComponentStore.
    pipe(
      tap(() => this.patchState({loading: true})),
      switchMap(filter =>
        this._lookupService.getBrands().pipe(
          tapResponse({
            next: (brands) => this.patchState({brands: brands as Brand[]}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            finalize: () => this.patchState({loading: false}),
          })
        )
      )
    ));

  getCouriers() {
    // Standalone observable chain. An Observable<void> will be attached by ComponentStore.
    return this._lookupService.getCouriers().pipe(
      tapResponse({
        next: (couriers) => this.patchState({couriers: couriers as Courier[]}),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this.patchState({loading: false}),
      })
    )
  }

  readonly getAttributesForCategory = this.effect((categoryId$: Observable<number>) => {
    return categoryId$.pipe(
      tap(() => this.patchState({loading: true})),
      switchMap(categoryId =>
        this._lookupService.getAttributesForCategory(categoryId).pipe(
          tapResponse({
            next: (attributes) => this.patchState({attributes: attributes as Attribute[]}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            finalize: () => this.patchState({loading: false}),
          })
        )
      )
    );
  });

  readonly getAttributes = this.effect<void>(
    // The name of the source stream doesn't matter: `trigger$`, `source$` or `$` are good 
    // names. We encourage to choose one of these and use them consistently in your codebase.
    (trigger$) => trigger$.pipe(
      switchMap(() =>
        this._lookupService.getAttributes().pipe(
          tapResponse({
            next: (attributes) => this.patchState({attributes: attributes as Attribute[]}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            finalize: () => this.patchState({loading: false}),
          })
        )
      )
    )
  );
}
