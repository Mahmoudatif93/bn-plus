@extends('layouts.dashboard.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <h1>@lang('site.Cards')</h1>

        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> @lang('site.dashboard')</a></li>
            <li><a href="{{ route('dashboard.Cards.index') }}"> @lang('site.Cards')</a></li>
            <li class="active">@lang('site.add')</li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">

            <div class="box-header">
                <h3 class="box-title">@lang('site.add')</h3>
            </div><!-- end of box header -->
            <div class="box-body">

                @include('partials._errors')

                <form action="{{ route('dashboard.Cards.store') }}" method="post" enctype="multipart/form-data">

                    {{ csrf_field() }}
                    {{ method_field('post') }}

                    <div class="form-group col-6"> <label>@lang('site.Companies')</label>
                        <select name="company_id" id="company_id" class="form-control">
                            <option value="">@lang('site.Companies')</option>
                            @foreach ($Companies as $row)
                            <option value="{{ $row->id }}" {{ old('company_id') == $row->id ? 'selected' : '' }}>{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>


                  


                    <div class="form-group col-6" >
                        <label>@lang('site.price')</label>
                        <input type="number" name="card_price" class="form-control" value="{{ old('card_price') }}">
                    </div>
                    {{-- <div class="form-group col-6">
                                <label>@lang('site.card_code')</label>
                                <input type="text" name="card_code" class="form-control" value="{{ old('card_code') }}">
            </div>--}}
            


            <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="checkmanual" checked onclick="changeautomanual()">
                        <label class="form-check-label" for="flexRadioDefault1">
                        @lang('site.manual')
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="checkautomatic" onclick="changeautomanual()" >
                        <label class="form-check-label" for="flexRadioDefault2">
                        @lang('site.automatic')
                        </label>
                    </div>
            <div id="manual">
            <div class="form-group col-12" id="imagesa">


                <div class="form-group col-6" id="bouquet_div">
                    <div class="form-group col-6">
                        <label>@lang('site.card_code')</label>
                        <input type="text" name="card_code[]" class="form-control ">
                    </div>


                </div>

                <div class="form-group col-6">
                    <div class="input-group-append form-group">
                        <button class="btn btn-rounded btn-primary btn-sm" type="button" onclick="add_row();"><i class="fa fa-plus"></i>
                        </button>
                        <button class="btn btn-rounded btn-primary btn-sm " type="button" onclick="remove_row();"><i class="fa fa-minus"></i>
                        </button>

                    </div>

                </div>


            </div>
            </div>


            <div class="form-group col-6" style="display:none" id="automatic">
            <label>@lang('site.importcard')</label>
                     <input type="file" name="file" class="form-control" >

            </div>

            {{-- <div class="form-group col-6">
                                <label>@lang('site.amounts')</label>
                                <input type="number" name="amounts" class="form-control" value="{{ old('amounts') }}">
        </div>

        --}}

        <div class="form-group col-6">
            <label>@lang('site.image')</label>
            <input type="file" name="card_image" class="form-control" value="{{ old( 'card_image') }}">
        </div>
        <div class="form-group col-6">
            <label>@lang('site.offer')</label>
            <input class="form-check-input" name="offer" type="checkbox">

        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> @lang('site.add')</button>
        </div>

        </form><!-- end of form -->

</div><!-- end of box body -->

</div><!-- end of box -->

</section><!-- end of content -->

</div><!-- end of content wrapper -->


<script>
    function add_row() {

        var frist_input = document.getElementById("bouquet_div").firstElementChild.outerHTML;



        $('#bouquet_div').append(frist_input);

    }

    function remove_row() {
        var last_input = document.getElementById("bouquet_div").lastChild;

        var len = $('#bouquet_div input').length;
        console.log('len :: ' + len);
        if (len >= 2) {
            document.getElementById("bouquet_div").removeChild(last_input);

        }

    }

    function changeautomanual(){
       
       if( document.getElementById("checkmanual").checked == true){
        document.getElementById("automatic").style.display = "none";
        document.getElementById("manual").style.display = "block";
           
       }else{
        document.getElementById("manual").style.display = "none";
        document.getElementById("automatic").style.display = "block";
        
       }

    }
</script>
@endsection