import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from "datatables.net";
import {Subscription} from "rxjs";
import {ModalService} from "../../../../services/modal.service";
import {SlideStore} from "../../../../store/slides/list.store";
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {FormComponent} from '../form/form.component';
import {defaultPaging, FilterModel} from '../../../../types/filter.model';
import {CategoryStore} from '../../../../store/categories/list.store';

@Component({
  selector: 'app-slide-list',
  standalone: false,
  templateUrl: './slide-list.component.html',
  styleUrl: './slide-list.component.scss'
})
export class SlideListComponent implements OnInit {
  dtOptions: Config = {};
  @ViewChild('confirmationModal')
  private deleteModalComponent!: ViewContainerRef;
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;
  sortBy: string = 'name'
  sortAsc: boolean = true

  private _store: SlideStore = inject(SlideStore)
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
      .openConfirmationModal(ModalComponent, this.entry, data, {
        modalTitle: 'Are you sure?',
        modalBody: 'click confirm or close'
      })
      .subscribe((v) => {
        this._store.delete(data.id)
      });
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit Slide'})
      .subscribe((v) => {
      });
  }

  add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create Slide'})
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

