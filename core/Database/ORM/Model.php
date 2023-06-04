<?php

namespace Core\Database\ORM;

use Core\Database\Traits\HasAttributes;
use Core\Database\Traits\HasQueryBuilder;

abstract class Model
{
  use HasQueryBuilder, HasAttributes;

    protected $table;
    protected $fillable = [];
    protected $hidden=[];
    protected $casts = [];
    protected $primaryKey = 'id';
    protected $createdAt = 'created_at';
    protected $updatedAt = 'updated_at';
    protected $deletedAt = null;
    protected $collection = [];

}