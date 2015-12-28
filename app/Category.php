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

        function toUL(array $array)
        {
            $html = '<ul class="list-group">' . PHP_EOL;

            foreach ($array as $value)
            {
                $html .= '<li class="list-group-item"><a href="' . localize_url('routes.shop.category', ['slug' => $value['slug']]) . '">' . $value['name'];
                if (!empty($value['children']))
                {
                    $html .= toUL($value['children']);
                }
                $html .= '</a></li>' . PHP_EOL;
            }

            $html .= '</ul>' . PHP_EOL;

            return $html;
        }

        return toUL($list);
    }

    static public function printSelect() {
        $tree = Category::buildTree();

        function printTree($tree, $r = 0, $p = null, $list = []) {
            foreach ($tree as $i => $t) {
                $dash = ($t['parent_id'] == 0) ? '' : str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $r) .' ';
                $list[$t['id']] =  $dash . $t['name'];
                //printf("\t<option value='%d'>%s%s</option>\n", $t['id'], $dash, $t['name']);
                if ($t['parent_id'] == $p) {
                    // reset $r
                    $r = 0;
                }
                if (isset($t['children'])) {
                    return printTree($t['children'], ++$r, $t['parent_id'], $list);
                }
            }

            return $list;
        }

        return printTree($tree);
    }
}
