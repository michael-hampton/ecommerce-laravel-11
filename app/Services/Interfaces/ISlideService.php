<?php

namespace App\Services\Interfaces;

interface ISlideService
{
    public function createSlide(array $data);
    public function updateSlide(array $data, int $id);
    public function deleteSlide(int $id);
    public function toggleActive(int $id);
}
