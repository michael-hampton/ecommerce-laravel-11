import { User } from './users/user';

export type FilterModel = {
  page: number;
  limit: number;
  sortBy: string;
  sortDir: string;
  searchText?: string
  searchFilters?: SearchFilter[]

}

export type SearchFilterModel = {
  searchFilters?: SearchFilter[]
}

export type SearchFilter = {
  column: string
  value: string
  operator: string
}

export const defaultPaging: FilterModel = {
  page: 1,
  limit: 10,
  sortBy: 'name',
  sortDir: 'asc',
  searchText: '',
  searchFilters: []
}

export type PagedData<T> = {
  current_page: number
  total: number
  per_page: number;
  data: T[]
}

export interface FilterState<T> {
  filter: FilterModel,
  data?: PagedData<T>
  loading?: boolean
}

