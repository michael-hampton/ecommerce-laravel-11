import {Component, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from 'datatables.net';
import {Subscription} from 'rxjs';
import {CategoryStore} from "../../../../store/categories/list.store";
import {ModalService} from "../../../../services/modal.service";
import {Category} from "../../../../types/categories/category";
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {FormComponent} from '../form/form.component';

@Component({
  selector: 'app-category-list',
  standalone: false,
  templateUrl: './category-list.component.html',
  styleUrl: './category-list.component.scss'
})
export class CategoryListComponent implements OnInit {
  dtOptions: Config = {};
  @ViewChild('confirmationModal')
  private deleteModalComponent!: ViewContainerRef;
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;

  test = [
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'},
    {test: 'a', test2: 'b', test3: 'c'}
  ]

  constructor(
    private _store: CategoryStore,
    private modalService: ModalService,
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
      lengthMenu: [5, 10, 20, 50],
      pageLength: 10,
      columns: [
        {data: 'id', name: '#'},
        {
          data: 'name', name: 'Name', className: 'd-flex', render: function (data, type, row) {
            return '<div class="d-flex align-items-center justify-content-between me-3">' +
              '<img src="' + row.image + '" alt="' + row.name + '" class="image"></div>' +
              '<div class="">' +
              '<a href="#" class="fw-bold">' + row.name + '</a>' + '</div>';
          }
        },
        {data: 'slug', title: 'Slug'},
        {data: 'products', title: 'Products'},
        {
          data: 'subcategories', title: 'Subcategories', render: function (data, type, row) {
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
      .openConfirmationModal(ModalComponent, this.entry, data, {modalTitle: 'Are you sure?', modalBody: 'click confirm or close'})
      .subscribe((v) => {
        this._store.delete(data.id)
      });
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit Category'})
      .subscribe((v) => {
        this.modalService.closeModal();
      });
  }

  add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create Category'})
      .subscribe((v) => {

      });
  }

  pageChanged(event: Event) {
    alert('here')
  }

  headerClick(event: Event) {
    alert('here')
    console.log('event', event)
  }
}
