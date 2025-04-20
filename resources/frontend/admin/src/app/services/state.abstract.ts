import { BehaviorSubject, Observable } from 'rxjs';
import { clone } from '../core/common';
import { debug } from '../core/rxjsops';

export interface IListItem {
  id: string;
}
export interface IList<T> {
  total: number;
  matches: T[];
}

export interface IListOptions {
  page?: number;
  size?: number;
  category?: string;
  total?: number;
  hasMore?: boolean;
  isPublic?: boolean;
}

export class ListStateService<T extends IListItem> {
  protected stateList: BehaviorSubject<T[]> = new BehaviorSubject([]);
  stateList$: Observable<T[]> = this.stateList
    .asObservable()
    // log
    .pipe(debug(this.constructor.name));

  get currentList(): T[] {
    return this.stateList.getValue();
  }

  SetList(list: T[]): Observable<T[]> {
    this.stateList.next(list);
    return this.stateList$;
  }

  appendList(list: T[]): Observable<T[]> {
    return this.SetList([...this.currentList, ...list]);
  }

  emptyList() {
    this.stateList.next([]);
  }

  addItem(item: T): void {
    this.stateList.next([...this.currentList, item]);
  }
  prependItem(item: T): void {
    this.stateList.next([item, ...this.currentList]);
  }

  editItem(item: T): void {
    const currentList = [...this.currentList];
    const index = currentList.findIndex((n) => n.id === item.id);
    if (index > -1) {
      currentList[index] = clone(item); // use a proper cloner
      this.stateList.next(currentList);
    }
  }
  removeItem(item: T): void {
    this.stateList.next(this.currentList.filter((n) => n.id !== item.id));
  }
}

export class StateService<T> {
  protected stateItem: BehaviorSubject<T | null> = new BehaviorSubject(null);
  stateItem$: Observable<T | null> = this.stateItem
    .asObservable()
    // log
    .pipe(debug(this.constructor.name));

  get currentItem(): T | null {
    return this.stateItem.getValue();
  }

  SetState(item: T): Observable<T | null> {
    alert('here444')
    this.stateItem.next(item);
    return this.stateItem$;
  }

  UpdateState(item: Partial<T>): Observable<T | null> {
    const newItem = { ...this.currentItem, ...clone(item) };
    this.stateItem.next(newItem);
    return this.stateItem$;
  }

  RemoveState(): void {
    this.stateItem.next(null);
  }
}
