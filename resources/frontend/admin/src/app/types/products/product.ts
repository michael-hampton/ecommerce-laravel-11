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
  package_size: string
  images?: any
  image?: any
  brand_id: number
  category_id: number
  SKU: string,
  seller_id: number
  category?: Category
  brand?: Brand
  has_stock?: boolean,
  attributes?: SelectedAttributes[],
  product_attributes?: ProductAttribute[]
}

export type SelectedAttributes = {
  attribute_id: number,
  attribute_value_id: number,
  selected: boolean
}

export type ProductAttribute = {
  id: number
  product_attribute_id: number
  attribute_value_id: number
}
