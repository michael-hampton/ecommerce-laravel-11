import {Component, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from 'datatables.net';
import {AttributeService} from '../../service/attribute.service';
import {CommonModule} from '@angular/common';
import {DataTablesModule} from 'angular-datatables';
import {AttributeValue} from '../../data/attribute-value';
import {Subscription} from 'rxjs';
import {ModalService} from '../../service/modal.service';
import {FormComponent} from './components/form/form.component';
import {ModalComponent} from '../../shared/modal/modal.component';
import {AttributeStore} from './store/list.store';

@Component({
  selector: 'app-attributes',
  imports: [CommonModule, DataTablesModule],
  templateUrl: './attributes.component.html',
  styleUrl: './attributes.component.scss',
  providers: [AttributeStore]
})
export class AttributesComponent implements OnInit {
  dtOptions: Config = {};
  @ViewChild('confirmationModal')
  private deleteModalComponent!: ViewContainerRef;
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;

  constructor(
    private modalService: ModalService,
    private _store: AttributeStore,
    private renderer: Renderer2
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
      search: false,
      serverSide: true,
      pageLength: 10,
      columns: [
        {data: 'id', title: '#'},
        {data: 'name', title: 'Name'},
        {
          data: 'attribute_values', title: 'Values', render: function (data, type, row) {
            var html = ''
            row.attribute_values.forEach((item: AttributeValue) => {
              html += '<div class="d-flex align-items-center justify-content-between">' +
                item.name +
                '</div>';
            });

            return html;


          }
        },
        {
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            return '<div class="d-flex align-items-center justify-content-between">' +
              '<a href="#" class="edit">' +
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
          // actionCell.setAttribute(
          //   'style',
          //   'display: flex; justify-content: center; '
          // );
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
      .openConfirmationModal(ModalComponent, this.entry, data, {
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
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create Attribute'})
      .subscribe((v) => {
        alert('here00')
        //your logic
      });
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit Attribute'})
      .subscribe((v) => {
        alert('here00')
        //your logic
      });
  }
}
