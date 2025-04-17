import {
  Component,
  EventEmitter,
  Input,
  Output, TemplateRef, ViewChild,
} from '@angular/core';
import {CommonModule, NgTemplateOutlet} from '@angular/common';
import {ModalService} from '../../service/modal.service';


@Component({
  selector: 'app-modal',
  imports: [
    CommonModule
  ],
  templateUrl: './modal.component.html',
  styleUrl: './modal.component.scss'
})
export class ModalComponent {
  @Input() title: string = '';
  @Input() body: string = '';
  @Output() public closeMeEvent = new EventEmitter();
  @Output() public confirmEvent = new EventEmitter();
  @Input() child: TemplateRef<any> | null = null;
  @Input() modalService: ModalService | undefined
  ngOnInit(): void {
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
