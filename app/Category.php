<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use Translatable;

    protected $table = 'categories';

    public $translatedAttributes = ['name', 'slug', 'meta_description'];

    protected $casts = [
        'id' => 'integer',
        'parent_id' => 'integer',
    ];

    public function products() {
        return $this->belongsToMany('App\Product', 'products_to_categories');
    }

    static public function buildTree() {
        $refs = [];
        $list = [];

        $rows = Category::with('translations')->get();

        foreach($rows as $row) {
            $ref = & $refs[$row->id];

            $ref['id'] = $row->id;
            $ref['parent_id']  = $row->parent_id;
            $ref['position'] = $row->position;
            $ref['name'] = $row->name;
            $ref['slug'] = $row->slug;
            $ref['product_count'] = $row->products()->inStock()->count();

            if($row->parent_id == null) {
                $list[$row->id] = & $ref;
            } else {
                $refs[$row->parent_id]['children'][$row->id] = & $ref;

                //Update parent product count
                $parent = & $refs[$row->parent_id];
                while(1) {
                    $parent['product_count'] += $ref['product_count'];

                    if($parent['parent_id'] == null) break;
                    $parent = & $refs[$parent['parent_id']];
                }

                //FIXME If parent is added afterwards, it needs to sum up its existing children
            }
        }

        return $list;
    }

    /**
     * Print the category menu from cache if available
     *
     * @return mixed
     *
     * Print nested list of all categories
     */
    static public function printList() {
        return Cache::remember('ui.category-sidebar.lang-' . \Localization::getCurrentLocale(), 5, function() {
            //Sort by position column, 0 comes first
            $list = collect(Category::buildTree())->sortBy(function($menuItem, $key) {
                if($menuItem['position'] === null) return PHP_INT_MAX;
                else return $menuItem['position'];
            });

            return self::toUL($list->toArray());
        });
    }

    static private function toUL(array $array)
    {
        $html = '<ul class="list-group">' . PHP_EOL;

        foreach ($array as $value)
        {
            if($value['product_count'] == 0) continue; //Skip empty categories

            $html .= '<li class="list-group-item"><a href="' . localize_url('routes.shop.category', ['slug' => $value['slug']]) . '">' . "{$value['name']} ({$value['product_count']})";
            if (!empty($value['children']))
            {
                $html .= self::toUL($value['children']);
            }
            $html .= '</a></li>' . PHP_EOL;
        }

        $html .= '</ul>' . PHP_EOL;

        return $html;
    }

    static public function printSelect() {
        $tree = Category::buildTree();

        function printTree($tree, $depth = 0, $list = []) {
            foreach($tree as $t) {
                $dash = ($t['parent_id'] == 0) ? '' : str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $depth) .' ';
                $list[] =  [$t['id'], $dash . $t['name']];

                if(isset($t['children'])) {
                    $list = array_merge($list, printTree($t['children'], $depth + 1));
                }
            }
            return $list;
        }

        $result = printTree($tree);

        $array = [];

        foreach($result as $v) {
            $array[$v[0]] = $v[1];
        }

        return $array;
    }

    static public function getDirectSubCategories(self $category) {
        return self::where('parent_id', '=', $category->id)->get();
    }

    /**
     * Cache the categories menu
     *
     * 0 => [
     *     'parent' => []
     *     'children' => []
     * ]
     * @param $category_id int
     * @return array
     */
    static public function cacheMegaMenu($category_id) {
        $cache = Cache::remember('categories.menu.lang-' . \Localization::getCurrentLocale(), 5, function() {
            $categories = self::all();
            $return = [];

            foreach($categories as $parent) {
                $children = self::getDirectSubCategories($parent);

                $children->load('translations');

                $return[$parent->id] = [
                    'parent' => $parent,
                    'children' => $children
                ];
            }

            return $return;
        });

        return $cache[$category_id];
    }
}
