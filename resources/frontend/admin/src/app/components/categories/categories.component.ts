import {Component, ComponentRef, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from 'datatables.net';
import {CategoryService} from '../../service/category.service';
import {CommonModule} from '@angular/common';
import {DataTablesModule} from 'angular-datatables';
import {Category} from '../../data/category';
import {ConfirmationModalComponent} from '../confirmation-modal/confirmation-modal.component';
import {ModalComponent} from '../modal/modal.component';
import {ModalService} from '../../service/modal.service';
import {Subscription} from 'rxjs';
import {FormComponent} from './form/form.component';

@Component({
  selector: 'app-categories',
  imports: [CommonModule, DataTablesModule, ConfirmationModalComponent],
  templateUrl: './categories.component.html',
  styleUrl: './categories.component.scss'
})
export class CategoriesComponent implements OnInit{
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
    private categoryService: CategoryService,
    private modalService: ModalService,
    private renderer: Renderer2
  ){}

  ngOnInit(): void {
    this.dtOptions = {
      ajax: (dataTablesParameters: any, callback) => {
        this.categoryService.getData().subscribe(resp => {
          callback({
            data: resp
          });
        });
      },
      lengthMenu : [5,10,20,50],
      pageLength: 10,
      columns: [
        {data: 'id', name: '#'},
        {
          data: 'name', name: 'Name', className: 'd-flex', render: function (data, type, row) {
            return '<div class="d-flex align-items-center justify-content-between me-3">' +
              '<img src="'+row.image+'" alt="'+row.name+'" class="image"></div>' +
            '<div class="">' +
            '<a href="#" class="fw-bold">'+row.name+'</a>'+'</div>';
          }
        },
        {data: 'slug', title: 'Slug'},
        {data: 'products', title: 'Products' },
        {data: 'subcategories', title: 'Subcategories', render: function (data, type, row) {
            var html = ''
            row.subcategories?.forEach((item: Category) => {
              html += '<div class="d-flex align-items-center justify-content-between">' +
                item.name +
                '<a data-url="#" data-id=' + item.id + ' href="#" target="_blank" class="edit">' +
              '<i class="icon-eye"></i>' +
              '</a>' +
              '<a data-url="#" data-id=' + item.id + ' href="#" target="_blank" class="delete">' +
              '<i class="fa fa-trash"></i>' +
              '</a>' +
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
