import {ChangeDetectionStrategy, Component} from '@angular/core';
import {Toast} from '../../../services/toast/toast.service';
import {AsyncPipe} from '@angular/common';

@Component({
  selector: 'gr-toast',
  standalone: false,
  // in template watch the toast observable for null values to hide all
  templateUrl: 'toast.component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
  styleUrls: ['./toast.component.scss'],
})
export class ToastComponent {
  // inject the state
  constructor(public toastState: Toast) {}
}
