@extends('layouts.master')

@section('title')
    Thêm mới danh mục
@endsection

@section('content')
    <div class="page-header">

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="{{route('categories.index')}}"><i class="icon-home2 position-left"></i> Quản lý danh
                        mục</a>
                </li>
                <li class="active">Thêm mới</li>
            </ul>
        </div>
    </div>
    <div class="col-lg-12">
        <div style="margin-left: 15px;margin-right: 15px;margin-bottom: 50px" class="panel panel-flat">
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="post" action="{{ route('categories.store') }}">
                    @csrf
                    <fieldset class="content-group">
                        <div class="form-group">
                            <label style="width: 15%;" class="control-label col-lg-2">Tên danh mục:<span style="color: red">*</span></label>
                            <div class="col-lg-10">
                                <input value="{{old('name')}}" type="text" name="name"
                                       class="form-control"
                                       placeholder="Nhập tên danh mục">
                                @error('name')
                                <span style="color: red; font-size: 14px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label style="width: 15%;" class="control-label col-lg-2">Mô tả:</label>
                            <div class="col-lg-10">
                                <input value="{{old('description')}}" type="text" name="description"
                                       class="form-control"
                                       placeholder="Nhập mô tả">
                                @error('description')
                                <span style="color: red; font-size: 14px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </fieldset>
                    <div style="float: right">
                        <a style="text-decoration: none; color: white; font-size: 16px; background: #E53935; padding: 7px 12px 7px 12px;"
                           href="{{ route('categories.index') }}">Huỷ bỏ</a>
                        <button type="submit"
                                style="text-decoration: none; color: white; font-size: 16px; background: #43A047; padding: 6px 10px 6px 10px;">
                            Thêm mới
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
