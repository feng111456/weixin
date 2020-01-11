<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table    = 'material';
    protected $primaryKey = 'material_id';
    public $timestamps = false;
    /**白名单 */
    //protected $fillable = ['name'];//允许被批量赋值
    /**黑名单 */
    protected $guarded = [];//不允许被批量赋值
}
