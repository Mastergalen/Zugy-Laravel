<?php $parent = \App\Category::find($id) ?>
<li class="dropdown-header">
    <a href="{{ action('ShopController@category', ['slug' => $parent->slug]) }}">{{ $parent->name }}</a>
</li>
@foreach(Category::getDirectSubCategories($parent) as $c)
    <li class="subcategory"><a href="{{ action('ShopController@category', ['slug' => $c->slug]) }}">{{ $c->name }}</a></li>
@endforeach