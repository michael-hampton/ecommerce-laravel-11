import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import {SidemenuComponent} from './components/sidemenu/sidemenu.component';
import {TopbarComponent} from './components/topbar/topbar.component';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, SidemenuComponent, TopbarComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.scss'
})
export class AppComponent {
  title = 'admin';
}
