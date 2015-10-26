<?php
/**
 * User: Galen Han
 * Date: 18.09.2015
 * Time: 15:07
 */

namespace Zugy\Repos\Category;

use App\CategoryTranslation;
use App\Exceptions\NoTranslationException;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Zugy\Repos\DbRepository;
use App\Category;

class DbCategoryRepository extends DbRepository implements CategoryRepository
{
    /**
     * @var Category
     */
    private $model;

    /**
     * DbCategoryRepository constructor.
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function children($categoryId)
    {
        $categories = $this->model->all();

        return $this->recurseChildren($categories, $categoryId);
    }

    private function recurseChildren($categories, $parentId) {
        $children = $categories->where('parent_id', $parentId);

        if($children->count() === 0) return [$parentId];

        $ids = [$parentId];

        foreach($children as $c) {
            $ids = array_merge($ids, $this->recurseChildren($categories, $c->id));
        }

        return $ids;
    }

    public function getBySlug($slug) {
        $category = CategoryTranslation::where('slug', '=', $slug)
            ->where('locale', '=', LaravelLocalization::getCurrentLocale())->first();

        if(is_null($category)) {
            throw new NoTranslationException();
        }

        $category = $this->model->find($category->category_id);

        return $category;
    }

}