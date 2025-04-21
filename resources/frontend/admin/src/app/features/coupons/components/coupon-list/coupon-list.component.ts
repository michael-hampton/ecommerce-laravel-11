import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import { Config } from 'datatables.net';
import { Subscription } from 'rxjs';
import {ModalService} from '../../../../services/modal.service';
import {CouponStore} from '../../../../store/coupons/list.store';
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {FormComponent} from '../form/form.component';
import {Brand} from "../../../../types/brands/brand";
import {Category} from "../../../../types/categories/category";
import {defaultPaging, FilterModel} from '../../../../types/filter.model';
import {CategoryStore} from '../../../../store/categories/list.store';

@Component({
  selector: 'app-coupon-list',
  standalone: false,
  templateUrl: './coupon-list.component.html',
  styleUrl: './coupon-list.component.scss'
})
export class CouponListComponent implements OnInit {
  dtOptions: Config = {};
  @ViewChild('confirmationModal')
  private deleteModalComponent!: ViewContainerRef;
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;
  sortBy: string = 'code'
  sortAsc: boolean = true

  private _store: CouponStore = inject(CouponStore)
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
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit Coupon'})
      .subscribe((v) => {
      });
  }

  add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create Attribute'})
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
