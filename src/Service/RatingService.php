<?php


namespace App\Service;


class RatingService
{
    public function getStarsRepartition(float $rating) {
        $repartition = [];

        $full = floor($rating);
        $half = round($rating - $full);
        $empty = 5 - $full - $half;

        $repartition["full"] = $full;
        $repartition["half"] = $half;
        $repartition["empty"] = $empty;

        return $repartition;
    }

}