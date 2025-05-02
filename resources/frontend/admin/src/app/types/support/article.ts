export type Article = {
    id: number;
    title: string
    slug: string
    short_text: string
    full_text: string
    category_id: number;
    tags: number[]
}