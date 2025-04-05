@props(['categoryList'])
@if (!empty($categoryList))
<ul role="menu" class="sub-menu">
    @foreach($categoryList as $category)
    <li>
        <a href="{{ route('byCategory', $category) }}" class="">
            {{$category->name}}
        </a>
        @if (!empty($category->children))
        <ul style="margin-top: 10px; border-top: 1px solid #fff;">
            @foreach($category->children as $child)
            <li>
                <a href="{{ route('byCategory', $child) }}" class="category-list-chil cursor-pointer block py-3 px-6">
                    {{$child->name}}
                </a>
            </li>
            @endforeach
        </ul>
        @endif
    </li>
    @endforeach
</ul>
@endif