import { Component, ContentChild, Input, TemplateRef } from '@angular/core';
import { AccordionContent } from './content';

@Component({
  selector: 'app-accordion-item',
  standalone: false,
  templateUrl: './accordion-item.component.html',
  styleUrl: './accordion-item.component.scss'
})
export class AccordionItemComponent {
  @Input() title = "";
  @Input() disabled = false;
  @Input() expanded = false;
  @ContentChild('content') content: any;
}
