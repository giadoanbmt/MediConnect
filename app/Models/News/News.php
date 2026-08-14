<?php

namespace App\Models\News;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Doctor\Doctor; 


class News extends Model
{
    use HasFactory;

    protected $table = 'News';

    // Các trường được phép Mass Assignment
    protected $fillable = [
        'title',
        'slug',
        'content',
        'summary',
        'image',
        'doctor_id',
        'admin_id',
        'category',
        'views',
        'status',   // 'published', 'draft', 'pending'
    ];

    protected $casts = [
        'views' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'views' => 0,
        'status' => 'published',
    ];

    



    
    //  Lấy bài viết đã xuất bản
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    
    //  Lấy danh sách bài viết nổi bật
    public function scopePopular($query, $limit = 3)
    {
        return $query->orderBy('views', 'desc')->take($limit);
    }

    
    //   Lọc theo chuyên mục
    public function scopeByCategory($query, $category)
    {
        if (!empty($category)) {
            return $query->where('category', $category);
        }
        return $query;
    }


    // Tìm kiếm bài viết theo từ khóa
    public function scopeSearch($query, $keyword)
    {
        if (!empty($keyword)) {
            return $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('content', 'like', "%{$keyword}%")
                  ->orWhere('category', 'like', "%{$keyword}%");
            });
        }
        return $query;
    }
    
    // Khai báo khoá ngoại
     
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}