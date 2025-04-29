import {
  Component,
  ElementRef,
  EventEmitter,
  inject,
  Input,
  Output, TemplateRef, ViewChild,
} from '@angular/core';
import {CommonModule, NgIf, NgTemplateOutlet} from '@angular/common';
import {ModalService} from '../../../services/modal.service';


@Component({
  selector: 'app-modal',
  templateUrl: './modal.component.html',
  imports: [
    NgTemplateOutlet,
    NgIf
  ],
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
  @Input() modalService: ModalService | undefined
  @Input() showFooter: boolean = false;
  @Input() contentRef: ElementRef;
  @Input() template: TemplateRef<any>;


  private el = inject(ElementRef)


  ngAfterViewInit() {
    const hostElem = this.el.nativeElement;
    console.log(hostElem.children);
    console.log(hostElem.parentNode);
  }


  ngOnInit(): void {
    console.log('child', this.child)
    console.log('Modal init', this.template);
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
