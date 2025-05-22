import {
  Component,
  ElementRef,
  EventEmitter,
  inject,
  Input,
  Output, TemplateRef, ViewChild,
} from '@angular/core';
import { CommonModule, NgIf, NgTemplateOutlet } from '@angular/common';


@Component({
  selector: 'app-modal',
  templateUrl: './modal.component.html',
  styleUrl: './modal.component.scss'
})
export class ModalComponent {
  @Input() title: string = '';
  @Input() body: string = '';
  @Input() size: string = 'modal-xl';
  @Output() public closeMeEvent = new EventEmitter();
  @Output() public confirmEvent = new EventEmitter();
  @Input() child: TemplateRef<any> | null = null;
  @Input() saveButtonDisabled: boolean = false;
  @Input() saveButtonText: string = 'Save';
  @Input() saveButtonClass: string = 'btn-primary'
  @Input() formData: any;
  @Input() showFooter: boolean = false;
  @Input() template: TemplateRef<any>;
  @Input() callback?: (data: any) => void;
  //_modalService = inject(ModalService)


  closeMe() {
    this.closeMeEvent.emit();
  }
  async confirm() {
    this.confirmEvent.emit();
  }

  close() {
    //this._modalService?.closeModal()
  }

  ngOnDestroy(): void {
    console.log(' Modal destroyed');
  }
}
