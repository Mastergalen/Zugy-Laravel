<?php $cache = \App\Category::cacheMegaMenu($id) ?>
<li class="dropdown-header">
    <a href="{{ action('ShopController@category', ['slug' => $cache['parent']->slug]) }}">{{ $cache['parent']->name }}</a>
</li>
@foreach($cache['children'] as $c)
    <li class="subcategory"><a href="{{ action('ShopController@category', ['slug' => $c->slug]) }}">{{ $c->name }}</a></li>
@endforeach