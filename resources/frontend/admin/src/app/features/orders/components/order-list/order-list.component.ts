import {Component, OnInit, Renderer2} from '@angular/core';
import {Config} from 'datatables.net';
import {OrderStore} from '../../../../store/orders/list.store';

@Component({
  selector: 'app-order-list',
  standalone: false,
  templateUrl: './order-list.component.html',
  styleUrl: './order-list.component.scss'
})
export class OrderListComponent implements OnInit{
  dtOptions: Config = {};

  constructor(
    private _store: OrderStore,
    private renderer: Renderer2
  ){}

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
      serverSide: true,
      search: false,
      lengthMenu : [5,10,20,50],
      pageLength: 10,
      columns: [
        {data: 'id', name: 'id'},
        {
          data: 'customer', title: 'Customer', className: 'd-flex', render: function (data, type, row) {
            return '<div class="d-flex align-items-center justify-content-between me-3"> ' +
              '<img src="'+row.customer.image + '" alt="' + row.customer.name + '" class="image"></div> ' +
              '<div class="><a href="#" class="fw-bold">' + row.customer.name + '</a></div>';
          }
        },
        {data: 'customer', title: 'Mobile', render: function (data, type, row) {
            return row.customer.mobile
          }},
        {data: 'subtotal', title: 'Subtotal'},
        {data: 'shipping', title: 'Shipping'},
        {data: 'commission', title: 'Commission'},
        {data: 'tax', title: 'Tax'},
        {data: 'total', title: 'Total'},
        {data: 'status', title: 'Status'},
        {data: 'order_date', title: 'Order Date'},
        {data: 'number_of_items', title: 'Number of items'},
        {data: 'delivered_date', title: 'Delivered date'},
        {data: 'cancelled_date', title: 'Cancelled date'},
        {
          orderable: false,
          searchable: false,
          render: function (data, type, row) {
            var route = "{{route('admin.orderDetails', ['orderId' => 'test'])}}"
            return '<a href="'+route.replace('test', row.id)+'">'+
              '<div class="d-flex align-items-center justify-content-between">' +
              '<div class="item eye">' +
              '<i class="fa fa-eye"></i>' +
              '</div>' +
              '</div>' +
              '</a>';
          }
        }
      ]
    };
  }
}
