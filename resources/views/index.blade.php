@extends('layout')

@section('content')
    <section class="friend-link">
        <a href="http://jufuli365.com?f=keerdh" data-web-name="天天">
            <div class="index-banner">
                <h3>{{isProduct()?'Baby扣穴':'Baby哈哈'}}</h3>
                <img src="{{isProduct()?asset('link/img/1.gif'):asset('link/img/back.jpg')}}" alt="Baby扣穴"/>
            </div>
        </a>
    </section>
    <section>
        @isset($categories)
            @foreach($categories as $key=>$category)
                <div class="card category_card bg-dark text-white z-depth-3 wow fadeIn">
                    <div class="card-header border-bottom border-white">
                        {{$category['category_name']}}
                    </div>
                    <div class="card-body">
                        <div class="row text-center friend-link">
                            @if($category->links->isNotEmpty())
                                @foreach($category->links as $i=>$link)
                                    <a href="{{isProduct()?$link['link']:'#'}}"
                                       data-web-name="{{$link['web_name']}}"
                                       class="btn
                                            @if($i==0)
                                               purple-gradient
                                            @else
                                               btn-black
                                            @endif
                                               ">
                                        <i class="far fa-thumbs-up" aria-hidden="true"></i>
                                        {{isProduct()?$link['web_name']:'哈哈哈哈'}}
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endisset
    </section>
@endsection