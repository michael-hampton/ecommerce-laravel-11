import { Component, ContentChildren, QueryList } from '@angular/core';
import { UiTabItemComponent } from '../ui-tab-item/ui-tab-item.component';

@Component({
  selector: 'app-ui-tabs',
  standalone: false,
  templateUrl: './ui-tabs.component.html',
  styleUrl: './ui-tabs.component.scss'
})
export class UiTabsComponent {
  @ContentChildren(UiTabItemComponent) tabs!: QueryList<UiTabItemComponent>;
  activeComponent!: UiTabItemComponent;

  ngAfterContentInit() {
    this.activeComponent = this.tabs.first;
  }

  activateTab(tab: UiTabItemComponent) {
    this.activeComponent = tab;
  }
}
