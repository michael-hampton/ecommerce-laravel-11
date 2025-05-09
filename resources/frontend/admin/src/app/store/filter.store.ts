import { ComponentStore } from '@ngrx/component-store';
import { FilterModel, FilterState } from '../types/filter.model';
import { firstValueFrom } from 'rxjs';

export class FilterStore<T extends object> extends ComponentStore<FilterState<T>> {

  initialState: FilterState<T>;

  constructor(classState: any) {
    super(classState);
    this.initialState = classState;
  }

  readonly filter$ = this.select(({ filter }) => filter);

  readonly updateFilter = this.updater((state, filter: FilterModel): { filter: FilterModel } => ({
    filter: filter,
  }));

  async reset() {
    this.patchState((state) => ({
      filter: { ...this.initialState.filter, ...{ 
        page: state.filter.page, 
        searchText: state.filter.searchText, 
        sortBy: state.filter.sortBy, 
        sortDir: state.filter.sortDir 
      }}
    }));
  }
}