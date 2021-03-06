@extends('layouts.master')

@section('title')
    Thêm mới đơn hàng
@endsection

@section('content')
    <div class="page-header">
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('orders.index')}}"><i class="icon-home2 position-left"></i> Quản lý đơn hàng</a>
                </li>
                <li class="active">Thêm mới</li>
            </ul>
        </div>
    </div>
    <div class="col-lg-12">
        <div style="margin-left: 15px;margin-right: 15px;margin-bottom: 50px" class="panel panel-flat">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="post" action="{{ route('orders.store') }}">
                    @csrf
                    <fieldset class="content-group">
                        <div class="form-group">
                            <label style="width: 15%" class="control-label col-lg-2">Khách hàng:<span
                                    style="color: red">*</span></label>
                            <div class="col-lg-10">
                                <select class="form-control"
                                        name="customer_id">
                                    @foreach($customers as $customer)
                                        <option value="{{$customer->_id}}">{{$customer->name}}</option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                <span style="color: red; font-size: 14px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="width: 15%" class="control-label col-lg-2">Chọn sản phẩm: <span
                                    style="color: red">*</span></label>
                            <div class="col-lg-10">
                                <select name="product_id[]" multiple="multiple"
                                        data-placeholder="Chọn sản phẩm" class="select-icons">
                                    @foreach($products as $product)
                                        <option value="{{$product->_id}}">{{$product->name}}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                <span style="color: red; font-size: 14px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="width: 15%" class="col-lg-2 control-label">Ghi chú:</label>
                            <div class="col-lg-10">
                                <input value="{{old('note')}}" type="text" name="note" class="form-control"
                                       placeholder="Nhập tên ghi chú">
                                @error('name')
                                <span style="color: red; font-size: 14px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <div style="float: right">
                        <a style="text-decoration: none; color: white; font-size: 16px; background: #E53935; padding: 7px 12px 7px 12px;"
                           href="{{ route('orders.index') }}">Huỷ bỏ</a>
                        <button type="submit"
                                style="text-decoration: none; color: white; font-size: 16px; background: #43A047; padding: 6px 10px 6px 10px;">
                            Thêm mới
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .icon-undefined {
            display: none;
        }
    </style>
@section('script')
    <script>
        $(document).ready(function () {
            $('.multi_select_product').select2();
        });
    </script>
@endsection
@endsection
