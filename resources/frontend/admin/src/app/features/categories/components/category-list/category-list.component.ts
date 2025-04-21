import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from 'datatables.net';
import {Subscription} from 'rxjs';
import {CategoryStore} from "../../../../store/categories/list.store";
import {ModalService} from "../../../../services/modal.service";
import {Category} from "../../../../types/categories/category";
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {FormComponent} from '../form/form.component';
import {defaultPaging, FilterModel} from '../../../../types/filter.model';

@Component({
  selector: 'app-category-list',
  standalone: false,
  templateUrl: './category-list.component.html',
  styleUrl: './category-list.component.scss'
})
export class CategoryListComponent implements OnInit {
  dtOptions: Config = {};
  @ViewChild('confirmationModal')
  private deleteModalComponent!: ViewContainerRef;
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;
  sortBy: string = 'test'
  sortAsc: boolean = true

  private _store: CategoryStore = inject(CategoryStore)
  vm$ = this._store.vm$

  constructor(
    private modalService: ModalService,
  ) {
  }

  ngOnInit(): void {
   this._store.loadData(defaultPaging);
  }

  delete = async (data: any) => {
    this.sub = this.modalService
      .openConfirmationModal(ModalComponent, this.entry, data, {modalTitle: 'Are you sure?', modalBody: 'click confirm or close'})
      .subscribe((v) => {
        this._store.delete(data.id)
      });
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit Category'})
      .subscribe((v) => {
        this.modalService.closeModal();
      });
  }

  add(event: Event) {
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create Category'})
      .subscribe((v) => {

      });
  }

  pageChanged(event: FilterModel) {
    this.sortBy = event.sortBy
    this.sortAsc = event.sortAsc
    const startIndex = (event.page - 1) * event.limit
    const endIndex = event.page * event.limit

    this._store.loadData(event);
  }

  reload() {
    this._store.loadData(defaultPaging);
  }
}
