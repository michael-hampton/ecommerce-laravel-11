import { Component, Input, TemplateRef } from '@angular/core';
import { Content } from './content';

@Component({
  selector: 'app-ui-tab-item',
  standalone: false,
  templateUrl: './ui-tab-item.component.html',
  styleUrl: './ui-tab-item.component.scss'
})
export class UiTabItemComponent {
  @Input() tabName? = 'default';
  @Input() templateRef!: TemplateRef<any>;
  @Input() content?: Content; 
}
