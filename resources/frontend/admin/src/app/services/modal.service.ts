import { ApplicationRef, ComponentFactoryResolver, ComponentRef, createComponent, inject, Injectable, Type, ViewContainerRef } from '@angular/core';
import { Subject } from 'rxjs';
import { ModalComponent } from '../shared/components/modal/modal.component';
import { ModalConfig } from '../shared/components/modal/modal.config';
import { DeleteModalComponent } from '../shared/components/delete-modal/delete-modal.component';

@Injectable({
  providedIn: 'root'
})
export class ModalService {
  private componentRef!: ComponentRef<ModalComponent>;
  private componentSubscriber!: Subject<string>;
  private app = inject(ApplicationRef)

  constructor(private resolver: ComponentFactoryResolver) { }

  openModal(type: Type<ModalComponent>, formData: any, config: ModalConfig) {

    const { modal, modalBody } = this.buildModal(config, config.size || 'modal-xl')

    this.componentRef = createComponent(type, {
      environmentInjector: this.app.injector,
      hostElement: modalBody,
    });

    this.app.attachView(this.componentRef.hostView)

    this.componentRef.instance.callback = config.callback;
    this.componentRef.instance.formData = formData;
    this.componentRef.instance.saveButtonText = 'Save';
    this.componentRef.instance.saveButtonClass = 'btn-primary';
    this.componentRef.instance.closeMeEvent.subscribe(() => {
      this.closeModal()
      modal.remove()
    });
    this.componentRef.instance.confirmEvent.subscribe(() => {
      modal.remove()
      this.confirm()
    });
    this.componentSubscriber = new Subject<string>();
    return this.componentSubscriber.asObservable();
  }

  buildModal(config, size: string = 'modal-xl') {
    const modal = document.createElement("div");
    modal.classList.add('modal', 'show', 'd-block', size)
    const modalDialog = document.createElement('div')
    modalDialog.classList.add('modal-dialog')
    const modalContent = document.createElement('div')
    modalContent.classList.add('modal-content')
    modalDialog.prepend(modalContent)
    const modalHeader = document.createElement('div')
    modalHeader.classList.add('modal-header')
    modalContent.prepend(modalHeader)
    const modalTitle = document.createElement('h5')
    modalTitle.classList.add('modal-title')
    modalHeader.prepend(modalTitle)
    modalTitle.innerHTML = config.modalTitle
    const modalButton = document.createElement('button')
    modalButton.classList.add('btn-close')
    modalButton.onclick = () => {
      modal.remove()
      this.closeModal()
    }
    modalHeader.append(modalButton)
    const modalBody = document.createElement('div')
    modalBody.classList.add('modal-body')
    modalContent.append(modalBody)
    //modal.classList.add('modal')
    modal.prepend(modalDialog)
    document.body.appendChild(modal);

    return { modal: modal, modalBody: modalBody }
  }

  openConfirmationModal(config: ModalConfig) {
    const { modal, modalBody } = this.buildModal(config, config.size || 'modal-md')

    this.componentRef = createComponent(DeleteModalComponent, {
      environmentInjector: this.app.injector,
      hostElement: modalBody,
    });

    this.app.attachView(this.componentRef.hostView)

    if (config.template) {
      this.componentRef.instance.template = config.template
    } else {
      modalBody.prepend(config.modalBody)
    }



    //this.componentRef.instance.formData = formData;
    this.componentRef.instance.saveButtonText = 'Save';
    this.componentRef.instance.showFooter = true
    this.componentRef.instance.saveButtonClass = 'btn-primary';
    this.componentRef.instance.closeMeEvent.subscribe(() => {
      this.closeModal()
      modal.remove()
    });
    this.componentRef.instance.confirmEvent.subscribe(() => {
      modal.remove()
      this.confirm()
    });
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
