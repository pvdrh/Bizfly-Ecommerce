@extends('layouts.master')

@section('title')
    Thêm mới công ty
@endsection

@section('content')
    <div class="page-header">
        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('companies.index')}}"><i class="icon-home2 position-left"></i> Quản lý công ty</a>
                </li>
                <li class="active">Thêm mới</li>
            </ul>
        </div>
    </div>
    <div class="col-lg-12">
        <div style="margin-left: 15px;margin-right: 15px;margin-bottom: 50px" class="panel panel-flat">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="post"
                      action="{{route('companies.store')}}">
                    @csrf
                    <fieldset class="content-group">
                        <div class="form-group">
                            <label style="width: 14%" class="control-label col-lg-2">Tên công ty<span style="color: red">*</span>:</label>
                            <div class="col-lg-10">
                                <input value="{{old('name')}}" type="text" name="name" class="form-control"
                                       placeholder="Nhập tên công ty">
                                @error('name')
                                <span style="color: red; font-size: 14px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="width: 14%" class="control-label col-lg-2">Số điện thoại:</label>
                            <div class="col-lg-10">
                                <input value="{{old('phone')}}" type="text" name="phone"
                                       class="form-control"
                                       placeholder="Nhập số điện thoại">
                                @error('phone')
                                <span style="color: red; font-size: 14px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="width: 14%" class="control-label col-lg-2">Địa chỉ:</label>
                            <div class="col-lg-10">
                                <input value="{{old('address')}}" type="text" name="address"
                                       class="form-control"
                                       placeholder="Nhập địa chỉ">
                                @error('address')
                                <span style="color: red; font-size: 14px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <div style="float: right">
                        <a style="text-decoration: none; color: white; font-size: 16px; background: #E53935; padding: 7px 12px 7px 12px;" href="{{ route('companies.index') }}">Huỷ bỏ</a>
                        <button type="submit" style="text-decoration: none; color: white; font-size: 16px; background: #43A047; padding: 6px 10px 6px 10px;">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
