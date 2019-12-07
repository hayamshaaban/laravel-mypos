@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.products')</h1>

        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{route('dashboard.products.index')}}"> @lang('site.products')</a></li>
            <li class="active"> @lang('site.add')</li>
            
        </ol>
        </section>

        <section class="content">

           <div class="box box-primary">
               <div class="box-header">
                   <h3 class="box-title">@lang('site.add')</h3>
               </div>
               <div class="box-body">
                @include('partials._errors')
                
               <form action="{{route('dashboard.products.store')}}" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                {{method_field('post')}}

                <div class="form-group">
                    <label>@lang('site.categories')</label>
                    <select name="category_id" class="form-control">
                    <option value="">@lang('site.all.categories')</option>
                
                    @foreach ($categories as $category )
                    <option value="{{$category->id}}" {{old('category_id')==$category->id ? 'selected' : ''}}>{{$category->name}}</option>
                    @endforeach
                </select>
                </div>

                @foreach (config('translatable.locales') as $locale)
                
                <div class="form-group">
                        <label>@lang('site.' .$locale. '.name')</label>
                <input type="text" name="{{$locale}}[name]"  class="form-control" value="{{old($locale.'.name')}}">
   
                    </div>
              
                    <div class="form-group">
                            <label>@lang('site.' .$locale.'.description')</label>
                    <textarea  name="{{$locale}}[description]"  class="form-control ckeditor" >{{old($locale.'.description')}}</textarea>
       
                        </div>
                    
                @endforeach
            </div>
            {{--image and image preview--}}
            <div class="form-group">
                    <label>@lang('site.image')</label>
                    <input type="file" name="image" placeholder="@lang('site.image')" class="form-control image">

            </div>
            <div class="form-group">
            <img src="{{asset('uploads/products_images/default.jpg')}}" style="width: 100px;" class="img-thumbnail image-preview" alt=""> 

            </div>
            <div class="form-group">
                    <label>@lang('site.purchase_price')</label>
                    <input type="number" name="purchase_price"  class="form-control" value="{{old('purchase_price')}}">

            </div>
            <div class="form-group">
                    <label>@lang('site.sale_price')</label>
                    <input type="number" name="sale_price" value="{{old('sale_price')}}" class="form-control">

            </div>
        
            <div class="form-group">
                    <label>@lang('site.stock')</label>
                    <input type="number" name="stock"  class="form-control" value="{{old('stock')}}">

            </div>

                
<!--
                        <div class="form-group">
                            <label>@lang('site.permissions')</label>
                            
                            <div class="nav-tabs-custom">
                                @php
                                   $models=['users','products','products'] ;
                                   $maps=['create','read','update','delete']
                                @endphp

                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                      @foreach ( $models as $index=>$model)
                                      <li class="nav-item">
                                      <a class="nav-link {{$index ==0 ? 'active' : ''}}" id="pills-home-tab" data-toggle="pill" href="#{{$model}}" role="tab" aria-controls="pills-home" aria-selected="true">@lang('site.' . $model)</a>
                                    </li>
                                          
                                      @endforeach      
                                    </ul>
                                          <div class="tab-content" id="pills-tabContent">
                                           @foreach ($models as $index=>$model)
                                          <div class="tab-pane {{$index==0 ? 'active' : ''}}" id="{{$model}}" role="tabpanel" aria-labelledby="pills-home-tab">
                                            @foreach ($maps as $map)
                                            <label><input type="checkbox" name="permissions[]" value="{{$map.'_'.$model}}">@lang('site.'.$map)</label>    
                                            @endforeach
                                              
                                            </div>
                                           @endforeach
                                            
                            </div>
                        </div>
                    -->


                        <div class="form-group">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i>@lang('site.add')</button>
                        </div>
    

              
                </form>





                </div> <!--end of body-->
           </div>
        </section>
    </div>


@endsection