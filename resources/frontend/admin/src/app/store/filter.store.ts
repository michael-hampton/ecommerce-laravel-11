import { ComponentStore } from '@ngrx/component-store';
import { FilterModel, FilterState, SearchFilter, SearchFilterModel } from '../types/filter.model';

export class FilterStore<T extends object> extends ComponentStore<FilterState<T>> {

  initialState: FilterState<T>;

  constructor(classState: any) {
    super(classState);
    this.initialState = classState;
  }

  readonly filter$ = this.select(({ filter }) => filter);

  updateFilter(filters: FilterModel) {
    this.patchState((state) => ({
      filter: {
        ...state.filter, ...{
          ...filters, ...{ searchFilters: this.applyFilters(state, filters) }
        }
      }
    }));
  }

  applyFilters(state: FilterState<T>, filter: FilterModel) {
    if (!state.filter.searchFilters.length) {
      return filter.searchFilters.filter(x => x.value !== undefined)
    }

    let searchParams: SearchFilter[] = state.filter.searchFilters

    Object.keys(searchParams).forEach(index => {
      filter.searchFilters.forEach(element2 => {
        if (element2.column === searchParams[index]?.column) {
          if (element2.value !== undefined && element2.value !== '') {
            searchParams[index].value = element2.value
          } else {
            searchParams = searchParams.filter(x => x.column !== element2.column)

          }
        }
      })
    });

    filter.searchFilters.forEach(element2 => {
      const found = searchParams.find(x => x.column === element2.column)

      if (!found && element2.value) {
        searchParams.push(element2)
      }
    });

    return searchParams
  }

  async reset() {
    this.patchState((state) => ({
      filter: {
        ...this.initialState.filter, ...{
          page: state.filter.page,
          searchText: state.filter.searchText,
          sortBy: state.filter.sortBy,
          sortDir: state.filter.sortDir
        }
      }
    }));
  }
}