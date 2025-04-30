export type Brand = {
  id: number;
  name: string;
  slug: string;
  image?: File;
  products: number
  meta_title: string;
  meta_description: string;
  meta_keywords: string;
  description: string
  active: boolean
}
