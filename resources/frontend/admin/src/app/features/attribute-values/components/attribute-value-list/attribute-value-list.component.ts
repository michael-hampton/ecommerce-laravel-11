import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from 'datatables.net';
import { Subscription } from 'rxjs';
import {AttributeValueStore} from '../../../../store/attribute-values/list.store';
import {ModalService} from '../../../../services/modal.service';
import { FormComponent } from '../form/form.component';
import {ModalComponent} from '../../../../shared/components/modal/modal.component';

@Component({
  selector: 'app-attribute-value-list',
  standalone: false,
  templateUrl: './attribute-value-list.component.html',
  styleUrl: './attribute-value-list.component.scss'
})
export class AttributeValueListComponent implements OnInit {
  dtOptions: Config = {};

  @ViewChild('confirmationModal', {read: ViewContainerRef})
  deleteModalComponent!: ViewContainerRef;
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;

  private _store = inject(AttributeValueStore);

  vm$ = this._store.vm$;

  constructor(
    private modalService: ModalService,
    private renderer: Renderer2,
  ) {
  }

  ngOnInit(): void {
    this.dtOptions = {
      ajax: (dataTablesParameters: any, callback) => {
        this._store.loadData().subscribe(resp => {
          callback({
            data: resp
          });
        });
      },
      processing: true,
      language: {
        processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
      },
      search: false,
      serverSide: true,
      pageLength: 10,
      columns: [
        {data: 'id', title: '#'},
        {
          data: 'attribute', title: 'Attribute', render: function (data, type, row) {
            return row.attribute.name
          }
        },
        {data: 'name', title: 'Name'},
        {
          orderable: false,
          searchable: false,
          render: (data: any, type: any, row: any) => {
            return '<div class="d-flex align-items-center justify-content-between">' +
              '<a data-url="" data-id=' + row.id + ' href="#" target="_blank" class="edit">' +
              '<i class="fa fa-eye"></i>' +
              '</a>' +
              '<a href="#" class="delete">' +
              '<i class="fa fa-trash"></i>' +
              '</a>' +
              '</div>';
          }
        }
      ],
      rowCallback: (row: Node, data: any, index: number) => {
        // Cast row to HTMLElement to access querySelector
        const rowElement = row as HTMLElement;

        // Ensure the last cell (Actions column) is styled
        const actionCell = rowElement.querySelector('td:last-child');
        if (actionCell) {
          actionCell.setAttribute(
            'style',
            'display: flex; justify-content: center; '
          );
        }

        // Find the button in the row and attach a click listener using Renderer2
        const deleteButton = rowElement.querySelector('.delete');
        const editButton = rowElement.querySelector('.edit');
        if (deleteButton) {
          this.renderer.listen(deleteButton, 'click', (event) => {
            event.preventDefault();
            this.delete(data)
            console.log('Row data:', data); // Log the data for the clicked row
          });
        }
        if (editButton) {
          this.renderer.listen(editButton, 'click', (event) => {
            event.preventDefault();
            this.edit(data)
            console.log('Row data:', data); // Log the data for the clicked row
          });
        }
        return row;
      }
    };
  }

  delete = async (data: any) => {
    this.sub = this.modalService
      .openConfirmationModal(ModalComponent, this.deleteModalComponent, data, {
        modalTitle: 'Are you sure?',
        modalBody: 'click confirm or close'
      })
      .subscribe((v) => {
        this._store.delete(data.id)
      });
  }

  add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create Attribute Value'})
      .subscribe((v) => {
      });
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit Attribute Value'})
      .subscribe((v) => {
      });
  }
}
