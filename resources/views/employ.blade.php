@extends('layout')

@section('content')
    <section>

        <!-- Material form contact -->
        <div class="card">
            <div class="card-header bg-dark info-color white-text text-center py-4">
                <strong>自助收录</strong>
            </div>
            <!--Card content-->
            <div class="card-body px-lg-5">
                <p class="card-text">填写相关信息，发送申请。<br/>
                    0.请严格按照该格式添加友链，a标签内容必须包含<strong>{{config('app.name')}}</strong>，a标签href必须和<strong>{{config('app.url')}}</strong>完全一致。
                    <br/>
                    示例：
                    <xmp><a href="{{config('app.url')}}">{{config('app.name')}}</a></xmp>
                    <br/>
                    1.新申请的每5分钟系统自动检测一次友链位置，未检测到或者超过前5名，则记失败1次，超过3次失败，进入黑名单。请确保添加好友链之后再申请。
                    <br/>
                    2.已成功收录的站点，每1小时检测一次，私自下链或者网站访问超时，超过3次失败，进入黑名单。
                    <br/>
                    3.随机巡查站点，发现站群、作弊等情况，永久加入黑名单，无法解封。
                    <br/>
                    4.进入黑名单的站点，唯一解封方式，发邮件到{{config('protect.email')}}申请解封。
                </p>
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