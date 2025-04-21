import { Component, OnInit, ChangeDetectionStrategy } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { map, Observable } from 'rxjs';
import { IUser } from '../../auth/user.model';
import { AuthState } from '../../auth/auth.state';

@Component({
  selector: 'app-status',
  template: `
  <div class="box" *ngIf="status$ | async as s;else notloggedin">
    {{ s.email }}
  </div>
  <ng-template #notloggedin>You're not logged in</ng-template>
  `,
  changeDetection: ChangeDetectionStrategy.OnPush,
  standalone: false,
})
export class StatusComponent implements OnInit {
  status$: Observable<IUser>;

  constructor(private authState: AuthState) {
  }

  ngOnInit(): void {
    // we'll clean this up later
    this.status$ = this.authState.stateItem$.pipe(
      map((state) => state?.payload)
    );
  }
}
