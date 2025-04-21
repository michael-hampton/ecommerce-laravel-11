// this is a state for the loader
// lets create the interface as well
import {StateService} from '../state.abstract';
import {Injectable} from '@angular/core';
import {share} from 'rxjs';

export interface ILoaderState {
  show: boolean;
  source?: string;
  current: number;
}

@Injectable({
  providedIn: 'root',
})
export class LoaderService extends StateService<ILoaderState> {
  // or we can instantiate it with a default value like this:
  constructor() {
    super();
    this.SetState({ show: false, current: 0 });

    // this is optional, we can pipe share to our original observable
    this.stateItem$ = this.stateItem$.pipe(
      // testing sharability
      // tap(() => console.log('***SIDE EFFECT***')),
      share()
    );
  }
  show(context?: string) {
    // update current
    const newCurrent = this.currentItem.current + 1;
    this.UpdateState({
      show: true,
      source: context,
      current: newCurrent,
    });
  }
  hide(context?: string) {
    const newCurrent = this.currentItem.current - 1;
    // let component take care of this
    this.UpdateState({
      show: false,
      source: context,
      current: newCurrent,
    });
  }
}
