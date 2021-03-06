@extends('layouts.master')

@section('title')
    Danh sách đơn hàng
@endsection

@section('content')
    <div class="page-header">
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('orders.index')}}"><i class="icon-home2 position-left"></i> Quản lý khách hàng</a>
                </li>
                <li class="active">Chi tiết khách hàng</li>
                <li class="active">Danh sách đơn hàng</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div style="margin-left: 25px;margin-right: 25px;margin-bottom: 50px"
                 class="panel panel-flat">
                @if(count($orders) > 0)
                    <div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Tên khách hàng</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Ghi chú</th>
                                <th>Thành tiền</th>
                                <th>Thời gian đặt hàng</th>
                                <th style="text-align: center">Trạng thái</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td style="font-weight: bold">{{$order->code}}</td>
                                    @if($order->customers)
                                        <td>{{$order->customers->name}}</td>
                                    @else
                                        <td>Đang cập nhật</td>
                                    @endif
                                    @if($order->customers)
                                        <td>{{$order->customers->phone}}</td>
                                    @else
                                        <td>Đang cập nhật</td>
                                    @endif
                                    @if($order->customers)
                                        <td style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;max-width: 150px;">{{$order->customers->address}}</td>
                                    @else
                                        <td>Đang cập nhật</td>
                                    @endif
                                    <td>{{$order->note}}</td>
                                    <td>{{number_format($order->total) }} VND</td>
                                    <td>{{$order->created_at->format('d-m-Y')}}</td>
                                    @if($order->product_id)
                                        {{--                                        Chuyển trạng thái đơn hàng--}}
                                        @if($order->status == 0)
                                            <td style="text-align: center">
                                                <a style="width: 125px; margin-bottom: 10px"
                                                   href="{{route('orders.accept', $order->_id)}}"
                                                   type="submit"
                                                   class="btn btn-success">
                                                    <i class="fa fa-btn fa-edit"></i> Duyệt đơn
                                                </a>
                                                <a style="width: 125px"
                                                   href="{{route('orders.cancel', $order->_id)}}"
                                                   type="submit"
                                                   class="btn btn-danger">
                                                    <i class="fa fa-btn fa-trash"></i> Huỷ đơn
                                                </a>
                                            </td>
                                        @endif
                                        @if($order->status == 1)
                                            <td style="text-align: center">
                                                <a style="width: 125px; color: white"
                                                   href="{{route('orders.return', $order->_id)}}" type="submit"
                                                   class="btn btn-warning">
                                                    <svg style="display: inline" xmlns="http://www.w3.org/2000/svg"
                                                         width="21" height="21" fill="currentColor"
                                                         class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd"
                                                              d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                                                        <path
                                                            d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                                                    </svg>
                                                    Hoàn đơn
                                                </a>
                                            </td>
                                        @endif
                                        @if($order->status == 2)
                                            <td style="text-align: center">
                                                <a style="width: 125px; color: white; cursor: not-allowed" href="#"
                                                   type="submit"
                                                   class="btn btn-info">
                                                    <svg style="display: inline" xmlns="http://www.w3.org/2000/svg"
                                                         width="21" height="21" fill="currentColor"
                                                         class="bi bi-box-seam"
                                                         viewBox="0 0 16 16">
                                                        <path
                                                            d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
                                                    </svg>
                                                    </i> Đã hoàn
                                                </a>
                                            </td>
                                        @endif
                                        @if($order->status == 3)
                                            <td style="text-align: center">
                                                <a style="width: 125px; color: white; cursor: not-allowed; background: #666666"
                                                   href="#"
                                                   class="btn btn-secondary">
                                                    <svg style="display: inline" xmlns="http://www.w3.org/2000/svg"
                                                         width="21" height="21" fill="currentColor"
                                                         class="bi bi-backspace-reverse" viewBox="0 0 16 16">
                                                        <path
                                                            d="M9.854 5.146a.5.5 0 0 1 0 .708L7.707 8l2.147 2.146a.5.5 0 0 1-.708.708L7 8.707l-2.146 2.147a.5.5 0 0 1-.708-.708L6.293 8 4.146 5.854a.5.5 0 1 1 .708-.708L7 7.293l2.146-2.147a.5.5 0 0 1 .708 0z"/>
                                                        <path
                                                            d="M2 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7.08a2 2 0 0 0 1.519-.698l4.843-5.651a1 1 0 0 0 0-1.302L10.6 1.7A2 2 0 0 0 9.08 1H2zm7.08 1a1 1 0 0 1 .76.35L14.682 8l-4.844 5.65a1 1 0 0 1-.759.35H2a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h7.08z"/>
                                                    </svg>
                                                    </i> Đã hủy
                                                </a>
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="display: flex; justify-content: center">
                        <img style="width: 50%; height: 50%" src="{{ URL::to('backend/dist/img/social-default.jpg') }}">
                    </div>
                    <h4 style="text-align: center; padding-bottom: 50px">Không có dữ liệu</h4>
                @endif
            </div>
        </div>
    </div>
    <style>
        .dropbtn {
            background-color: #4CAF50;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #fff;
            min-width: 180px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }

        .pagination {
            float: right;
        }
    </style>
@section('script')
    <script>
        @if(Session::has('success'))
        toastr.success('{{ Session::get('success') }}');
        @elseif(Session::has('error'))
        toastr.error('{{ Session::get('error') }}');
        @endif
    </script>
@endsection
@endsection
