import {AfterViewInit, Component, ElementRef, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {ModalConfig} from '../../modal/modal.config';
import {ModalComponent} from '../../modal/modal.component';
import {CommonModule} from '@angular/common';

@Component({
  selector: 'app-form',
  imports: [
    CommonModule,
    ModalComponent
  ],
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss'
})
export class FormComponent extends ModalComponent{
  @ViewChild('modal') content!: ElementRef;

  public modalConfig: ModalConfig = {
    modalTitle: 'test',
    closeButtonLabel: 'Close'
  }

  open = () => {
    console.log('content', this.content)
    console.log('service', this.modalService)
    // super.open();
    return Promise.resolve();
  }

  override close() {
    alert('closing')
    super.close();
  }

  save() {
    alert('confirm')
  }
}
