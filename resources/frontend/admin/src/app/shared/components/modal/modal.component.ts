import {
  Component,
  EventEmitter,
  Input,
  Output, TemplateRef, ViewChild,
} from '@angular/core';
import {CommonModule, NgTemplateOutlet} from '@angular/common';
import {FormSubmitDirective} from '../../directives/form-submit.directive';
import {ModalService} from '../../../services/modal.service';


@Component({
  selector: 'app-modal',
  templateUrl: './modal.component.html',
  imports: [
    NgTemplateOutlet
  ],
  styleUrl: './modal.component.scss'
})
export class ModalComponent {
  @Input() title: string = '';
  @Input() body: string = '';
  @Output() public closeMeEvent = new EventEmitter();
  @Output() public confirmEvent = new EventEmitter();
  @Input() child: TemplateRef<any> | null = null;
  @Input() saveButtonDisabled: boolean = false;
  @Input() saveButtonText: string = 'Save';
  @Input() saveButtonClass: string = 'btn-primary'
  @Input() formData: any;
  @Input() modalService: ModalService | undefined
  ngOnInit(): void {
    console.log('child', this.child)
    console.log('Modal init');
  }

  closeMe() {
    this.closeMeEvent.emit();
  }
  confirm() {
    this.confirmEvent.emit();
  }

  close() {
    this.modalService?.closeModal()
  }

  ngOnDestroy(): void {
    console.log(' Modal destroyed');
  }
}
