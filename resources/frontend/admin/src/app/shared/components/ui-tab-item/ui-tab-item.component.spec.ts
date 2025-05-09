import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UiTabItemComponent } from './ui-tab-item.component';

describe('UiTabItemComponent', () => {
  let component: UiTabItemComponent;
  let fixture: ComponentFixture<UiTabItemComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [UiTabItemComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(UiTabItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
