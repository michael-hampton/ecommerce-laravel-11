import {OrderLog} from './orderLog';
import {Category} from '../categories/category';
import {Brand} from '../brands/brand';

export type OrderItem = {
  id: number,
  price: string,
  quantity: number,
  tracking_number: string,
  courier_name: string,
  created_at: string,
  orderLogs: OrderLog[],
  product: Product
  status: string
}

export type Product = {
  name: string,
  category: Category,
  brand: Brand,
  SKU: string,
  image: string,
}
