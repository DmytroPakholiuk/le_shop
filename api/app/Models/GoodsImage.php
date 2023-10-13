<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \Illuminate\Database\Query\Builder
 *
 * @property int $id
 * @property string $path
 * @property int $size
 * @property int $height
 * @property int $width
 * @property int $goods_id
 * @property string $created_at
 * @property string $updated_at
 * @property-read Goods $goods
 */
class GoodsImage extends Model
{
    use HasFactory;

    protected $table = "goods_images";

    protected $fillable = [];

    public function goods()
    {
        return $this->belongsTo(Goods::class, "goods_id", "id");
    }
}
