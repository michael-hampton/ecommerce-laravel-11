import { Component } from '@angular/core';

@Component({
  selector: 'app-topbar',
  standalone: false,
  templateUrl: './topbar.component.html',
  styleUrl: './topbar.component.scss'
})
export class TopbarComponent {
  public notifications = [{message: 'Message here', created_at: 'created at', id: 1}]
}
