import {ComponentFactoryResolver, ComponentRef, Injectable, Type, ViewContainerRef} from '@angular/core';
import {Subject} from 'rxjs';
import {ModalComponent} from '../shared/components/modal/modal.component';
import {ModalConfig} from '../shared/components/modal/modal.config';

@Injectable({
  providedIn: 'root'
})
export class ModalService {
  private componentRef!: ComponentRef<ModalComponent>;
  private componentSubscriber!: Subject<string>;
  constructor(private resolver: ComponentFactoryResolver) {}

  openModal(type: Type<ModalComponent>, entry: ViewContainerRef, formData: any, config: ModalConfig) {
    let factory = this.resolver.resolveComponentFactory(type);
    this.componentRef = entry.createComponent(factory);
    console.log(this.componentRef.instance)
    this.componentRef.instance.title = config.modalTitle;
    this.componentRef.instance.formData = formData;
    this.componentRef.instance.modalService = this;
    this.componentRef.instance.saveButtonText = 'Save';
    this.componentRef.instance.saveButtonClass = 'btn-primary';
    this.componentRef.instance.closeMeEvent.subscribe(() => this.closeModal());
    this.componentRef.instance.confirmEvent.subscribe(() => this.confirm());
    this.componentSubscriber = new Subject<string>();
    return this.componentSubscriber.asObservable();
  }

  openConfirmationModal(type: Type<ModalComponent>, entry: ViewContainerRef, formData: any, config: ModalConfig) {
    let factory = this.resolver.resolveComponentFactory(type);
    this.componentRef = entry.createComponent(factory);
    console.log(this.componentRef.instance)
    this.componentRef.instance.title = config.modalTitle;
    this.componentRef.instance.body = config.modalBody ?? '';
    this.componentRef.instance.saveButtonText = 'Delete';
    this.componentRef.instance.saveButtonClass = 'btn-danger';
    this.componentRef.instance.formData = formData;
    this.componentRef.instance.closeMeEvent.subscribe(() => this.closeModal());
    this.componentRef.instance.confirmEvent.subscribe(() => this.confirm());
    this.componentSubscriber = new Subject<string>();
    return this.componentSubscriber.asObservable();
  }

  closeModal() {
    this.componentSubscriber.complete();
    this.componentRef.destroy();
  }

  confirm() {
    this.componentSubscriber.next('confirm');
    this.closeModal();
  }
}
