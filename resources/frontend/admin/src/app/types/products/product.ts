import {Category} from '../categories/category';
import {Brand} from '../brands/brand';

export type Product = {
  id?: number
  name: string
  slug: string
  short_description: string
  description: string
  regular_price: number
  sale_price: number
  stock_status: string
  featured: number
  quantity: number
  images: any
  image?: any
  brand_id: number
  category_id: number
  SKU: string,
  seller_id: number
  category?: Category
  brand?: Brand
  has_stock?: boolean
}
