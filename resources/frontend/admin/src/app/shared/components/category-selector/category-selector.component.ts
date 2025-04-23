import {Component, Inject, inject, Injector, Input, OnInit} from '@angular/core';
import {Category} from '../../../types/categories/category';
import {CategorySelectorStore} from './store/category-selector.store';
import {
  NG_VALUE_ACCESSOR,
} from '@angular/forms';
import {ControlValueAccessorDirective} from './control-value-accessor.directive';

@Component({
  selector: 'app-category-selector',
  standalone: false,
  templateUrl: './category-selector.component.html',
  styleUrl: './category-selector.component.scss',
  providers: [
    {
      provide: NG_VALUE_ACCESSOR,
      multi:true,
      useExisting: CategorySelectorComponent
    },
    // {
    //   provide: NG_VALIDATORS,
    //   multi: true,
    //   useExisting: CategorySelectorComponent
    // },
  ]
})
export class CategorySelectorComponent<T> extends ControlValueAccessorDirective<T> implements OnInit {
  children:Record<number, Category[]>
  @Input() displayGrandchildren: boolean = true;
  @Input() disableGrandchildren: boolean = false;
  @Input() label: string = 'Category'

  _store = inject(CategorySelectorStore)
  vm$ = this._store.vm$;
  category_id: number;
  @Input() inputId = '';

  ngOnInit() {
    this._store.getCategories();

    this._store.children$.subscribe(result => {
      this.children = result
    });
  }
  hasChildren(categoryId: number) {
    console.log('chilsren', this.children, categoryId)
    return !!(this.children && this.children[categoryId])
  }

  getChildren(categoryId: number) {
    return this.children[categoryId] ? this.children[categoryId] : []
  }
}
