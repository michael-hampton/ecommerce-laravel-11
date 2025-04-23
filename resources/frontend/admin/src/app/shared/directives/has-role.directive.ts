import {Directive, inject, Input, OnInit, TemplateRef, ViewContainerRef} from '@angular/core';
import {RoleEnum} from '../../types/users/role.enum';
import {BehaviorSubject, mergeMap, Observable, of, takeUntil} from 'rxjs';
import {AuthStore} from '../../store/auth.store';
import {injectDestroyService, provideDestroyService} from '../../core/services/destroy-service.service';

@Directive({
  selector: '[hasRole], [hasRoleIsAdmin]',
  standalone: true,
  providers: [provideDestroyService()],
})
export class HasRoleDirective implements OnInit {
  private destroy$ = injectDestroyService();

  private templateRef = inject(TemplateRef<unknown>);
  private viewContainer = inject(ViewContainerRef);
  private store = inject(AuthStore);

  private show = new BehaviorSubject<Observable<boolean | undefined>>(
    of(undefined)
  );

  @Input('hasRole') set role(role: RoleEnum | RoleEnum[] | undefined) {
    if (role) {
      this.show.next(this.store.hasAnyRole(role));
    }
  }

  @Input('hasRoleIsAdmin') set isAdmin(isAdmin: boolean) {
    if (isAdmin) {
      this.show.next(this.store.isAdmin$);
    }
  }

  ngOnInit(): void {
    this.show
      .pipe(
        mergeMap((s) => s),
        takeUntil(this.destroy$)
      )
      .subscribe((showTemplate) =>
        showTemplate ? this.addTemplate() : this.clearTemplate()
      );
  }

  private addTemplate() {
    this.viewContainer.clear();
    this.viewContainer.createEmbeddedView(this.templateRef);
  }

  private clearTemplate() {
    this.viewContainer.clear();
  }
}
