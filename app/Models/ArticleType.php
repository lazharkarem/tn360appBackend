<?php
namespace App\Models;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class ArticleType extends Model
{
    //
    use DefaultDatetimeFormat;
    use ModelTree;
    //table name
    protected $table = 'article_types';

    protected $fillable = ['title', 'parent_id', 'picture'];

    public function getList(){
        return $this->get();
    }
}
