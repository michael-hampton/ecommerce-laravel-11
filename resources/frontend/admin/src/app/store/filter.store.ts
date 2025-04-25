import {ComponentStore} from '@ngrx/component-store';
import {FilterModel, FilterState} from '../types/filter.model';
import {firstValueFrom} from 'rxjs';

export class FilterStore<T extends object> extends ComponentStore<FilterState<T>> {

  initialState: FilterState<T>;

  constructor(classState: any) {
    super(classState);
    this.initialState = classState;
  }

  readonly filter$ = this.select(({filter}) => filter);

  readonly updateFilter = this.updater((state, filter: FilterModel): {filter: FilterModel} => ({
    filter: filter,
  }));

  async reset() {
    const res = {
      ...this.initialState,
      filter: {
        ...this.initialState.filter, ...{page: this.initialState.filter.page}
      }
    };

    console.log('res', res)
    this.patchState(res)
  }
}
