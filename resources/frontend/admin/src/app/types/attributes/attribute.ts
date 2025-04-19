import {AttributeValue} from '../attribute-values/attribute-value';

export type Attribute = {
  id: number;
  name: string;
  attribute_values?: AttributeValue[]
}
