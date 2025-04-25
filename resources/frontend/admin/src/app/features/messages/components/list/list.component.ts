import {Component, inject, OnInit} from '@angular/core';
import {MessageStore} from '../../../../store/messages/list.store';

@Component({
  selector: 'app-list',
  standalone: false,
  templateUrl: './list.component.html',
  styleUrl: './list.component.scss',
  providers: [MessageStore]
})
export class ListComponent implements OnInit {
  private _store = inject(MessageStore)
  vm$ = this._store.vm$

  ngOnInit(): void {
    this._store.loadData(this._store.filter$);
  }

  paginationChanged(page: number) {
    this._store.updatePage(page);
  }
}
