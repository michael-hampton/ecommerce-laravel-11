import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import { Config } from 'datatables.net';
import { Subscription } from 'rxjs';
import {ModalService} from '../../../../services/modal.service';
import {CouponStore} from '../../../../store/coupons/list.store';
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {FormComponent} from '../form/form.component';
import {defaultPaging, FilterModel} from '../../../../types/filter.model';

@Component({
  selector: 'app-coupon-list',
  standalone: false,
  templateUrl: './coupon-list.component.html',
  styleUrl: './coupon-list.component.scss'
})
export class CouponListComponent implements OnInit {
  dtOptions: Config = {};
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;

  private _store: CouponStore = inject(CouponStore)
  vm$ = this._store.vm$

  constructor(
    private modalService: ModalService,
  ) {
  }

  ngOnInit(): void {
    this._store.loadData(this._store.filter$);
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

  pageChanged(filter: FilterModel) {
    alert('here666')
    this._store.updateFilter(filter)
  }

  reload() {
    alert('yes33')
    this._store.reset();
  }
}
