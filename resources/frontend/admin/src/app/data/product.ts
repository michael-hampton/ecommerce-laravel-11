import {Category} from './category';
import {Brand} from './brand';

export type Product = {
  id?: number
  name: string
  slug: string
  short_description: string
  description: string
  regular_price: number
  sale_price: number
  stock_status: string
  featured: boolean
  quantity: number
  images: string
  image: string
  brand_id: number
  category_id: number
  SKU: string,
  seller_id: number
  category?: Category
  brand?: Brand
  has_stock?: boolean
}
