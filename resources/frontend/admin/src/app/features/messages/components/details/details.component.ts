import {Component, inject, OnInit} from '@angular/core';
import {ActivatedRoute} from '@angular/router';
import {MessageStore} from '../../../../store/messages/list.store';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import { firstValueFrom } from 'rxjs';

@Component({
  selector: 'app-details',
  standalone: false,
  templateUrl: './details.component.html',
  styleUrl: './details.component.scss',
  providers: [MessageStore]
})
export class DetailsComponent implements OnInit {

  private activatedRoute = inject(ActivatedRoute)
  private messageId: any;
  _store = inject(MessageStore)
  vm$ = this._store.vm$
  private fb = inject(FormBuilder)
  myForm: FormGroup;
  ngOnInit(): void {
    this.activatedRoute.params.subscribe(params => {
      this.messageId = params['id'];
      this._store.getMessageDetails(this.messageId).subscribe()
    })

    this.initializeForm()
  }

  initializeForm() {
    this.myForm = this.fb.group({
      message: ['', Validators.required],
    });
  }

  async onSubmit() {
    if (this.myForm.valid) {
      const files = await firstValueFrom(this._store.files$)
      this._store.createReply({
        postId: this.messageId,
        message: this.myForm.value.message,
        images: files
      }).subscribe(result => {
        this.myForm.reset();
        this._store.getMessageDetails(this.messageId).subscribe()
      })
    }
  }
}
