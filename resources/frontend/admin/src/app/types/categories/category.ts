export type Category = {
  id: number;
  name: string;
  slug: string;
  image?: File;
  meta_title: string;
  meta_description: string;
  meta_keywords: string;
  description: string
  parent_id: number;
  products?: number
  subcategories?: Category[]
  attributes?: number[]
  active: boolean
}
