import { Component, ContentChildren, QueryList } from '@angular/core';
import { UiTabItemComponent } from '../ui-tab-item/ui-tab-item.component';

@Component({
  selector: 'app-ui-side-menu',
  standalone: false,
  templateUrl: './ui-side-menu.component.html',
  styleUrl: './ui-side-menu.component.scss'
})
export class UiSideMenuComponent {
  @ContentChildren(UiTabItemComponent) tabs!: QueryList<UiTabItemComponent>;
  activeComponent!: UiTabItemComponent;

  ngAfterContentInit() {
    this.activeComponent = this.tabs.first;
  }

  activateTab(tab: UiTabItemComponent) {
    this.activeComponent = tab;
  }
}
