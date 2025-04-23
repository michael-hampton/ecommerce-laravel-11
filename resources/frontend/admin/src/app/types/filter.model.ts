import {User} from './users/user';

export type FilterModel = {
  page: number;
  limit: number;
  sortBy: string;
  sortAsc: boolean;
  searchText?: string
}

export const defaultPaging: FilterModel = {
  page: 1,
  limit: 10,
  sortBy: 'name',
  sortAsc: true,
  searchText: ''
}

export type PagedData<T> = {
  current_page: number
  total: number
  per_page: number;
  data: T[]
}

export interface FilterState<T> {
  filter: FilterModel,
  data: PagedData<T>
}

