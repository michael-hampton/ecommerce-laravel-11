import {ComponentStore} from '@ngrx/component-store';
import {defaultPaging, FilterModel, FilterState, PagedData} from '../types/filter.model';

export class FilterStore<T extends object> extends ComponentStore<FilterState<T>> {

  constructor(classState: any) {
    super(classState);
  }

  readonly filter$ = this.select(({filter}) => filter);

  updateFilter(filter: FilterModel) {
    this.patchState({filter: filter})
  }

  reset() {
    this.patchState({filter: defaultPaging})
  }
}
