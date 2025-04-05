@props(['categoryList_'])
<ul>
    @if (!empty($categoryList_))
    @foreach($categoryList_ as $categorylist)
    <li>
        <a href="{{ route('byCategory', $category) }}" class="category-list cursor-pointer block py-3 px-6">
            {{$categorylist->name}}
        </a>
    </li>
    @endforeach
</ul>
@endif