<?php
/**
 

 *

 *

 * -------




 */

namespace App\Observer;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CategoryObserver extends TranslatedModelObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  Category $category
     * @return void
     */
    public function deleting($category)
    {
		parent::deleting($category);
	
		// Delete all the Category's Posts
        $posts = Post::where('category_id', $category->id)->get();
        if ($posts->count() > 0) {
            foreach ($posts as $post) {
                $post->delete();
            }
        }
    
        // Don't delete the default pictures
        $defaultPicture = 'app/default/categories/fa-folder-' . config('settings.style.app_skin', 'skin-default') . '.png';
		$defaultSkinPicture = 'app/categories/' . config('settings.style.app_skin', 'skin-default') . '/';
        if (!str_contains($category->picture, $defaultPicture) && !str_contains($category->picture, $defaultSkinPicture)) {
            // Delete the category picture
            Storage::delete($category->picture);
        }
    
        // If the category is a parent category, delete all its children
        if ($category->parent_id == 0) {
			$subCats = Category::where('parent_id', $category->id)->get();
            if ($subCats->count() > 0) {
                foreach ($subCats as $subCat) {
					$subCat->delete();
                }
            }
        }
    }
    
    /**
     * Listen to the Entry saved event.
     *
     * @param  Category $category
     * @return void
     */
    public function saved(Category $category)
    {
        // Removing Entries from the Cache
        $this->clearCache($category);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  Category $category
     * @return void
     */
    public function deleted(Category $category)
    {
        // Removing Entries from the Cache
        $this->clearCache($category);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $category
     */
    private function clearCache($category)
    {
        Cache::flush();
    }
}
