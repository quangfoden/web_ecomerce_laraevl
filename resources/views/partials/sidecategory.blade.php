@if (!empty($categoryList))
<div class="left-sidebar" data-aos="fade-right">
    <h2 class="box-title">Danh Mục</h2>
    <div class="panel-group category-products" id="accordian">
        @foreach($categoryList as $category)
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordian" href="#{{$category->id}}">
                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                        {{$category->name}}
                    </a>
                </h4>
            </div>
            @if (!empty($category->children))
            <div id="{{$category->id}}" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul>
                    @foreach($category->children as $child)
                        <li><a href="{{ route('byCategory', $child) }}">{{$child->name}}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endif