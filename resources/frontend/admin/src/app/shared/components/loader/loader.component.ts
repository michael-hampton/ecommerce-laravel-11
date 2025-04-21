import { Component } from '@angular/core';
import {map, Observable} from 'rxjs';
import {LoaderService} from '../../../services/loader/loader.service';
@Component({
  selector: 'app-loader',
  standalone: false,
  templateUrl: './loader.component.html',
  styleUrl: './loader.component.scss'
})
export class LoaderComponent {
  signal$: Observable<boolean>;
  constructor(private loaderState: LoaderService) {}

  ngOnInit() {
    // assign state
    this.signal$ = this.loaderState.stateItem$.pipe(
      // i just need a sub property
      // filter out nulls as well
      map((state) => state ? state.show : false)
    );
  }
}
