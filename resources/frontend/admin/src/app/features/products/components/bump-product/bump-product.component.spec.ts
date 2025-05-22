import { ComponentFixture, TestBed } from '@angular/core/testing';

import { BumpProductComponent } from './bump-product.component';

describe('BumpProductComponent', () => {
  let component: BumpProductComponent;
  let fixture: ComponentFixture<BumpProductComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [BumpProductComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(BumpProductComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
