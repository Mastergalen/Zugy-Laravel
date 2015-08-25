<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    public function description() {
        return $this->hasOne('App\CategoryDescription');
    }

    static public function buildTree() {
        $refs = [];
        $list = [];

        $rows = Category::with(['description' => function ($query) {
            $query->where('language_id', '=', auth()->user()->settings()->language);
        }])->get()->toArray();

        foreach($rows as $row) {
            $ref = & $refs[$row['id']];

            $ref['id'] = $row['id'];
            $ref['parent_id']  = $row['parent_id'];
            $ref['name'] = $row['description']['name'];

            if($row['parent_id'] == null) {
                $list[$row['id']] = & $ref;
            } else {
                $refs[$row['parent_id']]['children'][$row['id']] = & $ref;
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
            $html = '<ul>' . PHP_EOL;

            foreach ($array as $value)
            {
                $html .= '<li>' . $value['name'];
                if (!empty($value['children']))
                {
                    $html .= toUL($value['children']);
                }
                $html .= '</li>' . PHP_EOL;
            }

            $html .= '</ul>' . PHP_EOL;

            return $html;
        }

        return toUL($list);
    }

    static public function printSelect() {
        $tree = Category::buildTree();

        function printTree($tree, $r = 0, $p = null) {
            foreach ($tree as $i => $t) {
                $dash = ($t['parent_id'] == 0) ? '' : str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $r) .' ';
                printf("\t<option value='%d'>%s%s</option>\n", $t['id'], $dash, $t['name']);
                if ($t['parent_id'] == $p) {
                    // reset $r
                    $r = 0;
                }
                if (isset($t['children'])) {
                    printTree($t['children'], ++$r, $t['parent_id']);
                }
            }
        }

        return printTree($tree);

    }
}
