import {Brand} from './brand';
import {Category} from './category';

export type Coupon = {
  id: number
  code: string,
  type: string,
  value: number,
  cart_value: number,
  expires_at: string,
  seller_id: number,
  usages: number
  brands?: Brand[],
  categories?: Category[]
}
