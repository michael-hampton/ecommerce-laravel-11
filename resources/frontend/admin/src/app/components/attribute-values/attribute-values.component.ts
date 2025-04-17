import {Component, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from 'datatables.net';
import {AttributeValuesService} from '../../service/attribute-values.service';
import {CommonModule} from '@angular/common';
import {DataTablesModule} from 'angular-datatables';
import {ConfirmationModalComponent} from '../confirmation-modal/confirmation-modal.component';
import {Subscription} from 'rxjs';
import {ModalService} from '../../service/modal.service';
import {FormComponent} from './form/form.component';

@Component({
  selector: 'app-attribute-values',
  imports: [CommonModule, DataTablesModule, ConfirmationModalComponent],
  templateUrl: './attribute-values.component.html',
  styleUrl: './attribute-values.component.scss'
})
export class AttributeValuesComponent implements OnInit{
  dtOptions: Config = {};

  modalStyle: string = 'modal-style-primary';
  @ViewChild('confirmationModal')
  private deleteModalComponent!: ConfirmationModalComponent;
  modalTitle: string = 'Are you sure you want to delete';
  modalBody: string = 'Are you sure you want to delete';
  modalButtonColor: string = 'btn-primary';
  @ViewChild('modal', { read: ViewContainerRef })
  entry!: ViewContainerRef;
  sub!: Subscription;

  constructor(
    private modalService: ModalService,
    private attributeValueService: AttributeValuesService,
    private renderer: Renderer2
  ){}

  ngOnInit(): void {
    this.dtOptions = {
      ajax: (dataTablesParameters: any, callback) => {
        this.attributeValueService.getData().subscribe(resp => {
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
        {data: 'attribute', title: 'Attribute', render: function (data, type, row) {
            return row.attribute.name
          }},
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
            this.delete(data.id)
            console.log('Row data:', data); // Log the data for the clicked row
          });
        }
        if (editButton) {
          this.renderer.listen(editButton, 'click', (event) => {
            event.preventDefault();
            alert('edit clicked')
            console.log('Row data:', data); // Log the data for the clicked row
          });
        }
        return row;
      }
    };
  }

  delete = async (id: number) => {
    return await this.deleteModalComponent.open();
  }

  getConfirmationValue(event: boolean) {
    if(event === true) {
      alert('yes')
    }
  }

  add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, 'Are you sure ?', 'click confirm or close')
      .subscribe((v) => {
        alert('here00')
        //your logic
      });
  }
}
