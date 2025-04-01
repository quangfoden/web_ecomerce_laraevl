@props(['categoryList'])

@if (!empty($categoryList))
@foreach($categoryList as $category)
<li class="category-item relative">
    <a href="{{ route('byCategory', $category) }}" class="category-list cursor-pointer block py-3 px-6">
        {{$category->name}}
    </a>
    <x-category-list class="absolute left-0 top-[100%] z-50 hidden flex-col" :category-list="$category->children" />
</li>
@endforeach
@endif