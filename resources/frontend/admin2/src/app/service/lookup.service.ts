import {Injectable} from '@angular/core';
import {of} from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class LookupService {

  getBrands() {
  const brands = [
      {
        id: 1, name: 'Brand 1', slug: 'brand-1', image: 'test',
        products: 4
      },
      {
        id: 2, name: 'Brand 1', slug: 'brand-2', image: 'test',
        products: 5
      },
      {
        id: 3, name: 'Brand 1', slug: 'brand-3', image: 'test',
        products: 6
      },
      {
        id: 4, name: 'Brand 1', slug: 'brand-4', image: 'test',
        products: 7
      },
      {
        id: 5, name: 'Brand 1', slug: 'brand-5', image: 'test',
        products: 8
      },
    ]

    return of({data: brands})
  }

  getCategories() {
    const categories = [
      {
        id: 1, name: 'Category 1', slug: 'category-1',
        image: '',
        parent_id: 0,
        products: 5
      },
      {
        id: 2, name: 'Category 1', slug: 'category-2',
        image: '',
        parent_id: 0,
        products: 5
      },
      {
        id: 3, name: 'Category 1', slug: 'category-3',
        image: '',
        parent_id: 0,
        products: 5
      },
      {
        id: 4, name: 'Category 1', slug: 'category-4',
        image: '',
        parent_id: 0,
        products: 5
      },
      {
        id: 5,
        name: 'Category 1',
        slug: 'category-5',
        image: '',
        parent_id: 0,
        products: 6,
        subcategories: [{
          id: 1,
          name: 'subcategory 1',
          slug: '',
          image: '',
          parent_id: 0,
          products: 5
        }, {
          id: 2,
          name: 'subcategory 2',
          slug: '',
          image: '',
          parent_id: 0,
          products: 5
        }, {
          id: 3,
          name: 'subcategory 3',
          slug: '',
          image: '',
          parent_id: 0,
          products: 5
        }]
      },
    ]

    return of({data: categories})
  }

  getAttributes() {
  const attributes = [
      {
        id: 1, name: 'Color', attribute_values: [{
          id: 3,
          name: 'test 4',
          attribute_id: 0,
          attribute: {
            id: 0,
            name: '',
            attribute_values: undefined
          }
        }, {
          id: 1,
          name: 'test 1',
          attribute_id: 0,
          attribute: {
            id: 0,
            name: '',
            attribute_values: undefined
          }
        }, {
          id: 1,
          name: 'test 2',
          attribute_id: 0,
          attribute: {
            id: 0,
            name: '',
            attribute_values: undefined
          }
        }]
      },
      {
        id: 2, name: 'Size', attribute_values: [{
          id: 10,
          name: 'test 10',
          attribute_id: 0,
          attribute: {
            id: 0,
            name: '',
            attribute_values: undefined
          }
        }, {
          id: 9,
          name: 'test 9',
          attribute_id: 0,
          attribute: {
            id: 0,
            name: '',
            attribute_values: undefined
          }
        }, {
          id: 8,
          name: 'test 8',
          attribute_id: 0,
          attribute: {
            id: 0,
            name: '',
            attribute_values: undefined
          }
        }]
      },
      {
        id: 3, name: 'Package Size', attribute_values: [{
          id: 5,
          name: 'test 6',
          attribute_id: 0,
          attribute: {
            id: 0,
            name: '',
            attribute_values: undefined
          }
        }, {
          id: 1,
          name: 'test 1',
          attribute_id: 0,
          attribute: {
            id: 0,
            name: '',
            attribute_values: undefined
          }
        }, {
          id: 2,
          name: 'test 2',
          attribute_id: 0,
          attribute: {
            id: 0,
            name: '',
            attribute_values: undefined
          }
        }]
      },
      {
        id: 4, name: 'Condition', attribute_values: [{
          id: 3,
          name: 'test 3',
          attribute_id: 0,
          attribute: {
            id: 0,
            name: '',
            attribute_values: undefined
          }
        }, {
          id: 4,
          name: 'test 4',
          attribute_id: 0,
          attribute: {
            id: 0,
            name: '',
            attribute_values: undefined
          }
        }, {
          id: 5,
          name: 'test 5',
          attribute_id: 0,
          attribute: {
            id: 0,
            name: '',
            attribute_values: undefined
          }
        }]
      }
    ]

    return of({data: attributes})
  }

  getSubcategories(category_id: number) {
  const categories = [
      {
        id: 1, name: 'Category 1', slug: 'category-1',
        image: '',
        parent_id: 0,
        products: 5
      },
      {
        id: 2, name: 'Category 1', slug: 'category-2',
        image: '',
        parent_id: 0,
        products: 5
      },
      {
        id: 3, name: 'Category 1', slug: 'category-3',
        image: '',
        parent_id: 0,
        products: 5
      },
      {
        id: 4, name: 'Category 1', slug: 'category-4',
        image: '',
        parent_id: 0,
        products: 5
      },
      {
        id: 5,
        name: 'Category 1',
        slug: 'category-5',
        image: '',
        parent_id: 0,
        products: 6,
        subcategories: [{
          id: 1,
          name: 'subcategory 1',
          slug: '',
          image: '',
          parent_id: 0,
          products: 5
        }, {
          id: 2,
          name: 'subcategory 2',
          slug: '',
          image: '',
          parent_id: 0,
          products: 5
        }, {
          id: 3,
          name: 'subcategory 3',
          slug: '',
          image: '',
          parent_id: 0,
          products: 5
        }]
      },
    ]

    return of({data: categories})
  }
}
