import {Country} from '../countries/country';

export type Courier = {
  id: number;
  name: string
  active: boolean;
  code: string;
  country_id: number
}
