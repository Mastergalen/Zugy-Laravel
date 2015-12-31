<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    protected $table = 'categories';

    public $translatedAttributes = ['name', 'slug', 'meta_description'];

    static public function buildTree() { //TODO Hide categories with no children
        $refs = [];
        $list = [];

        $rows = Category::with('translations')->get();

        foreach($rows as $row) {
            $ref = & $refs[$row->id];

            $ref['id'] = $row->id;
            $ref['parent_id']  = $row->parent_id;
            $ref['name'] = $row->name;
            $ref['slug'] = $row->slug;

            if($row->parent_id == null) {
                $list[$row->id] = & $ref;
            } else {
                $refs[$row->parent_id]['children'][$row->id] = & $ref;
            }
        }

        return $list;
    }

    /**
     * @return mixed
     *
     * Print nested list of all categories
     */
    static public function printList() {
        $list = Category::buildTree();



        return self::toUL($list);
    }

    static private function toUL(array $array)
    {
        $html = '<ul class="list-group">' . PHP_EOL;

        foreach ($array as $value)
        {
            $html .= '<li class="list-group-item"><a href="' . localize_url('routes.shop.category', ['slug' => $value['slug']]) . '">' . $value['name'];
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
}
