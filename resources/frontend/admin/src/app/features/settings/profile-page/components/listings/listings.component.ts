import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Subscription} from 'rxjs';
import { ProductStore } from '../../../../../store/products/list.store';
import { GlobalStore } from '../../../../../store/global.store';
import { ModalService } from '../../../../../services/modal.service';
import { ProductFormComponent } from '../../../../../shared/components/product-form/product-form.component';
import { defaultPaging, FilterModel } from '../../../../../types/filter.model';

@Component({
  selector: 'app-listings',
  standalone: false,
  templateUrl: './listings.component.html',
  styleUrl: './listings.component.scss',
  providers: [ProductStore]
})
export class ListingsComponent implements OnInit {
  @ViewChild('editModal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;

  private _store: ProductStore = inject(ProductStore)
  vm$ = this._store.vm$

  private _globalStore = inject(GlobalStore)
  globalvm$ = this._globalStore.vm$
  activeTab: string;

  constructor(
    private modalService: ModalService,
  ) {
  }

  ngOnInit(): void {
    this._store.loadData(this._store.filter$);
  }

  edit(data: any) {console.log('here', this.entry)
    this.sub = this.modalService
      .openModal(ProductFormComponent, this.entry, data, {modalTitle: 'Edit Product'})
      .subscribe((v) => {
        this._store.reset();
      });
  }

   pageChanged(filter: FilterModel) {
    const searchFilters = []
    searchFilters.push({
      column: 'name',
      value: filter.searchText ? `%${filter.searchText}%` : undefined,
      operator: 'like'
    })
    filter = { ...filter, ...{ searchFilters: searchFilters } }

    this._store.updateFilter(filter)

  }

  filterChanged(column: string, value: string) {
      this.activeTab = value
      const searchFilters = []
      searchFilters.push({
        column: column,
        value: value === 'published' ? true : false,
        operator: '='
      })
      const obj: FilterModel = { ...defaultPaging, ...{ searchFilters: searchFilters } }
  
      this._store.updateFilter(obj)
    }

  reload() {
    this._store.reset();
  }
}
