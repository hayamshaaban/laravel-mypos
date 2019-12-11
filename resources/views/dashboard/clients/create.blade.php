@extends('layouts.dashboard.app')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">

            <h1>@lang('site.clients')</h1>

        <ol class="breadcrumb">
            <li><a href="{{route('dashboard.index')}}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{route('dashboard.clients.index')}}"> @lang('site.clients')</a></li>
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
                
               <form action="{{route('dashboard.clients.store')}}" method="POST" >
                {{csrf_field()}}
                {{method_field('post')}}
            <div class="form-group">
               <label >@lang('site.name')</label>
            <input type="text" name="name" class="form-control" value="{{old('name')}}">
            </div>
            @for($i=0; $i<2;$i++)
            <div class="form-group">
                <label >@lang('site.phone')</label>
                <input type="text" name="phone[]" class="form-control">
             </div> 
            @endfor
            
           
             <div class="form-group">
                <label >@lang('site.address')</label>
                <textarea name="address" class="form-control">{{old('address')}}</textarea>
             </div>
<!--
                        <div class="form-group">
                            <label>@lang('site.permissions')</label>
                            
                            <div class="nav-tabs-custom">
                                @php
                                   $models=['users','clients','products'] ;
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