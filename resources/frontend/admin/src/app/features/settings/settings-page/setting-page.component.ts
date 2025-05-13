import {Component, inject} from '@angular/core';

@Component({
  selector: 'app-setting-page',
  standalone: false,
  templateUrl: './setting-page.component.html',
  styleUrl: './setting-page.component.scss',
})
export class SettingPageComponent {

  page: string = 'settings';

  ngOnInit() {
    //this._store.getData(Number(this._authService.GetUser().payload.id)).subscribe()
  }

  menuItemChanged(page: string) {
   this.page = page
  }

}
