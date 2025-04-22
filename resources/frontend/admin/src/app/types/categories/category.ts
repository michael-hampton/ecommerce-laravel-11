export type Category = {
  id: number;
  name: string;
  slug: string;
  image: string;
  meta_title: string;
  meta_description: string;
  meta_keywords: string;
  parent_id: number;
  products?: number
  subcategories?: Category[]
}
