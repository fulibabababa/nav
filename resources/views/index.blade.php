@extends('layout')

@section('content')
    <section>
        @isset($categories)
            @foreach($categories as $key=>$category)
                <div class="card category_card bg-dark text-white z-depth-3 wow fadeIn">
                    <div class="card-header border-bottom border-white">
                        {{$category['category_name']}}
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            @if($category->links->isNotEmpty())
                                @foreach($category->links as $i=>$link)
                                    <button href="{{isProduct()?$link['href']:'#'}}" type="button"
                                            class="btn btn-danger">{{isProduct()?$link['web_name']:'哈哈哈哈'}}</button>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset
    </section>
@endsection