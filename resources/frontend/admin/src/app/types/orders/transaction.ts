import {Customer} from './customer';

export type Transaction = {
  id: number;
  shipping: number,
  discount: number,
  commission: number;
  customer: Customer
  total: number,
  payment_status: string,
  payment_method: string
  created_at: string
  withdrawn: boolean
  status: string
}
