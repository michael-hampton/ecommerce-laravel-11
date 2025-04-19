import {Category} from '../categories/category';
import {Brand} from '../brands/brand';

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
