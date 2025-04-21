import {
  Component,
    OnInit,
    Input,
    OnChanges,
    SimpleChanges,
} from '@angular/core';
import * as _l from 'lodash';
import { CommonService} from '../common.service';

@Component({
  selector: 'input-validator',
  templateUrl: './input-validator.component.html',
  styleUrls: ['./input-validator.component.scss'],
})
export class InputValidatorComponent implements OnChanges {
  @Input() inputs: Array<any>;
  @Input() indicator: boolean;
  @Input() validationStateText: string;

  showValidationMsg: boolean = false;

  validationText: string = '';
  fieldValidationText: string;

  constructor(private commonService: CommonService) {}

  ngOnChanges(changes: SimpleChanges) {
    if (
      _l.get(changes, 'indicator.currentValue', false) &&
      !changes['indicator'].firstChange
    ) {
      if (
        _l.get(this.inputs, 'validationType', '') === 'EMAIL' &&
        _l.get(this.inputs, 'value', '') !== ''
      ) {
        this.setValidationState('EMAIL', true);
      } else if (
        _l.get(this.inputs, 'validationType', '') === 'MOBILE' &&
        _l.get(this.inputs, 'value', '') !== ''
      ) {
        this.setValidationState('MOBILE', true);
      } else if (
        _l.get(this.inputs, 'validationType', '') === 'TELEPHONE' &&
        _l.get(this.inputs, 'value', '') !== ''
      ) {
        this.setValidationState('TELEPHONE', true);
      } else if (
        _l.get(this.inputs, 'validationType', '') === 'ZIPCODE' &&
        _l.get(this.inputs, 'value', '') !== ''
      ) {
        this.setValidationState('ZIPCODE', true);
      } else {
        this.setValidationState('MANDT', true);
      }
    } else if (_l.get(changes, 'indicator.currentValue', false) === false) {
      this.setValidationState('MANDT', false);
    }
  }

  setValidationState(type, showState): void {
    this.showValidationMsg = showState;
    this.validationText = this.commonService.getValidationTextBasedOnType(type);
    this.showValidationMsg = showState;
  }
}
