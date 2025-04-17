import {Component, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from 'datatables.net';
import {AttributeService} from '../../service/attribute.service';
import {CommonModule} from '@angular/common';
import {DataTablesModule} from 'angular-datatables';
import {AttributeValue} from '../../data/attribute-value';
import {ConfirmationModalComponent} from '../confirmation-modal/confirmation-modal.component';
import {Subscription} from 'rxjs';
import {ModalService} from '../../service/modal.service';
import {FormComponent} from './form/form.component';

@Component({
  selector: 'app-attributes',
  imports: [CommonModule, DataTablesModule, ConfirmationModalComponent],
  templateUrl: './attributes.component.html',
  styleUrl: './attributes.component.scss'
})
export class AttributesComponent implements OnInit{
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
    private attributeService: AttributeService,
    private renderer: Renderer2
  ){}

  ngOnInit(): void {
    this.dtOptions = {
      ajax: (dataTablesParameters: any, callback) => {
        this.attributeService.getData().subscribe(resp => {
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
        {data: 'attribute_values', title: 'Values', render: function (data, type, row) {
            var html = ''
            row.attribute_values.forEach((item: AttributeValue) => {
              html += '<div class="d-flex align-items-center justify-content-between">' +
                item.name +
              '</div>';
            });

            return html;


          }},
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
            this.delete(data.id)
            console.log('Row data:', data); // Log the data for the clicked row
          });
        }
        if (editButton) {
          this.renderer.listen(editButton, 'click', (event) => {
            event.preventDefault();
            this.edit(data.id)

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

  edit(id: number) {
    alert('edit clicked')
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
