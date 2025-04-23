import { Component } from '@angular/core';
import {RouterLink} from '@angular/router';
import {AuthService} from '../../auth/auth.service';
import {RoleEnum} from '../../../types/users/role.enum';

@Component({
  selector: 'app-sidemenu',
  standalone: false,
  templateUrl: './sidemenu.component.html',
  styleUrl: './sidemenu.component.scss'
})
export class SidemenuComponent {

  constructor(private _auth: AuthService) {
  }

  logout() {
    this._auth.Logout();
  }

  protected readonly RoleEnum = RoleEnum;
}
