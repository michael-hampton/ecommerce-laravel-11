import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PromoteProductComponent } from './promote-product.component';

describe('PromoteProductComponent', () => {
  let component: PromoteProductComponent;
  let fixture: ComponentFixture<PromoteProductComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [PromoteProductComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(PromoteProductComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
