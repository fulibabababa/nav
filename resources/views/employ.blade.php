@extends('layout')

@section('content')
    <section>

        <!-- Material form contact -->
        <div class="card">
            <div class="card-header bg-dark info-color white-text text-center py-4">
                <strong>自助</strong>
            </div>
            <!--Card content-->
            <div class="card-body px-lg-5">
                <p class="card-text">填写相关信息，发送申请。5-10分钟后系统自动检测友链位置，未检测到或超出前5名，则不收录或进入黑名单。进入很多</p>
                <form class="text-center" method="POST" action="{{route('employ.register')}}">
                    {{ csrf_field() }}
                    <div class="form-group mb-4">
                        <input type="text" class="form-control {{$errors->has('web_name')?'is-invalid':''}}"
                               placeholder="网站名称" name="web_name" value="{{ old('web_name') }}">
                        <div class="invalid-feedback">{{$errors->first('web_name')}}</div>
                    </div>

                    <div class="form-group mb-4">
                        <input type="text" class="form-control {{$errors->has('link')?'is-invalid':''}}"
                               placeholder="网站主页" name="link" value="{{ old('link') }}">
                        <div class="invalid-feedback">{{$errors->first('link')}}</div>
                    </div>

                    <div class="form-group">
                        <label>选择分类</label>
                        <select class="browser-default custom-select {{$errors->has('category_id')?'is-invalid':''}}"
                                name="category_id">
                            @foreach($categories as $key=>$category)
                                <option value="{{$category['id']}}"
                                @if(old('category_id') == $category['id'])
                                    {{'selected'}}
                                        @endif>{{$category['category_name']}}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">{{$errors->first('category_id')}}</div>
                    </div>


                    <!-- Send button -->
                    <button class="btn btn-danger btn-block" type="submit">申请</button>

                </form>
            </div>

        </div>
        <!-- Material form contact -->
    </section>
    <hr class="my-5"/>
    <section>
        <div class="card bg-dark white-text">
            <div class="card-header text-center py-4">
                <strong>申请记录</strong>
            </div>
            <div class="card-body">
                <div class="employ-list" id="comments-classic" role="tabpanel" aria-labelledby="comments-tab-classic">
                    @isset($links)
                        @foreach($links as $key=>$link)
                            <div class="media shadow-lg p-3">
                                <img class="avatar rounded-circle z-depth-1-half d-flex mr-3"
                                     src="{{asset('link/img/avatar/'.random_int(1,10).'.jpg')}}"
                                     alt="Generic placeholder image">
                                <div class="media-body">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mt-0 mb-1 font-weight-bold">{{$link->web_name}}</h5>
                                        <ul class="list-unstyled mb-1 pb-2">
                                            <li class="comment-date font-small font-weight-normal"><i
                                                        class="far fa-clock pr-2"></i>{{isset($link->created_at)?$link->created_at->format('d/m/Y'):'未知'}}
                                            </li>
                                        </ul>
                                    </div>
                                    <p class="font-weight-light mt-2 mb-4">{{$link->category->category_name}}
                                        &nbsp;&nbsp;&nbsp;&nbsp;{{$link['link']}}</p>
                                    <div>
                                        <button type="button"
                                                class="btn
                                                 @switch($link['status'])
                                                @case(-1)
                                                        btn-danger
                                                        @break
                                                @case(0)
                                                        btn-primary
                                                        @break
                                                @case(1)
                                                        btn-success
                                                        @break
                                                @default
                                                        btn-primary
                                                        @endswitch
                                                        btn-rounded btn-sm m-sm-0 mb-2 waves-effect waves-light">
                                            <i class="fas fa-share pr-1"></i>
                                            @switch($link['status'])
                                                @case(-1)
                                                黑名单
                                                @break
                                                @case(0)
                                                等待收录
                                                @break
                                                @case(1)
                                                已收录
                                                @break
                                                @default
                                                等待收录
                                            @endswitch
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>
                <nav class="employ-pagination mt-4">

                    <ul class="pagination justify-content-center pg-red mb-0">
                        {{$links->links()}}
                    </ul>
                </nav>
            </div>
        </div>

    </section>
@endsection