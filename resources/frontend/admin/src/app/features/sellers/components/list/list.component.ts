import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from 'datatables.net';
import {Subscription} from 'rxjs';
import {ModalService} from '../../../../services/modal.service';
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {defaultPaging, FilterModel} from '../../../../types/filter.model';
import {SellerStore} from '../../../../store/sellers/list.store';
import {Seller} from '../../../../types/seller/seller';

@Component({
  selector: 'app-list',
  standalone: false,
  templateUrl: './list.component.html',
  styleUrl: './list.component.scss',
  providers: [SellerStore]
})
export class ListComponent implements OnInit {
  dtOptions: Config = {};
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;

  private _store: SellerStore = inject(SellerStore)
  vm$ = this._store.vm$

  constructor(
    private modalService: ModalService,
  ) {
  }

  ngOnInit(): void {
    this._store.loadData(this._store.filter$);
  }

  makeActive(data: Seller) {
   this._store.makeActive(data.active !== true, data.id).subscribe(result => {
     this._store.loadData(this._store.filter$);
   })
  }
  delete = async (data: any) => {
    this.sub = this.modalService
      .openConfirmationModal(ModalComponent, this.entry, data, {
        modalTitle: 'Are you sure?',
        modalBody: 'click confirm or close'
      })
      .subscribe((v) => {
        this._store.delete(data.id)
        this._store.reset();
      });
  }

  /*add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create Seller'})
      .subscribe((v) => {
        this._store.reset();
      });
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit Seller'})
      .subscribe((v) => {
        this._store.reset();
      });
  }*/

  pageChanged(filter: FilterModel) {
    this._store.updateFilter(filter)
  }

  reload() {
    this._store.reset();
  }
}
