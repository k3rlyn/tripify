<?php

namespace App\Models;

use CodeIgniter\Model;

class RatingModel extends Model
{
    protected $table = 'rating';
    protected $primaryKey = 'ratingId';
    protected $allowedFields = ['userId', 'wisataId', 'rating'];

    public function calculateAverageRating($wisataId)
    {
        $result = $this->selectAvg('rating')
                    ->where('wisataId', $wisataId)
                    ->first();
        return round($result['rating'], 1);
    }

    public function getTotalReviews($wisataId)
    {
        return $this->where('wisataId', $wisataId)->countAllResults();
    }
}