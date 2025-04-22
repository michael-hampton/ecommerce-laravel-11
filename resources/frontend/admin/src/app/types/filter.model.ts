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
  sortAsc: true
}

export type PagedData<T> = {
  page: number
  totalCount: number
  data: T[]
}

export interface FilterState<T> {
  filter: FilterModel,
  data: PagedData<T>
}

