import {Attribute} from '../attributes/attribute';

export type AttributeValue = {
  id: number;
  name: string;
  attribute_id: number;
  attribute: Attribute
}
