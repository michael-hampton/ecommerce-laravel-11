import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import {TopbarComponent} from './shared/topbar/topbar.component';
import {SidemenuComponent} from './shared/sidemenu/sidemenu.component';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, SidemenuComponent, TopbarComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss'
})
export class AppComponent {
  title = 'admin';
}
